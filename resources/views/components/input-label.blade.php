@props(['value'])

<label {{ $attributes->merge(['class' => 'block mb-1 text-sm font-medium']) }}>
    {{ $value ?? $slot }}
</label>
