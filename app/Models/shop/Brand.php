<?php

namespace App\Models\shop;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'website',
        'is_visible',
        'description',
        // Tambahkan atribut lain sesuai kebutuhan
    ];

   


}
