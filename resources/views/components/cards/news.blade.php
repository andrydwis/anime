<a href="/events">
    <div class="group relative flex flex-col overflow-hidden rounded-lg">
        <img
            loading="lazy"
            src="https://picsum.photos/200/300"
            alt="cover"
            class="aspect-video object-cover transition-all group-hover:scale-110 group-hover:brightness-50"
        >
        <flux:badge
            variant="solid"
            size="sm"
            color="zinc"
            icon="calendar-date-range"
            class="pointer-events-none absolute right-2 top-2"
        >
            {{ now()->isoFormat('DD MMM Y') }}
        </flux:badge>
        <flux:button
            variant="filled"
            icon="eye"
            class="pointer-events-none !absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 !rounded-full !bg-white/50 !text-white opacity-0 transition-all group-hover:border-2 group-hover:border-white group-hover:opacity-100"
        />
        <div
            class="pointer-events-none absolute bottom-0 w-full bg-white/75 p-2 dark:bg-zinc-900/50">
            <flux:heading class="line-clamp-1 group-hover:underline">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Provident, vel
                beatae. Fugit corporis at neque nesciunt ratione eum corrupti? Facilis
                quasi nihil quis aspernatur? Earum ab quam sunt laudantium illo!
            </flux:heading>
        </div>
    </div>
</a>
