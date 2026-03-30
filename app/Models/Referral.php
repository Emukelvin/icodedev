<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'commission' => 'decimal:2',
        'clicks' => 'integer',
    ];

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referred(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    /**
     * Get conversion count for this referrer.
     */
    public function getConversionsCountAttribute(): int
    {
        return static::where('referrer_id', $this->referrer_id)
            ->whereNotNull('referred_id')
            ->count();
    }
}
