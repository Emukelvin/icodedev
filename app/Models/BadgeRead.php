<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadgeRead extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'badge_type', 'last_read_at'];

    protected $casts = [
        'last_read_at' => 'datetime',
    ];

    public static function markRead(int $userId, string $badgeType): void
    {
        static::updateOrCreate(
            ['user_id' => $userId, 'badge_type' => $badgeType],
            ['last_read_at' => now()]
        );
    }

    public static function getLastRead(int $userId, string $badgeType): ?\DateTimeInterface
    {
        return static::where('user_id', $userId)
            ->where('badge_type', $badgeType)
            ->value('last_read_at');
    }
}
