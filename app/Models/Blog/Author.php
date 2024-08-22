<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'photo',
        'bio',
        'github_handle',
        'twitter_handle',
    ];

    /**
     * @var string
     */
    protected $table = 'blog_authors';

    /** @return HasMany<Post> */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'blog_author_id');
    }
}
