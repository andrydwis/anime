<x-layouts.app>
    <div class="relative flex flex-col gap-8">
        {{-- <img
            src="{{ asset('images/cta/shrine.jpg') }}"
            alt="shrine"
            class="rounded-lg"
        > --}}

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
            </flux:button>
        </div>

        <flux:separator />

        <div class="flex flex-col gap-4">
            <div
                class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-col">
                    <flux:heading
                        size="xl"
                        level="h1"
                        class="!text-accent !font-bold"
                    >
                        Anime Sedang Berjalan
                    </flux:heading>
                    <flux:subheading
                        size="lg"
                        level="h2"
                        class="!font-semibold"
                    >
                        Update terbaru anime season ini
                    </flux:subheading>
                </div>
                <flux:button
                    variant="filled"
                    icon="eye"
                >
                    Lihat Semua
                </flux:button>
            </div>
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                @foreach ($home['data']['ongoing']['animeList'] as $anime)
                    <a href="{{ $anime['href'] }}">
                        <div
                            class="group relative flex flex-col overflow-hidden rounded-lg">
                            <img
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
                                class="pointer-events-none !absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 !text-white opacity-0 group-hover:opacity-100"
                            >

                                <flux:icon.play variant="solid" />
                                Mulai
                            </flux:button>
                            <div
                                class="pointer-events-none absolute bottom-0 w-full bg-white/75 p-2 dark:bg-slate-800/75">
                                <flux:heading
                                    class="line-clamp-1 !font-semibold group-hover:underline"
                                >
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
