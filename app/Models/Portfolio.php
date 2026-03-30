<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'technologies' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'completion_date' => 'date',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/placeholder.jpg');
    }
}
