<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conversation extends Model
{
    protected $guarded = ['id'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function unreadCountFor(User $user): int
    {
        $participant = $this->participants()->where('user_id', $user->id)->first();
        if (!$participant) return 0;

        $lastRead = $participant->pivot->last_read_at;

        return $this->messages()
            ->where('user_id', '!=', $user->id)
            ->when($lastRead, fn($q) => $q->where('created_at', '>', $lastRead))
            ->count();
    }
}
