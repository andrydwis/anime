@props(['anime', 'episodes' => [], 'watchedEpisodes' => [], 'episodeId' => null])
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
                Semua episode Anime {{ $anime['title'] }}
            </flux:subheading>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-2 lg:grid-cols-6">
        @foreach ($episodes as $episode)
            @php
                if ($episode['id'] == $episodeId) {
                    $status = 'playing';
                    $variant = 'primary';
                    $class = null;
                } elseif (
                    in_array($episode['id'], $watchedEpisodes) &&
                    $episodeId != $episode['id']
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
                <<<<<<<
                HEAD
                href="{{ route('anime.episode.show', ['anime' => $anime['id'], 'episode' => $episode['id']]) }}"
                title="{{ $episode['title'] }}"
                class="{{ $class ?? '' }} w-full"=======class="{{ $class ?? '' }} w-full"
                href="{{ route('anime.episode.show', ['anime' => $animeId, 'episode' => $episode['episodeId']]) }}"
            >>>>>>> master
                >
                {{ $episode['number'] }}
            </flux:button>
        @endforeach
    </div>
</div>
