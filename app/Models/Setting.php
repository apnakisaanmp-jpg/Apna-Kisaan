<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type', 'label'];

    /**
     * Get a setting value by key with optional default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $value = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : null;
        });

        return $value ?? $default;
    }

    /**
     * Set a setting value.
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting_{$key}");
    }

    /**
     * Get all settings as key-value array.
     */
    public static function getAllCached(): array
    {
        return Cache::remember('all_settings', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Flush all settings cache.
     */
    public static function flushCache(): void
    {
        Cache::forget('all_settings');
        // Individual keys are forgotten on update
    }
}
