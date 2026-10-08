<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'phone', 'district', 'subject', 'vegetable',
        'message', 'status', 'admin_notes', 'source_page',
        'ip_address', 'contacted_at', 'assigned_to',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];

    const STATUS_NEW        = 'new';
    const STATUS_CONTACTED  = 'contacted';
    const STATUS_FOLLOW_UP  = 'follow_up';
    const STATUS_RESOLVED   = 'resolved';
    const STATUS_CLOSED     = 'closed';

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW       => 'नया',
            self::STATUS_CONTACTED => 'संपर्क किया',
            self::STATUS_FOLLOW_UP => 'फॉलो अप',
            self::STATUS_RESOLVED  => 'हल हुआ',
            self::STATUS_CLOSED    => 'बंद',
        ];
    }

    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'new'        => 'danger',
            'contacted'  => 'info',
            'follow_up'  => 'warning',
            'resolved'   => 'success',
            'closed'     => 'secondary',
            default      => 'secondary',
        };
    }
}
