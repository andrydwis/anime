<!doctype html>
<html>

    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        />

        <link
            rel="icon"
            href="favicon.ico"
            type="image/x-icon"
        >

        <!-- Primary Meta Tags -->
        <title>
            Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru
            Seputar Anime
        </title>
        <meta
            name="title"
            content="Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru Seputar Anime"
        />
        <meta
            name="description"
            content="Weaboo.my.id adalah tempat terbaik untuk nonton anime gratis, bergabung dengan komunitas wibu, dan mendapatkan informasi terkini seputar dunia anime. Temukan anime favoritmu di sini!"
        />
        <meta
            name="keywords"
            content="nonton anime, komunitas wibu, anime gratis, anime terbaru, berita anime, weaboo, anime indonesia, streaming anime, forum wibu, anime terbaik"
        >

        <!-- Open Graph / Facebook -->
        <meta
            property="og:type"
            content="website"
        />
        <meta
            property="og:url"
            content="https://metatags.io/"
        />
        <meta
            property="og:title"
            content="Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru Seputar Anime"
        />
        <meta
            property="og:description"
            content="Weaboo.my.id adalah tempat terbaik untuk nonton anime gratis, bergabung dengan komunitas wibu, dan mendapatkan informasi terkini seputar dunia anime. Temukan anime favoritmu di sini!"
        />
        <meta
            property="og:image"
            content="https://metatags.io/images/meta-tags.png"
        />

        <!-- Twitter -->
        <meta
            property="twitter:card"
            content="summary_large_image"
        />
        <meta
            property="twitter:url"
            content="https://metatags.io/"
        />
        <meta
            property="twitter:title"
            content="Weaboo.my.id - Nonton Anime Gratis, Komunitas Wibu, dan Berita Terbaru Seputar Anime"
        />
        <meta
            property="twitter:description"
            content="Weaboo.my.id adalah tempat terbaik untuk nonton anime gratis, bergabung dengan komunitas wibu, dan mendapatkan informasi terkini seputar dunia anime. Temukan anime favoritmu di sini!"
        />
        <meta
            property="twitter:image"
            content="https://metatags.io/images/meta-tags.png"
        />

        {{-- Font --}}
        <link
            rel="preconnect"
            href="https://fonts.bunny.net"
        >
        <link
            href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap"
            rel="stylesheet"
        />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
        @stack('styles')
    </head>

    <body class="min-h-screen bg-white dark:bg-slate-900">
        <flux:header
            container
            class="border-b border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-900"
        >
            <flux:sidebar.toggle
                class="lg:hidden"
                icon="bars-2"
                inset="left"
            />

            <flux:brand
                href="#"
                logo="https://fluxui.dev/img/demo/logo.png"
                name="Acme Inc."
                class="max-lg:hidden dark:hidden"
            />
            <flux:brand
                href="#"
                logo="https://fluxui.dev/img/demo/dark-mode-logo.png"
                name="Acme Inc."
                class="max-lg:hidden! hidden dark:flex"
            />

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item
                    icon="home"
                    href="#"
                    current
                >Home</flux:navbar.item>
                <flux:navbar.item
                    icon="inbox"
                    badge="12"
                    href="#"
                >Inbox</flux:navbar.item>
                <flux:navbar.item
                    icon="document-text"
                    href="#"
                >Documents</flux:navbar.item>
                <flux:navbar.item
                    icon="calendar"
                    href="#"
                >Calendar</flux:navbar.item>

                <flux:separator
                    vertical
                    variant="subtle"
                    class="my-2"
                />

                <flux:dropdown class="max-lg:hidden">
                    <flux:navbar.item icon-trailing="chevron-down">Favorites
                    </flux:navbar.item>

                    <flux:navmenu>
                        <flux:navmenu.item href="#">Marketing site
                        </flux:navmenu.item>
                        <flux:navmenu.item href="#">Android app</flux:navmenu.item>
                        <flux:navmenu.item href="#">Brand guidelines
                        </flux:navmenu.item>
                    </flux:navmenu>
                </flux:dropdown>
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="mr-4">
                <flux:navbar.item
                    icon="magnifying-glass"
                    href="#"
                    label="Search"
                />
                <flux:navbar.item
                    class="max-lg:hidden"
                    icon="cog-6-tooth"
                    href="#"
                    label="Settings"
                />
                <flux:navbar.item
                    class="max-lg:hidden"
                    icon="information-circle"
                    href="#"
                    label="Help"
                />
            </flux:navbar>

            <flux:dropdown
                position="top"
                align="start"
            >
                <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />

                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                        <flux:menu.radio>Truly Delta</flux:menu.radio>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.item icon="arrow-right-start-on-rectangle">Logout
                    </flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <flux:sidebar
            stashable
            sticky
            class="border-r border-slate-200 bg-slate-50 lg:hidden dark:border-slate-700 dark:bg-slate-900"
        >
            <flux:sidebar.toggle
                class="lg:hidden"
                icon="x-mark"
            />

            <flux:brand
                href="#"
                logo="https://fluxui.dev/img/demo/logo.png"
                name="Acme Inc."
                class="px-2 dark:hidden"
            />
            <flux:brand
                href="#"
                logo="https://fluxui.dev/img/demo/dark-mode-logo.png"
                name="Acme Inc."
                class="hidden px-2 dark:flex"
            />

            <flux:navlist variant="outline">
                <flux:navlist.item
                    icon="home"
                    href="#"
                    current
                >Home</flux:navlist.item>
                <flux:navlist.item
                    icon="inbox"
                    badge="12"
                    href="#"
                >Inbox</flux:navlist.item>
                <flux:navlist.item
                    icon="document-text"
                    href="#"
                >Documents</flux:navlist.item>
                <flux:navlist.item
                    icon="calendar"
                    href="#"
                >Calendar</flux:navlist.item>

                <flux:navlist.group
                    expandable
                    heading="Favorites"
                    class="max-lg:hidden"
                >
                    <flux:navlist.item href="#">Marketing site</flux:navlist.item>
                    <flux:navlist.item href="#">Android app</flux:navlist.item>
                    <flux:navlist.item href="#">Brand guidelines
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item
                    icon="cog-6-tooth"
                    href="#"
                >Settings</flux:navlist.item>
                <flux:navlist.item
                    icon="information-circle"
                    href="#"
                >Help</flux:navlist.item>
            </flux:navlist>
        </flux:sidebar>

        <flux:main container>
            <flux:heading
                size="xl"
                level="1"
            >Good afternoon, Olivia</flux:heading>

            <flux:subheading
                size="lg"
                class="mb-6"
            >Here's what's new today</flux:subheading>

            <flux:button>Default</flux:button>
            <flux:button variant="primary">Primary</flux:button>
            <flux:button variant="filled">Filled</flux:button>
            <flux:button variant="danger">Danger</flux:button>
            <flux:button variant="ghost">Ghost</flux:button>
            <flux:button variant="subtle">Subtle</flux:button>

            <flux:separator variant="subtle" />
        </flux:main>

        @stack('scripts')
        @fluxScripts
    </body>

</html>
