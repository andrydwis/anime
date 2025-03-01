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
            <flux:subheading level="h2">
                Semua episode Anime {{ $anime['data']['title'] }}
            </flux:subheading>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-2 lg:grid-cols-6">
        @php
            $sortedEpisodes = collect($anime['data']['episodeList'])->sortBy('title');
        @endphp
        @foreach ($sortedEpisodes as $episode)
            @php
                if ($episode['episodeId'] == $episodeId) {
                    $variant = 'primary';
                } elseif (
                    in_array($episode['episodeId'], $watchedEpisodes) &&
                    $episodeId != $episode['episodeId']
                ) {
                    $variant = 'subtle';
                } else {
                    $variant = 'filled';
                }
            @endphp
            <flux:button
                :variant="$variant"
                icon="play-circle"
                class="w-full"
                href="{{ route('anime.episode.show', ['anime' => $animeId, 'episode' => $episode['episodeId']]) }}"
            >
                {{ $episode['title'] }}
            </flux:button>
        @endforeach
    </div>
</div>
