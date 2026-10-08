<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FarmerRegistration extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type', 'name', 'mobile',
        'district', 'village', 'main_crop', 'farm_area',
        'business_type', 'city', 'required_crop', 'required_quantity',
        'status', 'admin_notes', 'ip_address',
    ];

    protected $casts = [
        'farm_area'         => 'decimal:2',
        'required_quantity' => 'decimal:2',
    ];

    const TYPE_FARMER = 'farmer';
    const TYPE_BUYER  = 'buyer';

    public static function statuses(): array
    {
        return [
            'new'       => 'नया',
            'contacted' => 'संपर्क किया',
            'active'    => 'सक्रिय',
            'inactive'  => 'निष्क्रिय',
        ];
    }

    public function scopeFarmers($query)
    {
        return $query->where('type', self::TYPE_FARMER);
    }

    public function scopeBuyers($query)
    {
        return $query->where('type', self::TYPE_BUYER);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }

    public function getTypeLabel(): string
    {
        return $this->type === self::TYPE_FARMER ? 'किसान' : 'खरीदार';
    }
}
