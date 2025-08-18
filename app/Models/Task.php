<?php

namespace App\Models;

use App\Enums\ProjectTaskStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $casts = [
        'status' => ProjectTaskStatuses::class,
        'start_date' => 'immutable_date',
        'end_date' => 'immutable_date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
