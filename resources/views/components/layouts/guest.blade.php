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
<div class="">
    <section x-data="{ mobileNavOpen: false }" class="overflow-hidden">
        <div class="bg-teal-900">
            <nav class="mx-4 py-6">
                <div class="container mx-auto px-4">
                    <div class="relative flex items-center justify-center">
                        <a href="{{ route('welcome') }}" class="inline-block">
                            <img class="h-32" src="images/logo-transparent.png" alt="">
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </section>
    <section class="relative pb-64 md:pb-16 pt-16 sm:pt-24 overflow-hidden">
        <a href="#" class="absolute top-0 left-0 ml-5 mt-12 inline-block"></a>
        <img class="absolute left-0 w-48 lg:w-64 rounded-r-2xl hidden sm:block"
             src="https://images.unsplash.com/photo-1603239564387-c5b5ea6f635e?crop=entropy&amp;cs=srgb&amp;fm=jpg&amp;ixid=M3wzMzIzMzB8MHwxfHNlYXJjaHw4fHxjb25zdHJ1Y3Rpb258ZW58MHwxfHx8MTczOTQ2OTkyOHww&amp;ixlib=rb-4.0.3&amp;q=85&amp;w=1920"
             alt="">
        <img class="hidden sm:block absolute top-0 right-0 w-48 lg:w-64 mt-8 rounded-l-2xl"
             src="https://images.unsplash.com/photo-1566350321650-83c2b8e587a9?crop=entropy&amp;cs=srgb&amp;fm=jpg&amp;ixid=M3wzMzIzMzB8MHwxfHNlYXJjaHwyfHxjb25zdHJ1Y3Rpb258ZW58MHwyfHx8MTczOTQ2OTQ3Mnww&amp;ixlib=rb-4.0.3&amp;q=85&amp;w=1920"
             alt="">
        <img class="hidden md:block absolute bottom-0 right-0 mr-12 xl:mr-20 w-44 lg:w-64 rounded-2xl"
             src="https://images.unsplash.com/photo-1600645896997-3c00e14c0b23?crop=entropy&amp;cs=srgb&amp;fm=jpg&amp;ixid=M3wzMzIzMzB8MHwxfHNlYXJjaHw4fHxjb25zdHJ1Y3Rpb258ZW58MHwyfHx8MTczOTQ2OTQ3Mnww&amp;ixlib=rb-4.0.3&amp;q=85&amp;w=1920"
             alt="">
        <div class="pb-28">
            {{ $slot }}
        </div>
    </section>
</div>
</body>

</html>
