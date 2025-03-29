<x-layouts.app title="{{ $manga['title'] }} - Chapter {{ $chapter['title'] }}">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item>
            Manga
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('manga.show', $mangaId) }}">
            {{ $manga['title'] }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Chapter {{ $chapter['title'] }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:select
        placeholder="Pilih Chapter..."
        onchange="window.location.href = this.value"
    >
        @foreach ($chapters as $chapter)
            <flux:select.option
                value="{{ $chapter['id'] }}"
                :selected="$chapter['id'] === $chapterId ? true : false"
            >
                {{ $chapter['title'] }}
            </flux:select.option>
        @endforeach
    </flux:select>

    <div class="flex flex-col">
        @foreach ($pages as $page)
            <img
                data-src="{{ $page['img'] }}"
                alt="{{ $page['page'] }}"
                loading="lazy"
                class="lazy"
            >
        @endforeach
    </div>

    <flux:select
        placeholder="Pilih Chapter..."
        onchange="window.location.href = this.value"
    >
        @foreach ($chapters as $chapter)
            <flux:select.option
                value="{{ $chapter['id'] }}"
                :selected="$chapter['id'] === $chapterId ? true : false"
            >
                {{ $chapter['title'] }}
            </flux:select.option>
        @endforeach
    </flux:select>

    <flux:button
        icon="chevron-up"
        class="!fixed bottom-4 right-4"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
    >
        Kembali ke atas
    </flux:button>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@19.1.3/dist/lazyload.min.js">
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var lazyLoadInstance = new LazyLoad({
                    elements_selector: ".lazy"
                });
            });
        </script>
    @endpush
</x-layouts.app>
