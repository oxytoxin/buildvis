@props(['value'])

<label {{ $attributes->merge(['class' => 'block pl-4 mb-1 text-sm font-medium']) }}>
    {{ $value ?? $slot }}
</label>
