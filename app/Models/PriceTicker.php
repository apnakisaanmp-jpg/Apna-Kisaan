<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceTicker extends Model
{
    protected $fillable = [
        'commodity_name', 'commodity_en', 'icon_class',
        'price', 'unit', 'trend', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price'     => 'decimal:2',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
