<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'technologies' => 'array',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function pricingPackages(): HasMany
    {
        return $this->hasMany(PricingPackage::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
