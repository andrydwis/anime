<x-layouts.app>
    <div class="flex flex-col gap-8">
        <div class="grid gap-2 lg:grid-cols-4">
            <flux:button
                variant="filled"
                icon="users"
                href="/Wibunity"
            >
                Wibunity
                <flux:badge
                    size="sm"
                    color="emerald"
                >
                    Baru!
                </flux:badge>
            </flux:button>
            <flux:button
                variant="filled"
                icon="bookmark"
                href="/anime/bookmark"
            >
                Daftar Anime Saya
            </flux:button>
            <flux:button
                variant="filled"
                icon="calendar-date-range"
                href="/events"
            >
                Event Wibu
            </flux:button>
            <flux:button
                variant="filled"
                icon="newspaper"
                href="/news"
            >
                Berita Terbaru
            </flux:button>
            <flux:button
                variant="filled"
                icon="sparkles"
                href="/gacha"
                class="lg:col-span-4"
            >
                Gachamon
                <flux:badge
                    size="sm"
                    color="red"
                >
                    Segera!
                </flux:badge>
            </flux:button>
        </div>

        <flux:separator />

        <div class="flex flex-col gap-4">
            <div
                class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
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
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                @foreach ($home['data']['recent']['animeList'] as $anime)
                    <x-cards.anime :anime="$anime" />
                @endforeach
            </div>
        </div>

        <flux:separator />

        <div class="flex flex-col gap-4">
            <div
                class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
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
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <x-cards.event />
            </div>
        </div>

        <flux:separator />

        <div class="flex flex-col gap-4">
            <div
                class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
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
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <x-cards.news />
            </div>
        </div>
    </div>
</x-layouts.app>
