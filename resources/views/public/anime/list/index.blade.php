<x-layouts.app title="Daftar Anime">
    <div class="flex flex-col gap-8">
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
            <div
                class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-col">
                    <flux:heading
                        size="xl"
                        level="h1"
                        class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                    >
                        Daftar Anime Saya
                    </flux:heading>
                    <flux:subheading level="h2">
                        Semua anime yang pernah kamu tonton, favoritekan, dan watchlist
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
                        Riwayat Menonton
                    </flux:heading>
                    <div class="flex flex-col gap-2">
                        @foreach ($histories as $date => $animes)
                            <flux:heading class="!font-semibold">
                                {{ $date }}
                            </flux:heading>
                            <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
                                @foreach ($animes as $animeData)
                                    @php
                                        // Extract data from $animeData
                                        $anime = $animeData->data['anime']['data'];
                                        $episodeId = $animeData->data['episodeId'];
                                        $anime['animeId'] = $animeData->data['animeId'];
                                        $episodeList = $anime['episodeList'];

                                        // Find the matching episode using a helper function
                                        $matchingEpisode = collect(
                                            $episodeList,
                                        )->firstWhere('episodeId', $episodeId);

                                        // Add the episode title to the anime data if a match is found
                                        $anime['episodes'] = $matchingEpisode
                                            ? $matchingEpisode['title']
                                            : null;
                                    @endphp
                                    <x-cards.anime :anime="$anime" />
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-cards.app>
        </div>
    </div>
</x-layouts.app>
