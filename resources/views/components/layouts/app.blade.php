@props(['title' => null, 'description' => null, 'keywords' => null, 'image' => null])
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        />

        <link
            rel="icon"
            href="{{ asset('favicon.ico') }}"
            type="image/x-icon"
        >

        <!-- Primary Meta Tags -->
        @if (!$title)
            <title>
                Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru
                Seputar Anime
            </title>
            <meta
                name="title"
                content="Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru Seputar Anime"
            />
        @else
            <title>
                Weaboo.my.id - {{ $title }}
            </title>
            <meta
                name="title"
                content="Weaboo.my.id -{{ $title }}"
            />
        @endif
        @if (!$description)
            <meta
                name="description"
                content="Weaboo.my.id adalah tempat terbaik untuk nonton anime gratis, bergabung dengan komunitas wibu, dan mendapatkan informasi terkini seputar dunia anime. Temukan anime favoritmu di sini!"
            />
        @else
            <meta
                name="description"
                content="{{ $description }}"
            />
        @endif
        @if (!$keywords)
            <meta
                name="keywords"
                content="nonton anime, komunitas wibu, anime gratis, anime terbaru, berita anime, weaboo, anime indonesia, streaming anime, forum wibu, anime terbaik"
            >
        @else
            <meta
                name="keywords"
                content="{{ $keywords }}"
            >
        @endif
        <meta
            name="robots"
            content="index, follow"
        />

        <!-- Open Graph / Facebook -->
        <meta
            property="og:type"
            content="website"
        />
        <meta
            property="og:url"
            content="{{ config('app.url') }}"
        />
        @if (!$title)
            <meta
                property="og:title"
                content="Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru Seputar Anime"
            />
        @else
            <meta
                property="og:title"
                content="Weaboo.my.id - {{ $title }}"
            />
        @endif
        @if (!$description)
            <meta
                property="og:description"
                content="Weaboo.my.id adalah tempat terbaik untuk nonton anime gratis, bergabung dengan komunitas wibu, dan mendapatkan informasi terkini seputar dunia anime. Temukan anime favoritmu di sini!"
            />
        @else
            <meta
                property="og:description"
                content="{{ $description }}"
            />
        @endif
        @if (!$image)
            <meta
                property="og:image"
                content="{{ asset('images/seo/cover.jpg') }}"
            />
        @else
            <meta
                property="og:image"
                content="{{ $image }}"
            />
        @endif

        <!-- Twitter -->
        <meta
            property="twitter:card"
            content="summary_large_image"
        />
        <meta
            property="twitter:url"
            content="{{ config('app.url') }}"
        />
        @if (!$title)
            <meta
                property="twitter:title"
                content="Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru Seputar Anime"
            />
        @else
            <meta
                property="twitter:title"
                content="Weaboo.my.id - {{ $title }}"
            />
        @endif
        @if (!$description)
            <meta
                property="twitter:description"
                content="Weaboo.my.id adalah tempat terbaik untuk nonton anime gratis, bergabung dengan komunitas wibu, dan mendapatkan informasi terkini seputar dunia anime. Temukan anime favoritmu di sini!"
            />
        @else
            <meta
                property="twitter:description"
                content="{{ $description }}"
            />
        @endif
        @if (!$image)
            <meta
                property="twitter:image"
                content="{{ asset('images/seo/cover.jpg') }}"
            />
        @else
            <meta
                property="twitter:image"
                content="{{ $image }}"
            />
        @endif

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
        @stack('styles')
    </head>

    <body class="selection:bg-accent/50 min-h-screen bg-white dark:bg-zinc-900">
        <x-headers.app />
        <x-sidebars.app />

        <flux:main
            container
            class="flex h-full flex-col gap-8"
        >
            {{ $slot }}

            <x-footers.app />
        </flux:main>

        @stack('scripts')
        @fluxScripts
    </body>

</html>
