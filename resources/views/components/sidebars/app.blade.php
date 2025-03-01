<flux:sidebar
    stashable
    sticky
    class="w-full bg-white lg:hidden dark:bg-zinc-900/50 dark:backdrop-blur"
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
            variant="solid"
            href="{{ route('home') }}"
        >
            Beranda
        </flux:navlist.item>
        <flux:navlist.item
            icon="users"
            href="/Wibunity"
            badge="Baru!"
            badge-color="emerald"
        >
            Wibunity
        </flux:navlist.item>

        <flux:separator class="my-2" />

        <flux:navlist.item
            icon="list-bullet"
            href="{{ route('anime.index') }}"
        >
            Daftar Anime
        </flux:navlist.item>
        <flux:navlist.item
            icon="calendar-date-range"
            href="{{ route('anime.recent.index') }}"
        >
            Anime Terbaru
        </flux:navlist.item>
        <flux:navlist.item
            icon="bookmark"
            href="#todo"
        >
            Daftar Anime Saya
        </flux:navlist.item>

        <flux:separator class="my-2" />

        <flux:navlist.item
            icon="calendar-date-range"
            href="/anime/list"
        >
            Event Wibu
        </flux:navlist.item>
        <flux:navlist.item
            icon="sparkles"
            href="/anime/ongoing"
            badge="Segera!"
            badge-color="red"
        >
            Gachamon
        </flux:navlist.item>
    </flux:navlist>
</flux:sidebar>
