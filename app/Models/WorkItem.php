<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkItem extends Model
{
    public function work_category()
    {
        return $this->belongsTo(WorkCategory::class);
    }
}
