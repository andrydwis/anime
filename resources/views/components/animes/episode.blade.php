@props(['anime', 'animeId', 'episodeId' => null, 'watchedEpisodes' => []])
<div class="flex flex-col gap-2">
    <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex flex-col">
            <flux:heading
                size="xl"
                level="h1"
                class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
            >
                Daftar Episode
            </flux:heading>
            <flux:text>
                Semua episode Anime {{ str()->title(str()->replace('-', ' ', $animeId)) }}
            </flux:text>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-2 lg:grid-cols-6">
        @php
            $sortedEpisodes = collect($anime['data']['episodeList'])->sortBy('title');
        @endphp
        @foreach ($sortedEpisodes as $episode)
            @php
                if ($episode['episodeId'] == $episodeId) {
                    $status = 'playing';
                    $variant = 'primary';
                    $class = null;
                } elseif (
                    in_array($episode['episodeId'], $watchedEpisodes) &&
                    $episodeId != $episode['episodeId']
                ) {
                    $status = 'watched';
                    $variant = 'primary';
                    $class = '!opacity-50';
                } else {
                    $status = 'available';
                    $variant = null;
                    $class = null;
                }
            @endphp
            <flux:button
                :variant="$variant"
                :icon="$status === 'watched' ? 'check-circle' : 'play-circle'"
                class="{{ $class ?? '' }} w-full"
                href="{{ route('anime.episode.show', ['anime' => $animeId, 'episode' => $episode['episodeId']]) }}"
            >
                {{ $episode['title'] }}
            </flux:button>
        @endforeach
    </div>
</div>
