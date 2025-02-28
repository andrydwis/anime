<x-layouts.app>
    <div class="flex flex-col gap-8">
        <flux:breadcrumbs class="flex-wrap">
            <flux:breadcrumbs.item href="{{ route('home') }}">
                Beranda
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('anime.index') }}">
                Anime
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('anime.show', ['anime' => $animeId]) }}">
                {{ $anime['data']['title'] }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                {{ $episode['data']['title'] }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="aspect-video overflow-hidden rounded-lg">
            <iframe
                allowfullscreen
                src="{{ $episode['data']['defaultStreamingUrl'] }}"
                frameborder="0"
                class="h-full w-full"
            ></iframe>
        </div>

        <div class="flex flex-row items-center justify-between">
            <flux:dropdown
                position="bottom"
                align="start"
            >
                <flux:button icon="server-stack">Ganti Server</flux:button>

                <flux:menu>
                    <flux:menu.submenu
                        heading="Pilih Kualitas"
                        position="bottom"
                    >
                        @foreach ($episode['data']['server']['qualities'] as $qualities)
                            <flux:menu.submenu heading="{{ $qualities['title'] }}">
                                @forelse ($qualities['serverList'] as $server)
                                    <flux:menu.item
                                        href="{{ route('anime.episode.show', ['anime' => $animeId, 'episode' => $episodeId, 'server' => $server['serverId']]) }}"
                                    >
                                        {{ $server['title'] }}
                                    </flux:menu.item>
                                @empty

                                    <flux:menu.item disabled>
                                        Tidak tersedia
                                    </flux:menu.item>
                                @endforelse
                            </flux:menu.submenu>
                        @endforeach
                    </flux:menu.submenu>
                </flux:menu>
            </flux:dropdown>

            <flux:dropdown
                position="bottom"
                align="end"
            >
                <flux:button icon="arrow-down-tray">Download
                </flux:button>

                <flux:menu>
                    <flux:menu.submenu
                        heading="Pilih Format"
                        position="bottom"
                    >
                        @foreach ($episode['data']['downloadUrl']['formats'] as $formats)
                            <flux:menu.submenu heading="{{ $formats['title'] }}">
                                @foreach ($formats['qualities'] as $quality)
                                    <flux:menu.submenu heading="{{ $quality['title'] }}">
                                        @foreach ($quality['urls'] as $url)
                                            <flux:menu.item
                                                href="{{ $url['url'] }}"
                                                target="_blank"
                                            >
                                                {{ $url['title'] }}
                                            </flux:menu.item>
                                        @endforeach
                                    </flux:menu.submenu>
                                @endforeach
                            </flux:menu.submenu>
                        @endforeach
                    </flux:menu.submenu>
                </flux:menu>
            </flux:dropdown>
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
                        Daftar Episode
                    </flux:heading>
                    <flux:subheading level="h2">
                        Semua episode anime {{ $anime['data']['title'] }}
                    </flux:subheading>
                </div>
            </div>
            <div class="flex flex-row flex-wrap items-center gap-2">
                @php
                    $sortedEpisodes = collect($anime['data']['episodeList'])->sortBy(
                        'title',
                    );
                @endphp
                @foreach ($sortedEpisodes as $episode)
                    <flux:button
                        :variant="$episode['episodeId'] === $episodeId ? 'primary' : 'filled'"
                        icon="play-circle"
                        class="min-w-[100px]"
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
