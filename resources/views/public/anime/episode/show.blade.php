<x-layouts.app title="{{ $anime['title'] . ' - ' . $episode['episode'] }}">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('anime.index') }}">
            Anime
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('anime.show', ['anime' => $animeId]) }}">
            {{ $anime['title'] }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ $episode['episode'] }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="aspect-video overflow-hidden rounded-lg">
        <iframe
            id="player"
            allowfullscreen
            src="{{ $episode['default']['url'] }}"
            frameborder="0"
            class="h-full w-full"
        ></iframe>
    </div>

    <div class="flex flex-row flex-wrap items-center justify-between gap-2">
        <livewire:save-anime
            :animeId="$animeId"
            :anime="$anime"
        />
    </div>

    <x-animes.episode
        :anime="$anime"
        :episodes="$episodes"
        :episodeId="$episodeId"
        :watchedEpisodes="$watchedEpisodes"
    />

    <x-animes.detail :anime="$anime" />
</x-layouts.app>
