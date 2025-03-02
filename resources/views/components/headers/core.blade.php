<flux:header class="sticky top-0 bg-white dark:bg-zinc-900/50 dark:backdrop-blur">
    <flux:sidebar.toggle
        icon="bars-2"
        class="lg:hidden"
    />

    <flux:navbar class="max-lg:hidden">
        <flux:navbar.item
            icon="home"
            iconVariant="solid"
            href="{{ route('home') }}"
        >
            Beranda
        </flux:navbar.item>
        <flux:navbar.item
            icon="users"
            iconVariant="solid"
            badge="Segera!"
            badge-color="red"
            href="#"
        >
            Wibunity
        </flux:navbar.item>
        <flux:separator vertical />
    </flux:navbar>

    <flux:spacer />

    <div class="flex items-center gap-2">
        <flux:dropdown
            x-data
            align="center"
        >
            <flux:button
                square
                class="group"
                aria-label="Preferred color scheme"
            >
                <flux:icon.sun
                    x-cloak
                    x-show="$flux.appearance === 'light'"
                    variant="mini"
                    class="text-zinc-900 dark:text-white"
                />
                <flux:icon.moon
                    x-cloak
                    x-show="$flux.appearance === 'dark'"
                    variant="mini"
                    class="text-zinc-900 dark:text-white"
                />
                <flux:icon.moon
                    x-cloak
                    x-show="$flux.appearance === 'system' && $flux.dark"
                    variant="mini"
                />
                <flux:icon.sun
                    x-cloak
                    x-show="$flux.appearance === 'system' && ! $flux.dark"
                    variant="mini"
                />
            </flux:button>

            <flux:menu>
                <flux:menu.item
                    icon="sun"
                    x-on:click="$flux.appearance = 'light'"
                >
                    Mode Terang
                </flux:menu.item>
                <flux:menu.item
                    icon="moon"
                    x-on:click="$flux.appearance = 'dark'"
                >
                    Mode Gelap
                </flux:menu.item>
                <flux:menu.item
                    icon="computer-desktop"
                    x-on:click="$flux.appearance = 'system'"
                >
                    Mode Sistem
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>

        <flux:separator vertical />

        @auth
            <flux:dropdown
                position="top"
                align="end"
            >
                <flux:profile initials="{{ auth()->user()->initials }}" />
                <flux:menu>
                    @role('admin')
                        <flux:menu.item
                            icon="gauge"
                            href="{{ route('core.dashboard.index') }}"
                        >
                            Dashboard
                        </flux:menu.item>
                    @endrole
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
                            Keluar
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @else
            <flux:button
                icon="arrow-right-end-on-rectangle"
                href="{{ route('login') }}"
            >
                Masuk
            </flux:button>
        @endauth
    </div>
</flux:header>
