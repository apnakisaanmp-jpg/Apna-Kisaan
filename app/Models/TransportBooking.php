<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportBooking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'booking_number', 'pickup_location', 'delivery_location',
        'vehicle_type', 'crop_name', 'quantity', 'preferred_date',
        'mobile', 'notes', 'status', 'admin_notes',
        'estimated_cost', 'driver_name', 'driver_phone', 'vehicle_number',
        'ip_address', 'assigned_to',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'quantity'       => 'decimal:2',
        'estimated_cost' => 'decimal:2',
    ];

    const STATUS_PENDING    = 'pending';
    const STATUS_CONFIRMED  = 'confirmed';
    const STATUS_IN_TRANSIT = 'in_transit';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_CANCELLED  = 'cancelled';

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING    => 'प्रतीक्षित',
            self::STATUS_CONFIRMED  => 'पुष्टि हुई',
            self::STATUS_IN_TRANSIT => 'मार्ग में',
            self::STATUS_DELIVERED  => 'वितरित',
            self::STATUS_CANCELLED  => 'रद्द',
        ];
    }

    public static function vehicleTypes(): array
    {
        return [
            'truck'  => 'ट्रक',
            'pickup' => 'छोटा वाहन (पिकअप)',
            'cold'   => 'कोल्ड ट्रांसपोर्ट',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = 'BK-' . strtoupper(substr(uniqid(), -6)) . '-' . date('dmY');
            }
        });
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }

    public function getVehicleLabelAttribute(): string
    {
        return self::vehicleTypes()[$this->vehicle_type] ?? $this->vehicle_type;
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'warning',
            'confirmed'  => 'info',
            'in_transit' => 'primary',
            'delivered'  => 'success',
            'cancelled'  => 'danger',
            default      => 'secondary',
        };
    }
}
