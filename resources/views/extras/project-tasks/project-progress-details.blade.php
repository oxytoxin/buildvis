<div class="font-semibold text-sm px-3">
    <p>Project Manager: {{ $project->project_manager?->name ?? 'Unassigned' }}</p>
    <p>Contact #: {{ $project->project_manager?->phone_number ?? 'N/A' }}</p>
    <div class="flex gap-2">
        <h5>Tasks Done:</h5>
        @if($tasks_count > 0)
            <h5>{{ $completed_tasks_count }}/{{ $tasks_count }}</h5>
        @else
            <h5>No tasks created for this project.</h5>
        @endif
    </div>
    <div class="flex gap-2">
        <h5>Overall Progress:</h5>
        <h5>{{ round($progress, 2) }}%</h5>
    </div>
</div>
