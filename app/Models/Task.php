<?php

namespace App\Models;

use App\Enums\ProjectTaskStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SolutionForest\FilamentTree\Concern\ModelTree;

class Task extends Model
{
    use ModelTree;

    protected $casts = [
        'status' => ProjectTaskStatuses::class,
        'start_date' => 'immutable_date',
        'end_date' => 'immutable_date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public static function getTreeLabelAttribute(): string
    {
        return 'name';
    }

    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }
}
