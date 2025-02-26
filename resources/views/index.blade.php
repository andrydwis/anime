<x-layouts.app>
    <div class="flex flex-col gap-8">
        {{-- <div class="hidden md:block">
            <img
                src="{{ asset('images/cta/shrine.jpg') }}"
                alt="shrine"
                class="aspect-[3/1] rounded-lg object-cover"
            >
        </div> --}}

        <div class="grid gap-2 md:grid-cols-2 lg:grid-cols-4">
            <flux:button
                variant="filled"
                icon="users"
                href="/wibunitas"
            >
                Wibunitas
                <flux:badge color="emerald">Baru!</flux:badge>
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
                icon="bookmark"
                href="/anime/bookmark"
            >
                Daftar Anime Saya
            </flux:button>
            <flux:button
                variant="filled"
                icon="sparkles"
                href="/gacha"
            >
                Gachamon
                <flux:badge color="emerald">Baru!</flux:badge>
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
                        Anime Sedang Berjalan
                    </flux:heading>
                    <flux:subheading level="h2">
                        Update terbaru anime season ini
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
            <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-5">
                @foreach ($home['data']['ongoing']['animeList'] as $anime)
                    <a href="{{ $anime['href'] }}">
                        <div
                            class="group relative flex flex-col overflow-hidden rounded-lg">
                            <img
                                loading="lazy"
                                src="{{ $anime['poster'] }}"
                                alt="cover"
                                class="aspect-video object-cover transition-all hover:scale-110 hover:brightness-50"
                            >
                            <flux:badge
                                variant="solid"
                                color="emerald"
                                icon="play-circle"
                                class="pointer-events-none absolute right-2 top-2"
                            >
                                Eps {{ $anime['episodes'] }}
                            </flux:badge>
                            <flux:button
                                variant="filled"
                                icon="play"
                                class="pointer-events-none !absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 !rounded-full !bg-white/50 !text-white opacity-0 transition-all group-hover:opacity-100"
                            />
                            <div
                                class="pointer-events-none absolute bottom-0 w-full bg-white/75 p-2 dark:bg-zinc-900/50">
                                <flux:heading class="line-clamp-1 group-hover:underline">
                                    {{ $anime['title'] }}
                                </flux:heading>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
