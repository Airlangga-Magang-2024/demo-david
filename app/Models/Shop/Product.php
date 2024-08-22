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
