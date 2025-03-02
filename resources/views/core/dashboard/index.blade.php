<x-layouts.core title="Dashboard">
    <div class="flex flex-col gap-8">
        <div class="grid grid-cols-3 gap-2">
            <x-cards.app>
                <flux:subheading>
                    Total Pengguna {{ config('app.name') }}
                </flux:subheading>
                <flux:heading
                    size="xl"
                    class="flex flex-row items-center gap-2"
                >
                    <flux:icon.users variant="solid" />
                    {{ $totalUsers }} Pengguna
                </flux:heading>
            </x-cards.app>
            <x-cards.app>
                <flux:subheading>
                    Total Pengguna Aktif
                </flux:subheading>
                <flux:heading
                    size="xl"
                    class="flex flex-row items-center gap-2"
                >
                    <flux:icon.users variant="solid" />
                    {{ $totalActiveUsers }} Pengguna
                </flux:heading>
            </x-cards.app>
            <x-cards.app>
                <flux:subheading>
                    Total Anime Ditonton
                </flux:subheading>
                <flux:heading
                    size="xl"
                    class="flex flex-row items-center gap-2"
                >
                    <flux:icon.tv variant="solid" />
                    {{ $totalWatchedAnimes }} Anime
                </flux:heading>
            </x-cards.app>
        </div>
    </div>
</x-layouts.core>
