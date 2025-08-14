<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project_manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }
}
