<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap"
          rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="shuffle-for-tailwind.png">
    @vite(['resources/css/app.css'])
</head>

<body class="antialiased bg-body text-body font-body">
{{ $slot }}

@livewire('notifications')
@filamentScripts
</body>

</html>
