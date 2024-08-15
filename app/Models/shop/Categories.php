<?php

namespace App\Models\shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories'; // Pastikan ini sesuai dengan nama tabel di database

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'is_visible',
        'description',
        'position',
        'seo_title',
        'seo_description',
    ];

    // Definisi relasi ke produk (satu kategori memiliki banyak produk)
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Definisi relasi parent (kategori induk)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'parent_id');
    }

    // Definisi relasi children (kategori anak)
    public function children(): HasMany
    {
        return $this->hasMany(Categories::class, 'parent_id');
    }
}
