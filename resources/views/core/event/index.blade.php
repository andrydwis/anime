<x-layouts.core title="Event">
    <x-alerts.app />

    <div class="flex flex-row items-center justify-between">
        <div>
            <flux:heading
                size="xl"
                class="!font-semibold"
            >
                Event
            </flux:heading>
            <flux:subheading>
                Informasi terbaru event wibu yang akan datang
            </flux:subheading>
        </div>
        <flux:button
            variant="primary"
            icon="plus"
            href="{{ route('core.events.create') }}"
        >
            Tambah
        </flux:button>
    </div>

    <x-cards.app>
        <div class="flex flex-col gap-2">
        </div>
    </x-cards.app>
</x-layouts.core>
