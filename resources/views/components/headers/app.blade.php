<flux:header
    container
    class="sticky top-0 bg-white dark:bg-zinc-900/50 dark:backdrop-blur"
>
    <flux:sidebar.toggle
        variant="filled"
        icon="bars-2"
        class="lg:hidden"
    />

    <flux:brand
        href="{{ route('home') }}"
        name="{{ config('app.name') }}"
        class="max-lg:hidden"
    >
        🇯🇵
    </flux:brand>

    <flux:navbar class="max-lg:hidden">
        <flux:navbar.item
            icon="home"
            href="/"
        >
            Beranda
        </flux:navbar.item>
        <flux:navbar.item
            icon="users"
            href="/wibunitas"
            badge="Baru!"
            badge-color="emerald"
        >
            Wibunitas
        </flux:navbar.item>
        <flux:separator vertical />
        <flux:navbar.item
            icon="list-bullet"
            href="/anime/list"
        >
            Daftar Anime
        </flux:navbar.item>
        <flux:navbar.item
            icon="calendar-days"
            href="/anime/ongoing"
        >
            Anime sedang Berjalan
        </flux:navbar.item>
    </flux:navbar>

    <flux:spacer />

    <div class="flex items-center gap-2">
        <flux:dropdown
            x-data
            align="end"
        >
            <flux:button
                variant="subtle"
                square
                class="group"
                aria-label="Preferred color scheme"
            >
                <flux:icon.sun
                    x-show="$flux.appearance === 'light'"
                    variant="mini"
                    class="text-zinc-500 dark:text-white"
                />
                <flux:icon.moon
                    x-show="$flux.appearance === 'dark'"
                    variant="mini"
                    class="text-zinc-500 dark:text-white"
                />
                <flux:icon.moon
                    x-show="$flux.appearance === 'system' && $flux.dark"
                    variant="mini"
                />
                <flux:icon.sun
                    x-show="$flux.appearance === 'system' && ! $flux.dark"
                    variant="mini"
                />
            </flux:button>

            <flux:menu>
                <flux:menu.item
                    icon="sun"
                    x-on:click="$flux.appearance = 'light'"
                >Light</flux:menu.item>
                <flux:menu.item
                    icon="moon"
                    x-on:click="$flux.appearance = 'dark'"
                >Dark</flux:menu.item>
                <flux:menu.item
                    icon="computer-desktop"
                    x-on:click="$flux.appearance = 'system'"
                >System</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
        <flux:button
            variant="ghost"
            icon="magnifying-glass"
            href="/search"
        />
        <flux:separator vertical />
        @auth
            <flux:dropdown
                position="top"
                align="end"
            >
                <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />
                <flux:menu>
                    <flux:menu.item
                        icon="user"
                        href="/profile"
                    >
                        Profil
                    </flux:menu.item>
                    <flux:menu.separator />
                    <form
                        id="logout-form"
                        action="{{ route('logout') }}"
                        method="post"
                    >
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                        >
                            Logout
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @else
            <flux:button
                variant="filled"
                icon="arrow-right-end-on-rectangle"
                href="{{ route('login') }}"
            >
                Login
            </flux:button>
        @endauth
    </div>
</flux:header>
