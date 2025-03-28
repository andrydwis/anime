<x-layouts.app title="{{ $episode['data']['title'] }}">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('anime.index') }}">
            Anime
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('anime.show', ['anime' => $animeId]) }}">
            {{ str()->title(str()->replace('-', ' ', $animeId)) }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ $episode['data']['title'] }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="aspect-video overflow-hidden rounded-lg">
        <iframe
            id="player"
            allowfullscreen
            src="{{ $episode['data']['defaultStreamingUrl'] }}"
            frameborder="0"
            class="h-full w-full"
        ></iframe>
    </div>

    <div class="flex flex-row flex-wrap items-center justify-between gap-2">
        <livewire:save-anime
            :animeId="$animeId"
            :anime="$anime"
        />
        <div class="flex flex-row items-center gap-2">
            <flux:dropdown
                position="bottom"
                align="end"
            >
                <flux:button icon="server-stack">
                    Ganti Server
                </flux:button>

                <flux:menu>
                    @foreach ($episode['data']['server']['qualities'] as $qualities)
                        <flux:menu.group heading="{{ $qualities['title'] }}">
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
                        </flux:menu.group>
                    @endforeach
                </flux:menu>
            </flux:dropdown>
            <flux:dropdown
                position="bottom"
                align="end"
            >
                <flux:button icon="arrow-down-tray">
                    Download
                </flux:button>

                <flux:menu>
                    @foreach ($episode['data']['downloadUrl']['formats'] as $formats)
                        <flux:menu.group heading="{{ $formats['title'] }}">
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
                        </flux:menu.group>
                    @endforeach
                </flux:menu>
            </flux:dropdown>
        </div>
    </div>

    <x-animes.episode
        :anime="$anime"
        :animeId="$animeId"
        :episodeId="$episodeId"
        :watchedEpisodes="$watchedEpisodes"
    />

    <x-animes.detail
        :animeId="$animeId"
        :anime="$anime"
    />
</x-layouts.app>
