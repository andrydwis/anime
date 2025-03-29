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
        <flux:navlist.item
            icon="users"
            iconVariant="solid"
            badge="Segera!"
            badge-color="red"
            href="/#"
        >
            Wibunity
        </flux:navlist.item>

        <flux:separator class="my-2" />

        <flux:navlist.item
            icon="list-bullet"
            iconVariant="solid"
            href="{{ route('anime.index') }}"
        >
            Daftar Anime
        </flux:navlist.item>
        <flux:navlist.item
            icon="bookmark"
            iconVariant="solid"
            href="{{ route('anime.list.index') }}"
        >
            Daftar Anime Saya
        </flux:navlist.item>
        <flux:navlist.item
            icon="calendar-date-range"
            iconVariant="solid"
            iconVariant="solid"
            href="{{ route('anime.recent.index') }}"
        >
            Anime Terbaru
        </flux:navlist.item>

        <flux:separator class="my-2" />

        <flux:navlist.item
            icon="calendar-date-range"
            iconVariant="solid"
            href="{{ route('news.index') }}"
        >
            Berita Terbaru
        </flux:navlist.item>
        <flux:navlist.item
            icon="calendar-date-range"
            iconVariant="solid"
            href="{{ route('events.index') }}"
        >
            Event
        </flux:navlist.item>
        <flux:navlist.item
            icon="sparkles"
            iconVariant="solid"
            badge="Baru!"
            badge-color="emerald"
            href="{{ route('gachamon.index') }}"
        >
            Gachamon
        </flux:navlist.item>

        <flux:separator class="my-2" />

        <flux:navlist.item
            icon="link"
            iconVariant="solid"
            badge="Baru!"
            badge-color="emerald"
            href="{{ route('tools.short-links.index') }}"
        >
            Short Link
        </flux:navlist.item>
        <flux:navlist.item
            icon="video-camera"
            iconVariant="solid"
            badge="Baru!"
            badge-color="emerald"
            href="{{ route('tools.social-media-video-downloader.index') }}"
        >
            Social Media Video Downloader
        </flux:navlist.item>
    </flux:navlist>
</flux:sidebar>
