<x-layouts.app title="{{ $episode['data']['title'] }}">
    <div class="flex flex-col gap-8">
        <flux:breadcrumbs class="flex-wrap">
            <flux:breadcrumbs.item
                icon="home"
                href="{{ route('home') }}"
            />
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

        <x-animes.episode
            :anime="$anime"
            :animeId="$animeId"
            :episodeId="$episodeId"
        />

        <x-animes.detail :anime="$anime" />
    </div>
</x-layouts.app>
