<x-layouts.app title="Event">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item>
            Event
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
                    Event
                </flux:heading>
                <flux:subheading level="h2">
                    Informasi terbaru event yang akan datang
                </flux:subheading>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
            @foreach ($events as $event)
                <x-cards.event :event="$event" />
            @endforeach
        </div>
        <div>
            {{ $events?->onEachSide(1)?->links('components.paginations.app') }}
        </div>
    </div>
</x-layouts.app>
