<x-layouts.app title="Anime Terbaru">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('anime.index') }}">
            Anime
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
                <flux:text>
                    Update terbaru anime season ini
                </flux:text>
            </div>
        </div>
        @if ($animes['data'])
            <div class="grid grid-cols-2 gap-2 md:grid-cols-4 lg:grid-cols-6">
                @foreach ($animes['data']['animeList'] as $anime)
                    <x-cards.anime :anime="$anime" />
                @endforeach
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <flux:separator
                        text="Halaman {{ $animes['pagination']['currentPage'] }}/{{ $animes['pagination']['totalPages'] }}"
                    />
                </div>
                <flux:button
                    icon="chevron-left"
                    :disabled="!$animes['pagination']['hasPrevPage']"
                    :href="$animes['pagination']['hasPrevPage'] ? route('anime.recent.index',
                        [
                            'page' => $animes['pagination']['prevPage'] ?? 1
                        ]) : false"
                >
                    Sebelumnya
                </flux:button>
                <flux:button
                    icon-trailing="chevron-right"
                    :disabled="!$animes['pagination']['hasNextPage']"
                    :href="$animes['pagination']['hasNextPage'] ? route('anime.recent.index',
                        [
                            'page' => $animes['pagination']['nextPage']
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
                <flux:text>
                    Coba cari ke halaman lain atau coba lagi nanti
                </flux:text>
            </x-cards.app>
        @endif
    </div>
</x-layouts.app>
