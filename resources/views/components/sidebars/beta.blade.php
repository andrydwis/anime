<flux:sidebar
    stashable
    sticky
    class="z-[100] w-full border-r border-zinc-200 bg-white lg:hidden dark:border-zinc-600 dark:bg-zinc-900/50 dark:backdrop-blur"
>

    <div class="flex flex-row items-center justify-between gap-2">
        <flux:brand
            href="/"
            name="{{ config('app.name') }}"
            class="px-2"
        >
            🇯🇵
        </flux:brand>
        <flux:sidebar.toggle
            class="lg:hidden"
            icon="x-mark"
        />
    </div>

    <flux:navlist>
        <flux:navlist.item
            icon="home"
            iconVariant="solid"
            variant="solid"
            href="{{ route('home') }}"
        >
            Beranda
        </flux:navlist.item>

        <flux:separator class="my-2" />

        <flux:navlist.item
            icon="sparkles"
            iconVariant="solid"
            badge="WIP!"
            badge-color="amber"
            href="{{ route('animex.index') }}"
        >
            Anime X (BETA)
        </flux:navlist.item>
        <flux:navlist.item
            icon="calendar-date-range"
            iconVariant="solid"
            iconVariant="solid"
            href="{{ route('animex.recent.index') }}"
        >
            Anime Terbaru
        </flux:navlist.item>

    </flux:navlist>
</flux:sidebar>
