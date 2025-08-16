<div class="font-semibold">
    <h4 class="text-lg">Project Progress</h4>
    <div class="flex gap-2">
        <h5>Tasks Done:</h5>
        <h5>{{ $completed_tasks_count }}/{{ $tasks_count }}</h5>
    </div>
    <div class="flex gap-2">
        <h5>Overall Progress:</h5>
        <h5>{{ round($completed_tasks_count/$tasks_count * 100, 2) }}%</h5>
    </div>
</div>
