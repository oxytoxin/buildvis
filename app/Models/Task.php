<?php

namespace App\Models;

use App\Enums\ProjectTaskStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $casts = [
        'status' => ProjectTaskStatuses::class,
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
