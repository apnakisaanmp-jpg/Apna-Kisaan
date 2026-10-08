<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'role',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // ── Scopes ─────────────────────────────────────────────
    public function scopeAdmins($query)
    {
        return $query->whereIn('role', ['admin', 'superadmin']);
    }

    // ── Helpers ────────────────────────────────────────────
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    // ── Relationships ──────────────────────────────────────
    public function assignedContacts()
    {
        return $this->hasMany(Contact::class, 'assigned_to');
    }

    public function assignedBookings()
    {
        return $this->hasMany(TransportBooking::class, 'assigned_to');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
