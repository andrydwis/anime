<x-layouts.app>
    <div class="flex flex-col gap-8">
        <x-animes.menu />

        <div class="flex flex-col gap-2">
            <div
                class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
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
                    variant="filled"
                    icon="eye"
                    class="!hidden lg:!flex"
                    href="{{ route('anime.recent.index') }}"
                >
                    Lihat Semua
                </flux:button>
            </div>
            <div class="grid gap-2 md:grid-cols-2 lg:grid-cols-4">
                @foreach ($home['data']['recent']['animeList'] as $anime)
                    <x-cards.anime :anime="$anime" />
                @endforeach
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <div
                class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-col">
                    <flux:heading
                        size="xl"
                        level="h1"
                        class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                    >
                        Event Wibu
                    </flux:heading>
                    <flux:subheading level="h2">
                        Informasi terbaru event wibu yang akan datang
                    </flux:subheading>
                </div>
                <flux:button
                    variant="filled"
                    icon="eye"
                    class="!hidden lg:!flex"
                >
                    Lihat Semua
                </flux:button>
            </div>
            <div class="grid gap-2 md:grid-cols-2 lg:grid-cols-4">
                <x-cards.event />
            </div>
        </div>

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
                    variant="filled"
                    icon="eye"
                    class="!hidden lg:!flex"
                >
                    Lihat Semua
                </flux:button>
            </div>
            <div class="grid gap-2 md:grid-cols-2 lg:grid-cols-4">
                <x-cards.news />
            </div>
        </div>
    </div>
</x-layouts.app>
