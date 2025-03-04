<flux:sidebar
    stashable
    sticky
    class="w-full bg-white dark:bg-zinc-900/50 dark:backdrop-blur"
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
            Berita
        </flux:navlist.item>
    </flux:navlist>

    <flux:spacer />
</flux:sidebar>
