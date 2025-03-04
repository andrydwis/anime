<x-layouts.app title="Berita">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item>
            Berita Terbaru
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
                    Berita Terbaru
                </flux:heading>
                <flux:subheading level="h2">
                    Berita terbaru seputar anime, manga, game, dan lainnya
                </flux:subheading>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
            @foreach ($news as $newsData)
                <x-cards.news :news="$newsData" />
            @endforeach
        </div>
        <div>
            {{ $news?->onEachSide(1)?->links('components.paginations.app') }}
        </div>
    </div>
</x-layouts.app>
