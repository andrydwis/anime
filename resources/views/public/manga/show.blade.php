<x-layouts.app title="{{ $manga['title'] }}">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item>
            Manga
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ $manga['title'] }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-mangas.detail :manga="$manga" />
</x-layouts.app>
