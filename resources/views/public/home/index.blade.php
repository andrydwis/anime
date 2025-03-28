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
                <flux:text>
                    Kumpulan tools dan fitur gratis lainnya untuk membantu kamu
                </flux:text>
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
                <flux:text>
                    Update terbaru anime season ini
                </flux:text>
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
            @foreach (array_slice($home['data']['recent']['animeList'], 0, 12) as $anime)
                <x-cards.anime :anime="$anime" />
            @endforeach
            <flux:button
                icon="eye"
                class="col-span-2 !flex md:col-span-4 lg:col-span-6 lg:!hidden"
                href="{{ route('anime.recent.index') }}"
            >
                Lihat Semua
            </flux:button>
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
                    <flux:text>
                        Informasi terbaru event yang akan datang
                    </flux:text>
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
                <flux:button
                    icon="eye"
                    class="col-span-2 !flex md:col-span-4 lg:!hidden"
                    href="{{ route('events.index') }}"
                >
                    Lihat Semua
                </flux:button>
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
                    <flux:text>
                        Berita terbaru seputar anime, manga, game, dan lainnya
                    </flux:text>
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
                <flux:button
                    icon="eye"
                    class="col-span-2 !flex md:col-span-4 lg:!hidden"
                    href="{{ route('news.index') }}"
                >
                    Lihat Semua
                </flux:button>
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
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
            });
        </script>
    @endpush
</x-layouts.app>
