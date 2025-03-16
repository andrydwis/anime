<x-layouts.beta
    title="{{ $detail['name'] }}"
    description="{{ $detail['description'] }}"
    image="{{ $detail['image'] }}"
>
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('animex.index') }}">
            Anime X (BETA)
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ $detail['name'] }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="aspect-video overflow-hidden rounded-lg">
        <iframe
            src="{{ $episode['iframe'] }}"
            frameborder="0"
            allowfullscreen="true"
            scrolling="no"
            class="h-full w-full"
        >
        </iframe>
    </div>

    {{-- <x-animes.episodex
        :anime="$detail"
        :episodes="$episodes['episodes']"
        :episodeId="$currentEpisode['episodeId']"
        :watchedEpisodes="$watchedEpisodes"
    /> --}}

    <x-animes.detailx :anime="$detail" />
</x-layouts.beta>
