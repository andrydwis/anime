<x-layouts.app title="Gachamon">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item>
            Gachamon
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <livewire:gachamon />
</x-layouts.app>
