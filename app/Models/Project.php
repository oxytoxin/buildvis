<?php

namespace App\Models;

use App\Enums\ProjectTaskStatuses;
use App\Observers\CreateProjectTasksObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[ObservedBy([CreateProjectTasksObserver::class])]
class Project extends Model implements \Spatie\MediaLibrary\HasMedia
{
    use InteractsWithMedia;

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Media::class, 'model_id')->where('collection_name', 'documents');
    }

    public function pending_tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id')->where('status', ProjectTaskStatuses::PENDING);
    }

    public function completed_tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id')->where('status', ProjectTaskStatuses::COMPLETED);
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
