<x-layouts.app>
    <div class="relative -mx-6 py-4 md:mx-0">
        <img
            src="{{ asset('images/cta/home.jpg') }}"
            alt="cta"
            class="aspect-square object-cover brightness-50 md:aspect-video"
        >
        <div
            class="absolute inset-0 bg-gradient-to-b from-white from-5% via-transparent to-white to-95% dark:from-zinc-800 dark:to-zinc-800">

        </div>
        <div
            class="absolute left-1/2 top-1/2 flex w-full -translate-x-1/2 -translate-y-1/2 flex-col gap-2 px-6 backdrop-blur md:w-1/2 lg:px-8">
            <flux:heading
                size="xl"
                level="h1"
                class="text-center !text-2xl !font-bold !text-white lg:!text-4xl"
            >
                Nonton Anime Tanpa Iklan Cuma di
                <span
                    class="from-accent !bg-gradient-to-br to-cyan-600 bg-clip-text !text-transparent"
                >
                    Weaboo.my.id
                </span>
            </flux:heading>
            <flux:modal.trigger name="search">
                <flux:input
                    as="button"
                    placeholder="Cari anime..."
                    icon="magnifying-glass"
                />
            </flux:modal.trigger>

            <div class="swiper w-full">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <flux:callout
                            icon="sparkles"
                            color="emerald"
                        >
                            <flux:callout.heading>Yuk Cobain Waifu AI 🙋🏻‍♀️
                            </flux:callout.heading>
                            <flux:callout.text>
                                Bingung mau nonton anime apa, coba tanya Waifu AI aja,
                                kamu akan
                                diberikan rekomendasi anime yang cocok buat kamu.
                                @auth
                                    <flux:modal.trigger name="ai">
                                        <flux:callout.link>
                                            Coba Sekarang
                                        </flux:callout.link>
                                    </flux:modal.trigger>
                                @else
                                    <flux:callout.link href="{{ route('login') }}">
                                        Coba Sekarang
                                    </flux:callout.link>
                                @endauth
                            </flux:callout.text>
                        </flux:callout>
                    </div>
                    <div class="swiper-slide">
                        <flux:callout
                            icon="link"
                            color="cyan"
                        >
                            <flux:callout.heading>Fitur Baru, Short Link Generator 🚀
                            </flux:callout.heading>
                            <flux:callout.text>
                                Buat short link kamu sendiri, biar lebih mudah diingat dan
                                dibagikan.
                                <flux:callout.link
                                    href="{{ route('tools.short-links.index') }}"
                                >
                                    Buat Sekarang
                                </flux:callout.link>
                            </flux:callout.text>
                        </flux:callout>
                    </div>
                    <div class="swiper-slide">
                        <flux:callout
                            icon="video-camera"
                            color="cyan"
                        >
                            <flux:callout.heading>Fitur Baru, Social Media Video
                                Downloader 🚀
                            </flux:callout.heading>
                            <flux:callout.text>
                                Download video dari social media favorit kamu, praktis dan
                                cepat.
                                <flux:callout.link
                                    href="{{ route('tools.social-media-video-downloader.index') }}"
                                >
                                    Coba Sekarang
                                </flux:callout.link>
                            </flux:callout.text>
                        </flux:callout>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-animes.menu />

    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    Tools Lainnya
                </flux:heading>
                <flux:subheading level="h2">
                    Kumpulan tools dan fitur gratis lainnya untuk membantu kamu
                </flux:subheading>
            </div>
        </div>
        <div class="grid gap-2 md:grid-cols-2">
            <flux:button
                icon="link"
                href="{{ route('tools.short-links.index') }}"
            >
                Short Link
                <flux:badge
                    size="sm"
                    color="emerald"
                >
                    Baru!
                </flux:badge>
            </flux:button>
            <flux:button
                icon="video-camera"
                href="{{ route('tools.social-media-video-downloader.index') }}"
            >
                Social Media Video Downloader
                <flux:badge
                    size="sm"
                    color="emerald"
                >
                    Baru!
                </flux:badge>
            </flux:button>
        </div>
    </div>

    {{-- <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    Anime Spotlight
                </flux:heading>
                <flux:subheading level="h2">
                    Anime yang sedang trending
                </flux:subheading>
            </div>
        </div>
        <div class="swiper w-full">
            <div class="swiper-wrapper">
                @foreach ($home['spotlight_animes'] as $anime)
                    <div class="swiper-slide">
                        <x-cards.app
                            class="relative aspect-[3/1] overflow-hidden !border-0"
                            style="background-image: url({{ $anime['image'] }}); background-size: cover; background-position: center; background-repeat: no-repeat;"
                        >
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-white via-white/75 to-transparent dark:from-zinc-900 dark:via-zinc-900/75">
                            </div>
                            <div class="flex h-full flex-col">
                                <div class="z-50 mt-auto flex flex-col gap-2">
                                    <div class="flex flex-col">
                                        <flux:heading
                                            size="xl"
                                            class="line-clamp-2 w-1/2 !text-2xl !font-bold lg:!text-4xl"
                                        >
                                            {{ $anime['title'] }}
                                        </flux:heading>
                                        <flux:subheading class="line-clamp-3 w-1/2">
                                            {{ $anime['description'] }}
                                        </flux:subheading>
                                    </div>
                                    <flux:button
                                        variant="filled"
                                        icon="play"
                                        href="{{ route('anime.show', ['anime' => $anime['id']]) }}"
                                        class="w-max"
                                    >
                                        Tonton Sekarang
                                    </flux:button>
                                </div>
                            </div>
                        </x-cards.app>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

    <video
        id="vid"
        onloadeddata="unm2()"
        class="videodiv"
        controls=""
        autoplay=""
        playsinline=""
        crossorigin="anonymous"
    >
        <source
            src="https://cg.animeheaven.me/video.mp4?02a1dc090c8e03b6e515110ac6b7ab23&amp;6b067f7ec4724560d0896c969b8a9645"
            type="video/mp4"
            onerror="xhr(event)"
        >
        <source
            src="https://cc.animeheaven.me/cc/video.mp4?02a1dc090c8e03b6e515110ac6b7ab23&amp;6b067f7ec4724560d0896c969b8a9645&amp;err2a"
            type="video/mp4"
        >
        <source
            src="https://e2.animeheaven.me/e2/video.mp4?02a1dc090c8e03b6e515110ac6b7ab23&amp;6b067f7ec4724560d0896c969b8a9645&amp;err3"
            type="video/mp4"
        >
        Your browser does not support HTML video.
    </video>

    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    Anime Terbaru
                </flux:heading>
                <flux:subheading level="h2">
                    Update terbaru anime season ini
                </flux:subheading>
            </div>
            <flux:button
                icon="eye"
                class="!hidden lg:!flex"
                href="{{ route('anime.recent.index') }}"
            >
                Lihat Semua
            </flux:button>
        </div>
        <div class="grid grid-cols-2 gap-2 md:grid-cols-4 lg:grid-cols-6">
            @foreach ($home['animes'] as $anime)
                <x-cards.anime :anime="$anime" />
            @endforeach
        </div>
    </div>

    @if ($events?->isNotEmpty())
        <div class="flex flex-col gap-2">
            <div
                class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-col">
                    <flux:heading
                        size="xl"
                        level="h1"
                        class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                    >
                        Event
                    </flux:heading>
                    <flux:subheading level="h2">
                        Informasi terbaru event yang akan datang
                    </flux:subheading>
                </div>
                <flux:button
                    icon="eye"
                    class="!hidden lg:!flex"
                    href="{{ route('events.index') }}"
                >
                    Lihat Semua
                </flux:button>
            </div>
            <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
                @foreach ($events as $event)
                    <x-cards.event :event="$event" />
                @endforeach
            </div>
        </div>
    @endif

    @if ($news?->isNotEmpty())
        <div class="flex flex-col gap-2">
            <div
                class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-col">
                    <flux:heading
                        size="xl"
                        level="h1"
                        class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                    >
                        Berita Terbaru
                    </flux:heading>
                    <flux:subheading level="h2">
                        Berita terbaru seputar anime, manga, game, dan lainnya
                    </flux:subheading>
                </div>
                <flux:button
                    icon="eye"
                    href="{{ route('news.index') }}"
                    class="!hidden lg:!flex"
                >
                    Lihat Semua
                </flux:button>
            </div>
            <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
                @foreach ($news as $newsData)
                    <x-cards.news :news="$newsData" />
                @endforeach
            </div>
        </div>
    @endif

    @push('styles')
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
        />
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            const swiper = new Swiper(".swiper", {
                spaceBetween: 8,
                grabCursor: true,
                loop: true,
                // autoplay: {
                //     delay: 2000,
                //     disableOnInteraction: false,
                // },
            });
        </script>
    @endpush
</x-layouts.app>
