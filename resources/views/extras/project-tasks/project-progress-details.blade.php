<div class="font-semibold">
    <h4 class="text-lg">Project Progress</h4>
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
        @if($tasks_count > 0)
            <h5>{{ round($completed_tasks_count/$tasks_count * 100, 2) }}%</h5>
        @else
            <h5>N/A</h5>
        @endif
    </div>
</div>
