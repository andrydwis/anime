<x-layouts.app title="Short Link">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('tools.short-links.index') }}">
            Short Link
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Statistik Short Link
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    Statistik Short Link
                </flux:heading>
                <flux:text>
                    Lihat jumlah klik, pengunjung, dan data lainnya dari short link kamu.
                </flux:text>
            </div>
        </div>
        <livewire:stat-short-link :linkData="$link" />
    </div>
</x-layouts.app>
