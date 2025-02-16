@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'pl-4 text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
