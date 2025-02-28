<x-layouts.app>
    <div class="flex flex-col gap-8">
        <flux:breadcrumbs class="flex-wrap">
            <flux:breadcrumbs.item
                icon="home"
                href="{{ route('home') }}"
            />
            <flux:breadcrumbs.item href="{{ route('anime.index') }}">
                Anime
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="!line-clamp-1">
                {{ $anime['data']['title'] }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a
            href="{{ route('anime.episode.show', ['anime' => $animeId, 'episode' => $anime['data']['episodeList'][0]['episodeId']]) }}"
            class="group relative aspect-video overflow-hidden rounded-lg"
        >
            <img
                src="{{ $anime['data']['poster'] }}"
                alt="cover"
                class="aspect-video h-full w-full object-cover brightness-50"
            >
            <flux:button
                variant="filled"
                icon="play"
                class="pointer-events-none !absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 !rounded-full !bg-white/50 !text-white opacity-0 transition-all group-hover:border-2 group-hover:border-white group-hover:opacity-100"
            />
            <div
                class="pointer-events-none absolute bottom-0 w-full bg-white/75 p-2 dark:bg-zinc-900/50">
                <flux:heading class="line-clamp-1 text-center group-hover:underline">
                    Klik untuk melihat episode
                    {{ $anime['data']['episodeList'][0]['title'] }}
                </flux:heading>
            </div>
        </a>

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
                        Daftar Episode
                    </flux:heading>
                    <flux:subheading level="h2">
                        Semua episode anime {{ $anime['data']['title'] }}
                    </flux:subheading>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2 lg:grid-cols-6">
                @php
                    $sortedEpisodes = collect($anime['data']['episodeList'])->sortBy(
                        'title',
                    );
                @endphp
                @foreach ($sortedEpisodes as $episode)
                    <flux:button
                        variant="filled"
                        icon="play-circle"
                        class="w-full"
                        href="{{ route('anime.episode.show', ['anime' => $animeId, 'episode' => $episode['episodeId']]) }}"
                    >
                        {{ $episode['title'] }}
                    </flux:button>
                @endforeach
            </div>
        </div>

        <flux:separator />

        <x-cards.app>
            <div class="grid gap-4 lg:grid-cols-4">
                <div class="group relative overflow-hidden rounded-lg">
                    <img
                        src="{{ $anime['data']['poster'] }}"
                        alt="cover"
                        class="aspect-[2/3] object-cover transition-all group-hover:scale-110 group-hover:brightness-50"
                    >
                </div>
                <div class="flex flex-col gap-2 lg:col-span-3">
                    <flux:heading
                        size="xl"
                        level="h1"
                        class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                    >
                        {{ $anime['data']['title'] }}
                    </flux:heading>
                    <flux:heading
                        size="lg"
                        level="h1"
                        class="!font-semibold"
                    >
                        {{ $anime['data']['japanese'] }}
                    </flux:heading>
                    <div class="flex flex-row flex-wrap items-center gap-2">
                        @foreach ($anime['data']['genreList'] as $genre)
                            <a href="{{ $genre['samehadakuUrl'] }}">
                                <flux:badge size="small">
                                    {{ $genre['title'] }}
                                </flux:badge>
                            </a>
                        @endforeach
                    </div>

                    <flux:separator />

                    <div class="flex flex-row flex-wrap items-center gap-2">
                        <flux:badge
                            size="small"
                            color="emerald"
                            icon="calendar-date-range"
                        >
                            {{ $anime['data']['status'] }}
                        </flux:badge>
                        <flux:badge
                            size="small"
                            icon="numbered-list"
                        >
                            {{ $anime['data']['episodes'] }} Episode
                        </flux:badge>
                        <flux:badge
                            size="small"
                            icon="clock"
                        >
                            {{ $anime['data']['duration'] }}
                        </flux:badge>
                    </div>
                    <div class="flex flex-row flex-wrap items-center gap-2">

                        <flux:badge
                            size="small"
                            color="amber"
                            icon="star"
                        >
                            {{ $anime['data']['score']['value'] }}/10
                        </flux:badge>
                        <flux:badge
                            size="small"
                            color="cyan"
                            icon="cloud"
                        >
                            {{ $anime['data']['season'] }}
                        </flux:badge>
                        <flux:badge
                            size="small"
                            color="blue"
                            icon="home-modern"
                        >
                            {{ $anime['data']['studios'] }}
                        </flux:badge>
                    </div>

                    <flux:separator />

                    <flux:subheading level="h3">
                        {{ implode(' ', $anime['data']['synopsis']['paragraphs']) }}
                    </flux:subheading>
                </div>
            </div>
        </x-cards.app>
    </div>
</x-layouts.app>
