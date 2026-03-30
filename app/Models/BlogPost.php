<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogPost extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
        'allow_comments' => 'boolean',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class)->whereNull('parent_id')->where('is_approved', true)->latest();
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(BlogComment::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('published_at', '<=', now());
    }

    public function getImageUrlAttribute(): string
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : asset('images/blog-placeholder.jpg');
    }

    public function getReadTimeAttribute(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->body)) / 200));
    }
}
