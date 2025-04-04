<x-layouts.core title="Event">
    @if (session()->has('success'))
        <flux:callout
            color="emerald"
            icon="check-circle"
            heading="{{ session()->get('success') }}"
        />
    @endif

    <div class="flex flex-row flex-wrap items-center justify-between gap-2">
        <div>
            <flux:heading
                size="xl"
                class="!font-semibold"
            >
                Event
            </flux:heading>
            <flux:text>
                Informasi terbaru event yang akan datang
            </flux:text>
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
            <x-tables.app>
                <x-tables.columns>
                    <x-tables.column>
                        Event
                    </x-tables.column>
                    <x-tables.column>
                        Periode
                    </x-tables.column>
                    <x-tables.column>
                        Wilayah
                    </x-tables.column>
                    <x-tables.column>
                        Sudah Publish?
                    </x-tables.column>
                    <x-tables.column>
                        Aksi
                    </x-tables.column>
                </x-tables.columns>
                <x-tables.rows>
                    @forelse ($events as $event)
                        <x-tables.row>
                            <x-tables.cell>
                                <flex:text>
                                    {{ $event?->name }}
                                </flex:text>
                            </x-tables.cell>
                            <x-tables.cell class="text-center">
                                <flex:text>
                                    @if ($event?->start_date && $event?->end_date)
                                        {{ $event?->start_date?->isoFormat('DD MMM YYYY') }}
                                        -
                                        {{ $event?->end_date?->isoFormat('DD MMM YYYY') }}
                                    @elseif($event?->start_date)
                                        {{ $event?->start_date?->isoFormat('DD MMM YYYY') }}
                                    @else
                                        -
                                    @endif
                                </flex:text>
                            </x-tables.cell>
                            <x-tables.cell class="text-center">
                                <flex:text>
                                    @if ($event->province && $event->city)
                                        {{ $event?->province?->name }},
                                        {{ $event?->city?->name }}
                                    @else
                                        -
                                    @endif
                                </flex:text>
                            </x-tables.cell>
                            <x-tables.cell class="text-center">
                                <livewire:switch-publish-event :event="$event" />
                            </x-tables.cell>
                            <x-tables.cell>
                                <div
                                    class="flex flex-row items-center justify-center gap-2">
                                    <flux:tooltip content="Edit">
                                        <flux:button
                                            icon="pencil"
                                            size="xs"
                                            href="{{ route('core.events.edit', ['event' => $event]) }}"
                                        />
                                    </flux:tooltip>
                                    <flux:tooltip content="Hapus">
                                        <div>
                                            <flux:modal.trigger
                                                name="delete-event-{{ $event?->id }}"
                                            >
                                                <flux:button
                                                    variant="danger"
                                                    icon="trash"
                                                    size="xs"
                                                />
                                            </flux:modal.trigger>
                                            <flux:modal
                                                variant="flyout"
                                                position="bottom"
                                                name="delete-event-{{ $event?->id }}"
                                            >
                                                <div class="flex flex-col gap-2">
                                                    <div>
                                                        <flux:heading size="lg">
                                                            Hapus Event
                                                        </flux:heading>
                                                        <flux:text>
                                                            Apakah kamu yakin
                                                            ingin menghapus event
                                                            ini?
                                                        </flux:text>
                                                    </div>

                                                    <div
                                                        class="flex flex-row items-center gap-2">
                                                        <flux:spacer />
                                                        <flux:modal.close>
                                                            <flux:button>
                                                                Batal
                                                            </flux:button>
                                                        </flux:modal.close>
                                                        <x-forms
                                                            action="{{ route('core.events.destroy', ['event' => $event]) }}"
                                                            method="DELETE"
                                                        >
                                                            <flux:button
                                                                type="submit"
                                                                variant="danger"
                                                            >
                                                                Hapus
                                                            </flux:button>
                                                        </x-forms>
                                                    </div>
                                                </div>
                                            </flux:modal>
                                        </div>
                                    </flux:tooltip>
                                </div>
                            </x-tables.cell>
                        </x-tables.row>
                    @empty
                        <x-tables.row>
                            <x-tables.cell
                                colspan="4"
                                class="text-center"
                            >
                                <flux:text>
                                    Tidak ada event
                                </flux:text>
                            </x-tables.cell>
                        </x-tables.row>
                    @endforelse
                </x-tables.rows>
            </x-tables.app>
            {{ $events?->onEachSide(1)?->links('components.paginations.app') }}
        </div>
    </x-cards.app>
</x-layouts.core>
