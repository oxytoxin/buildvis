<div class="px-2">
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.umd.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.css">
    @endpush
    <div class="" wire:ignore x-data x-init="
                new Gantt('#gantt', {{ json_encode($gantt_tasks) }}, { readonly: true, view_mode: 'Week',infinite_padding: false, view_mode_select: true})
            ">
        <div class="px-4 border w-full" id="gantt"></div>
    </div>
</div>
