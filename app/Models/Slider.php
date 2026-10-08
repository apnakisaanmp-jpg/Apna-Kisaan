<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title', 'image', 'link_url', 'alt_text', 'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return $this->image ? asset('storage/' . $this->image) : asset('assets/images/placeholder.png');
    }
}
