<x-layouts.app title="Daftar Anime">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('anime.index') }}">
            Daftar Anime
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Daftar Anime Saya
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    Daftar Anime Saya
                </flux:heading>
                <flux:subheading level="h2">
                    Semua anime yang pernah kamu tonton, favorit, dan watchlist
                    yang kamu buat
                </flux:subheading>
            </div>
        </div>

        <x-cards.app>
            <div class="flex flex-col gap-2">
                <flux:heading
                    size="xl"
                    level="h3"
                    class="!font-bold"
                >
                    Watchlist
                </flux:heading>
                <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
                    @forelse ($watchlists as $animeData)
                        @php
                            $anime = $animeData->data['anime']['data'];
                            $anime['animeId'] = $animeData->data['animeId'];
                        @endphp
                        <x-cards.anime :anime="$anime" />
                    @empty
                        <x-cards.app class="col-span-4">
                            <flux:heading>
                                Belum ada watchlist
                            </flux:heading>
                            <flux:subheading>
                                Kamu belum pernah menambahkan anime ke watchlist
                            </flux:subheading>
                        </x-cards.app>
                    @endforelse
                </div>
            </div>
        </x-cards.app>

        <x-cards.app>
            <div class="flex flex-col gap-2">
                <flux:heading
                    size="xl"
                    level="h3"
                    class="!font-bold"
                >
                    Riwayat Menonton
                </flux:heading>
                <div class="flex flex-col gap-2">
                    @forelse ($histories as $date => $animes)
                        <flux:subheading
                            class="flex flex-row items-center gap-2 !font-semibold"
                        >
                            <flux:icon.calendar-date-range
                                variant="solid"
                                size="sm"
                            />
                            <span>{{ $date }}</span>
                        </flux:subheading>
                        <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
                            @foreach ($animes as $animeData)
                                @php
                                    // Extract data from $animeData
                                    $anime = $animeData->data['anime']['data'];
                                    $episodeId = $animeData->data['episodeId'];
                                    $anime['animeId'] = $animeData->data['animeId'];
                                    $anime['episodeId'] = $episodeId;
                                    $episodeList = $anime['episodeList'];

                                    // Find the matching episode using a helper function
                                    $matchingEpisode = collect($episodeList)->firstWhere(
                                        'episodeId',
                                        $episodeId,
                                    );

                                    // Add the episode title to the anime data if a match is found
                                    $anime['episodes'] = $matchingEpisode
                                        ? $matchingEpisode['title']
                                        : null;
                                @endphp
                                <x-cards.anime :anime="$anime" />
                            @endforeach
                        </div>
                    @empty
                        <x-cards.app>
                            <flux:heading>
                                Belum ada riwayat anime yang pernah kamu tonton
                            </flux:heading>
                            <flux:subheading>
                                Kamu belum pernah menonton anime apapun, coba cari
                                anime yang kamu sukai
                                <flux:link href="{{ route('anime.recent.index') }}">
                                    disini
                                </flux:link>
                            </flux:subheading>
                        </x-cards.app>
                    @endforelse
                </div>
            </div>
        </x-cards.app>
    </div>
</x-layouts.app>
