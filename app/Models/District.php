<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class District extends Model
{
    protected $fillable = [
        'name', 'name_en', 'slug', 'region',
        'gradient_class', 'description', 'market_info',
        'featured_image', 'is_featured', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($district) {
            if (empty($district->slug)) {
                $district->slug = Str::slug($district->name_en ?? $district->name);
            }
        });
    }

    // ── Scopes ─────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // ── Route model binding ─────────────────────────────────
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
