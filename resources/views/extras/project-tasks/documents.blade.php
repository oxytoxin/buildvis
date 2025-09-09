<div class="px-4">
    @forelse($project->documents as $document)
        <div class="flex items-center gap-8">
            <h4>{{ $document->name }}</h4>
            <a href="{{ $document->getUrl() }}" class="underline text-sm text-green-700 font-semibold"
               target="_blank">Download</a>
        </div>
    @empty
        <h4>No documents uploaded for this project.</h4>
    @endforelse
</div>
