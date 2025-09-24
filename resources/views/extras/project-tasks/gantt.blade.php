<div class="px-2">
    <div class="" wire:ignore x-data x-init="
                new Gantt('#gantt', {{ json_encode($gantt_tasks) }}, { readonly: true, view_mode: 'Week',infinite_padding: false, view_mode_select: true})
            ">
        <div class="px-4 border w-full" id="gantt"></div>
    </div>
</div>
