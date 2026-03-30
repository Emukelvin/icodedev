<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'technologies' => 'array',
        'budget' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'start_date' => 'date',
        'deadline' => 'date',
        'completed_at' => 'date',
        'is_portfolio' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function developers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_developers')->withPivot('role')->withTimestamps();
    }

    public function updates(): HasMany
    {
        return $this->hasMany(ProjectUpdate::class)->latest();
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ProjectComment::class)->whereNull('parent_id')->latest();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'in_progress' => 'blue',
            'review' => 'purple',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'review' => 'Under Review',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => 'Unknown',
        };
    }
}
