<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkCategory extends Model
{
    public function work_items()
    {
        return $this->hasMany(WorkItem::class);
    }
}
