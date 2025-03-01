<x-layouts.app title="{{ $anime['data']['title'] }}">
    <div class="flex flex-col gap-8">
        <flux:breadcrumbs class="flex-wrap">
            <flux:breadcrumbs.item
                icon="home"
                href="{{ route('home') }}"
            />
            <flux:breadcrumbs.item href="{{ route('anime.index') }}">
                Anime
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                {{ $anime['data']['title'] }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a
            href="{{ route('anime.episode.show', ['anime' => $animeId, 'episode' => $anime['data']['episodeList'][0]['episodeId']]) }}"
            class="group relative aspect-video overflow-hidden rounded-lg"
        >
            <img
                src="{{ $anime['data']['poster'] }}"
                alt="cover"
                class="aspect-video h-full w-full object-cover brightness-50"
            >
            <flux:button
                icon="play"
                class="pointer-events-none !absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 !rounded-full !bg-white/50 !text-white opacity-0 transition-all group-hover:border-2 group-hover:border-white group-hover:opacity-100"
            />
            <div
                class="pointer-events-none absolute bottom-0 w-full bg-white/75 p-2 dark:bg-zinc-900/50">
                <flux:heading class="line-clamp-1 text-center group-hover:underline">
                    Klik untuk melihat Episode
                    {{ $anime['data']['episodeList'][0]['title'] }}
                </flux:heading>
            </div>
        </a>

        <x-animes.episode
            :anime="$anime"
            :animeId="$animeId"
            :watchedEpisodes="$watchedEpisodes"
        />

        <x-animes.detail :anime="$anime" />
    </div>
</x-layouts.app>
