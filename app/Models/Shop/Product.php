<?php

namespace App\Models\Shop;

use App\Models\Shop\Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'brands_id',
        'categories_id',
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'media',
        'qty',
        'security_stock',
        'featured',
        'is_visible',
        'old_price',
        'price',
        'cost',
        'type',
        'backorder',
        'requires_shipping',
        'published_at',
        'seo_title',
        'seo_description',
        'weight_value',
        'weight_unit',
        'height_value',
        'height_unit',
        'width_value',
        'width_unit',
        'depth_value',
        'depth_unit',
        'volume_value',
        'volume_unit',
        'image',
    ];


    protected $casts = [
        'featured' => 'boolean',
        'is_visible' => 'boolean',
        'backorder' => 'boolean',
        'requires_shipping' => 'boolean',
        'published_at' => 'date',
    ];

    protected $table = 'products';

    protected $guarded = [];

    public function brands(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }

    public function registerMediaCollections(): void
{
    $this->addMediaCollection('product-images')
         ->singleFile();
}


}
