<x-layouts.beta title="Anime Terbaru">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('animex.index') }}">
            Anime X (BETA)
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Anime Terbaru
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    Anime Terbaru
                </flux:heading>
                <flux:subheading level="h2">
                    Update terbaru anime season ini
                </flux:subheading>
            </div>
        </div>
        @if ($animes['animes'])
            <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
                @foreach ($animes['animes'] as $anime)
                    <x-cards.animex :anime="$anime" />
                @endforeach
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <flux:separator
                        text="Halaman {{ $animes['currentPage'] }}/{{ $animes['totalPages'] }}"
                    />
                </div>
                <flux:button
                    icon="chevron-left"
                    :disabled="$animes['currentPage'] == 1"
                    :href="$animes['currentPage'] > 1 ? route('animex.recent.index',
                        [
                            'page' => $animes['currentPage'] - 1 ?? 1
                        ]) : false"
                >
                    Sebelumnya
                </flux:button>
                <flux:button
                    icon-trailing="chevron-right"
                    :disabled="!$animes['hasNextPage']"
                    :href="$animes['hasNextPage'] ? route('animex.recent.index',
                        [
                            'page' => $animes['currentPage'] + 1 ?? 1
                        ]) : false"
                >
                    Selanjutnya
                </flux:button>
            </div>
        @else
            <x-cards.app class="col-span-4">
                <flux:heading>
                    Anime Tidak Tersedia
                </flux:heading>
                <flux:subheading>
                    Coba cari ke halaman lain atau coba lagi nanti
                </flux:subheading>
            </x-cards.app>
        @endif
    </div>
</x-layouts.beta>
