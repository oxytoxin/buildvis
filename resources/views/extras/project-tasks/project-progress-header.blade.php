<div class="p-4 flex justify-between">
    @include('extras.project-tasks.project-progress-details')
    <div>
        @foreach($this->table->getHeaderActions() as $action)
            {{ $action->render() }}
        @endforeach
    </div>

</div>
