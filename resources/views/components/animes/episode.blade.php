@props(['anime', 'animeId', 'episodeId' => null])
<div class="flex flex-col gap-4">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
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
            $sortedEpisodes = collect($anime['data']['episodeList'])->sortBy('title');
        @endphp
        @foreach ($sortedEpisodes as $episode)
            <flux:button
                :variant="$episode['episodeId'] == $episodeId ? 'primary' : 'filled'"
                icon="play-circle"
                class="w-full"
                href="{{ route('anime.episode.show', ['anime' => $animeId, 'episode' => $episode['episodeId']]) }}"
            >
                {{ $episode['title'] }}
            </flux:button>
        @endforeach
    </div>
</div>
