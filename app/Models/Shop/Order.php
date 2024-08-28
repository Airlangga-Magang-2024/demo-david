<?php

namespace App\Models\Shop;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,
    SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'total_price',
        'status',
        'currency',
        'shipping_price',
        'shipping_method',
        'notes',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    /** @return MorphOne<OrderAddress> */
    public function address(): MorphOne
    {
        return $this->morphOne(OrderAddress::class, 'addressable');
    }

    /** @return BelongsTo<Customer,self> */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /** @return HasMany<OrderItem> */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Menghitung total harga dari order berdasarkan item yang ada.
     *
     * @return float
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->qty * $item->unit_price;
        }) ;
    }

    /**
     * Menghitung biaya pengiriman berdasarkan berat total dari order.
     *
     * @return float
     */
    public function getShippingPriceAttribute(): float
    {
        $baseShippingCost = 10.0;

        // Dapatkan total berat order dengan menjumlahkan berat setiap item
        $totalWeight = $this->items->sum(function ($item) {
            if ($item->product) {
                return $item->qty * $item->product->weight;
            }

            // Jika produk tidak ada, asumsikan beratnya nol
            return 0;
        }) ;

        $additionalCostPerKg = 2.0;
        $shippingCost = $baseShippingCost + ($totalWeight * $additionalCostPerKg);

        $minimumShippingCost = 10.0;

        return max($shippingCost, $minimumShippingCost);
    }

    /**
     * Hook model untuk memperbarui total_price dan shipping_price sebelum menyimpan.
     */
    protected static function booted()
    {
        static::saving(function (Order $order) {
            // Perbarui total_price dan shipping_price sebelum disimpan
            $order->total_price = $order->getTotalPriceAttribute();
            $order->shipping_price = $order->getShippingPriceAttribute();
        });
    }

    // /** @return HasMany<Payment> */
    // public function payments(): HasMany
    // {
    //     return $this->hasMany(Payment::class);
    // }


}
