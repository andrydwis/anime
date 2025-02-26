<flux:sidebar
    stashable
    sticky
    class="w-full bg-white lg:hidden dark:bg-slate-900/75 dark:backdrop-blur"
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
            variant="filled"
            class="lg:hidden"
            icon="x-mark"
        />
    </div>

    <flux:navlist variant="outline">
        <flux:navlist.item
            icon="home"
            variant="solid"
            href="/"
        >
            Beranda
        </flux:navlist.item>
        <flux:navlist.item
            icon="users"
            href="/wibunitas"
            badge="Baru!"
            badge-color="emerald"
        >
            Wibunitas
        </flux:navlist.item>
        <flux:separator />
        <flux:navlist.item
            icon="list-bullet"
            href="/anime/list"
        >
            Daftar Anime
        </flux:navlist.item>
        <flux:navlist.item
            icon="calendar-days"
            href="/anime/ongoing"
        >
            Anime sedang Berjalan
        </flux:navlist.item>
    </flux:navlist>
</flux:sidebar>
