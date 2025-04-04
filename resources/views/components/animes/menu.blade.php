<div class="grid gap-2 md:grid-cols-2 lg:grid-cols-4">
    <flux:button
        icon="users"
        href="/#"
    >
        Wibunity
        <flux:badge
            size="sm"
            color="red"
        >
            Segera!
        </flux:badge>
    </flux:button>
    <flux:button
        icon="calendar-date-range"
        href="{{ route('events.index') }}"
    >
        Event
    </flux:button>
    <flux:button
        icon="newspaper"
        href="{{ route('news.index') }}"
    >
        Berita Terbaru
    </flux:button>
    <flux:button
        icon="sparkles"
        href="{{ route('gachamon.index') }}"
    >
        Gachamon
        <flux:badge
            size="sm"
            color="emerald"
        >
            Baru!
        </flux:badge>
    </flux:button>
    @auth
        <flux:modal.trigger name="ai">
            <flux:button
                icon="sparkles"
                class="md:col-span-2"
            >
                Waifu AI
                <flux:badge
                    size="sm"
                    color="emerald"
                >
                    Baru!
                </flux:badge>
            </flux:button>
        </flux:modal.trigger>
    @else
        <flux:button
            icon="sparkles"
            class="md:col-span-2"
            :href="route('login')"
        >
            Waifu AI
            <flux:badge
                size="sm"
                color="emerald"
            >
                Baru!
            </flux:badge>
        </flux:button>
    @endauth
    <flux:button
        icon="coffee"
        href="https://trakteer.id/weaboo-my-id"
        class="md:col-span-2"
    >
        Donasi
        <flux:badge
            size="sm"
            color="amber"
        >
            Support Yuk!
        </flux:badge>
    </flux:button>
</div>
