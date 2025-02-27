@props(['anime'])
<a href="{{ route('anime.show', ['id' => $anime['animeId']]) }}">
    <div class="group relative flex flex-col overflow-hidden rounded-lg">
        <img
            loading="lazy"
            src="{{ $anime['poster'] }}"
            alt="cover"
            class="aspect-video object-cover transition-all group-hover:scale-110 group-hover:brightness-50"
        >
        <flux:badge
            variant="solid"
            size="sm"
            color="emerald"
            icon="play-circle"
            class="pointer-events-none absolute right-2 top-2"
        >
            Eps {{ $anime['episodes'] }}
        </flux:badge>
        <flux:button
            variant="filled"
            icon="play"
            class="pointer-events-none !absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 !rounded-full !bg-white/50 !text-white opacity-0 transition-all group-hover:border-2 group-hover:border-white group-hover:opacity-100"
        />
        <div
            class="pointer-events-none absolute bottom-0 w-full bg-white/75 p-2 dark:bg-zinc-900/50">
            <flux:heading class="line-clamp-1 group-hover:underline">
                {{ $anime['title'] }}
            </flux:heading>
        </div>
    </div>
</a>
