@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 mb-2 outline-none ring-offset-0 focus:ring-2 focus:ring-lime-500 shadow rounded-full']) }}>
