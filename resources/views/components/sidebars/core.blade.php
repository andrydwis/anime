<flux:sidebar
    stashable
    sticky
    class="z-[100] w-full border-r border-zinc-200 bg-white dark:border-zinc-600 dark:bg-zinc-900/50 dark:backdrop-blur"
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
            icon="gauge"
            href="{{ route('core.dashboard.index') }}"
        >
            Dashboard
        </flux:navlist.item>

        <flux:separator class="my-2" />

        <flux:navlist.item
            icon="users"
            iconVariant="solid"
            href="{{ route('core.users.index') }}"
        >
            Daftar Pengguna
        </flux:navlist.item>
        <flux:navlist.item
            icon="newspaper"
            iconVariant="solid"
            href="{{ route('core.news.index') }}"
        >
            Berita Terbaru
        </flux:navlist.item>
        <flux:navlist.item
            icon="calendar-date-range"
            iconVariant="solid"
            href="{{ route('core.events.index') }}"
        >
            Event
        </flux:navlist.item>
    </flux:navlist>
    <flux:spacer />
</flux:sidebar>
