<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'phone', 'avatar', 'company', 'bio', 'role', 'github_id', 'google_id', 'two_factor_enabled', 'two_factor_secret', 'two_factor_recovery_codes', 'timezone', 'language', 'is_active', 'last_login_at', 'last_login_ip'])]
#[Hidden(['password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManager(): bool
    {
        return in_array($this->role, ['admin', 'manager']);
    }

    public function isDeveloper(): bool
    {
        return $this->role === 'developer';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'manager', 'developer']);
    }

    public function clientProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function managedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'manager_id');
    }

    public function assignedProjects()
    {
        return $this->belongsToMany(Project::class, 'project_developers');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=fff';
    }
}
