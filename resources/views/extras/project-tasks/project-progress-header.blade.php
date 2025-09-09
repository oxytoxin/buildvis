<div class="flex justify-between">
    @include('extras.project-tasks.project-progress-details')
    @isset($this->table)
        <div>
            @foreach($this->table->getHeaderActions() as $action)
                {{ $action->render() }}
            @endforeach
        </div>
    @endisset

</div>
