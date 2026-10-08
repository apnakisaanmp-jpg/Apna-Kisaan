<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CropCategory extends Model
{
    protected $fillable = [
        'name', 'name_en', 'slug', 'icon_class',
        'icon_bg', 'icon_color', 'link_url', 'examples',
        'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function ($cat) {
            if (empty($cat->slug)) {
                $cat->slug = Str::slug($cat->name_en ?? $cat->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
