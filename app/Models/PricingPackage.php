<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PricingPackage extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
