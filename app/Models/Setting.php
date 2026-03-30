<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = ['id'];

    protected static string $cacheKey = 'site_settings';

    public static function get(string $key, $default = null)
    {
        $settings = static::getAllCached();
        return $settings[$key] ?? $default;
    }

    public static function set(string $key, $value, string $group = 'general'): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        static::clearCache();
    }

    public static function getAllCached(): array
    {
        return Cache::remember(static::$cacheKey, 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function clearCache(): void
    {
        Cache::forget(static::$cacheKey);
    }
}
