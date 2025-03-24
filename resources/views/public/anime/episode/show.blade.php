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

    @auth
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
    @else
        <div class="relative overflow-hidden rounded-lg">
            <div
                class="blur-xs flex flex-row flex-wrap items-center justify-between gap-2 transition-all">
                <flux:button
                    icon="bookmark"
                    disabled
                >
                    Simpan ke Watchlist
                </flux:button>
                <div class="flex flex-row items-center gap-2">
                    <flux:button
                        icon="server-stack"
                        disabled
                    >
                        Ganti Server
                    </flux:button>
                    <flux:button
                        icon="arrow-down-tray"
                        disabled
                    >
                        Download
                    </flux:button>
                </div>
            </div>
            <div class="absolute inset-0 flex bg-zinc-600/50 dark:bg-zinc-900/50">
                <flux:heading
                    variant="solid"
                    color="zinc"
                    class="!m-auto !flex flex-wrap items-center justify-center gap-2 px-2 !text-center !text-white"
                >
                    Masuk terlebih dahulu untuk bisa menikmati kualitas video lebih baik /
                    download episode. &nbsp;
                    <flux:button
                        size="xs"
                        href="{{ route('login') }}"
                    >
                        Masuk Sekarang
                    </flux:button>
                </flux:heading>
            </div>
        </div>
    @endauth

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
