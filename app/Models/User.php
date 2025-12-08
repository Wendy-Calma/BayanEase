<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'surname',
        'middle_name',
        'nick_name',
        'email',
        'phone_number',
        'complete_address',
        'barangay_id_number',
        'password',
        'is_active',
        'birth_month',
        'birth_day',
        'birth_year',
        'birth_province',
        'birth_city',
        'citizenship',
        'gender',
        'civil_status',
        'religion',
        'education_occupation',
        'spouse_name',
        'father_name',
        'mother_name',
        'residency_type',
        'residency_years',
        'id_picture',
        'digital_signature',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }

    public function assignedRequests()
    {
        return $this->hasMany(DocumentRequest::class, 'assigned_to');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function dependents()
    {
        return $this->hasMany(Dependent::class);
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRole($query, $roleName)
    {
        return $query->whereHas('role', function ($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }


    public function scopeAdmins($query)
    {
        return $query->role('admin');
    }

    // Helper Methods
    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'admin';
    }


    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function updateLastLogin(): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);
    }
}