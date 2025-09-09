<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Task;

class CreateProjectTasksObserver
{
    public function created(Project $project): void
    {
        $today = today();
        $tomorrow = today()->addDay();
        $task = Task::create([
            'project_id' => $project->id,
            'title' => 'SITE PREPARATION',
            'weight' => 0,
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
        $task->children()->create([
            'project_id' => $project->id,
            'title' => 'Clearing of lot',
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
        $task->children()->create([
            'project_id' => $project->id,
            'title' => 'Demolition of existing structures',
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
        $task->children()->create([
            'project_id' => $project->id,
            'title' => 'Filling and soil compaction (leveling)',
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
        $task = Task::create([
            'project_id' => $project->id,
            'title' => 'FOUNDATION WORK',
            'weight' => 0,
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
        $task->children()->create([
            'project_id' => $project->id,
            'title' => 'Layout marking of the house plan',
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
        $task->children()->create([
            'project_id' => $project->id,
            'title' => 'Excavation',
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
        $task->children()->create([
            'project_id' => $project->id,
            'title' => 'Concrete pouring for footings and foundation walls',
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
        $task = Task::create([
            'project_id' => $project->id,
            'title' => 'ROOFING WORKS',
            'weight' => 0,
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
        $task->children()->create([
            'project_id' => $project->id,
            'title' => 'Installation of roof framing',
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
        $task->children()->create([
            'project_id' => $project->id,
            'title' => 'Roof covering installation',
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
        $task->children()->create([
            'project_id' => $project->id,
            'title' => 'Waterproofing and insulation',
            'start_date' => $today,
            'end_date' => $tomorrow,
        ]);
    }

    public function deleting(Project $project): void
    {
        $project->tasks()->delete();
    }
}
