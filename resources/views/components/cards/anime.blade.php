@props(['anime'])
@php
    if (isset($anime['episodeId'])) {
        $route = route('anime.episode.show', [
            'anime' => $anime['animeId'],
            'episode' => $anime['episodeId'],
        ]);
    } else {
        $route = route('anime.show', ['anime' => $anime['animeId']]);
    }
@endphp
<a
    {{ $attributes }}
    href="{{ $route }}"
>
    <div class="group relative flex flex-col overflow-hidden rounded-lg">
        <img
            loading="lazy"
            src="{{ $anime['poster'] }}"
            alt="cover"
            class="aspect-[3/4] object-cover transition-all group-hover:scale-110 group-hover:brightness-50"
        >
        @if (isset($anime['episodes']))
            <flux:badge
                variant="solid"
                size="sm"
                color="emerald"
                icon="play-circle"
                class="pointer-events-none absolute right-2 top-2"
            >
                Eps {{ $anime['episodes'] }}
            </flux:badge>
        @endif
        <flux:button
            icon="play"
            class="pointer-events-none !absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 !rounded-full !bg-white/50 !text-white opacity-0 transition-all group-hover:border-2 group-hover:border-white group-hover:opacity-100"
        />
        <div
            class="pointer-events-none absolute bottom-0 w-full bg-white/75 p-2 dark:bg-zinc-900/50">
            <flux:heading class="line-clamp-1 group-hover:underline">
                {{ str()->title(str()->replace('-', ' ', $anime['animeId'])) }}
            </flux:heading>
        </div>
    </div>
</a>
