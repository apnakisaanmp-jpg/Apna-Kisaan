<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SeoMeta extends Model
{
    protected $fillable = [
        'page_key', 'meta_title', 'meta_description', 'meta_keywords',
        'og_title', 'og_description', 'og_image', 'canonical_url', 'robots',
    ];

    public static function forPage(string $pageKey): ?static
    {
        return Cache::remember("seo_{$pageKey}", 3600, function () use ($pageKey) {
            return static::where('page_key', $pageKey)->first();
        });
    }
}
