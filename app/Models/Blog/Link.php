<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Link extends Model
{
    use HasFactory;
    use HasTranslations;

      public $translatable = [
        'title',
        'description',
    ];


    protected $fillable = [
        'id',
        'url',
        'title',
        'description',
        'color',
        'image',
        'created_at',
        'updated_at',
    ];


    protected $table = 'blog_links';
}
