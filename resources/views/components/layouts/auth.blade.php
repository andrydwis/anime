<!doctype html>
<html>

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
        <title>
            Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru
            Seputar Anime
        </title>
        <meta
            name="title"
            content="Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru Seputar Anime"
        />
        <meta
            name="description"
            content="Weaboo.my.id adalah tempat terbaik untuk nonton anime gratis, bergabung dengan komunitas wibu, dan mendapatkan informasi terkini seputar dunia anime. Temukan anime favoritmu di sini!"
        />
        <meta
            name="keywords"
            content="nonton anime, komunitas wibu, anime gratis, anime terbaru, berita anime, weaboo, anime indonesia, streaming anime, forum wibu, anime terbaik"
        >

        <!-- Open Graph / Facebook -->
        <meta
            property="og:type"
            content="website"
        />
        <meta
            property="og:url"
            content="https://metatags.io/"
        />
        <meta
            property="og:title"
            content="Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru Seputar Anime"
        />
        <meta
            property="og:description"
            content="Weaboo.my.id adalah tempat terbaik untuk nonton anime gratis, bergabung dengan komunitas wibu, dan mendapatkan informasi terkini seputar dunia anime. Temukan anime favoritmu di sini!"
        />
        <meta
            property="og:image"
            content="https://metatags.io/images/meta-tags.png"
        />

        <!-- Twitter -->
        <meta
            property="twitter:card"
            content="summary_large_image"
        />
        <meta
            property="twitter:url"
            content="https://metatags.io/"
        />
        <meta
            property="twitter:title"
            content="Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru Seputar Anime"
        />
        <meta
            property="twitter:description"
            content="Weaboo.my.id adalah tempat terbaik untuk nonton anime gratis, bergabung dengan komunitas wibu, dan mendapatkan informasi terkini seputar dunia anime. Temukan anime favoritmu di sini!"
        />
        <meta
            property="twitter:image"
            content="https://metatags.io/images/meta-tags.png"
        />

        {{-- Font --}}
        <link
            rel="preconnect"
            href="https://fonts.bunny.net"
        >
        <link
            href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap"
            rel="stylesheet"
        />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
        @stack('styles')
    </head>

    <body class="selection:bg-accent/50 min-h-screen bg-white dark:bg-zinc-900">
        <flux:main
            container
            class="flex min-h-screen items-center justify-center"
        >
            {{ $slot }}
        </flux:main>

        @stack('scripts')
        @fluxScripts
    </body>

</html>
