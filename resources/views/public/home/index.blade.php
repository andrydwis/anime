<x-layouts.app>
    <div class="relative -mx-6 py-4 md:mx-0">
        <img
            src="{{ asset('images/cta/home.jpg') }}"
            alt="cta"
            class="aspect-[4/3] object-cover brightness-50 md:aspect-video"
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
        <div class="grid gap-2">
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
        <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
            @foreach ($home['data']['recent']['animeList'] as $anime)
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
</x-layouts.app>
