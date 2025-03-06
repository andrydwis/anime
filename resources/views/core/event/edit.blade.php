<x-layouts.core title="Edit Event">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item href="{{ route('core.events.index') }}">
            Event
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ $event?->name }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Edit Event
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-row items-center justify-between">
        <div>
            <flux:heading
                size="xl"
                class="!font-semibold"
            >
                Edit Event
            </flux:heading>
            <flux:subheading>
                Informasi terbaru event yang akan datang
            </flux:subheading>
        </div>
    </div>

    <x-cards.app>
        <form
            action="{{ route('core.events.update', ['event' => $event]) }}"
            method="post"
            enctype="multipart/form-data"
        >
            @csrf
            @method('patch')
            <div class="flex flex-col gap-4">
                <flux:input
                    label="Gambar"
                    type="file"
                    name="image"
                />
                <flux:input
                    label="Nama"
                    type="text"
                    name="name"
                    placeholder="Masukkan nama event"
                    value="{{ old('name', $event?->name) }}"
                    clearable
                />
                <flux:field>
                    <flux:label>Konten</flux:label>

                    <flux:textarea
                        id="content"
                        name="content"
                        placeholder="Masukkan konten event"
                        class="hidden"
                    >
                        {!! old('content', $event?->content) !!}
                    </flux:textarea>
                    <!-- Create the editor container -->
                    <div class="bg-white !text-zinc-800">
                        <div id="editor">
                            {!! old('content', $event?->content) !!}
                        </div>
                    </div>

                    <flux:error name="content" />
                </flux:field>
                <div class="grid gap-2 lg:grid-cols-2">
                    <flux:input
                        type="date"
                        label="Tanggal Mulai"
                        name="start_date"
                        value="{{ old('start_date', $event?->start_date?->format('Y-m-d')) }}"
                        clearable
                    />
                    <flux:input
                        type="date"
                        label="Tanggal Selesai"
                        name="end_date"
                        value="{{ old('end_date', $event?->end_date?->format('Y-m-d')) }}"
                        clearable
                    />
                </div>
                <livewire:region-input
                    :selectedProvince="old('province_id', $event?->province_id)"
                    :selectedCity="old('city_id', $event?->city_id)"
                />
                <div class="flex flex-row items-center justify-end gap-2">
                    <flux:button href="{{ route('core.events.index') }}">
                        Kembali
                    </flux:button>
                    <flux:button
                        variant="primary"
                        type="submit"
                    >
                        Simpan
                    </flux:button>
                </div>
            </div>
        </form>
    </x-cards.app>

    @push('styles')
        <link
            href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css"
            rel="stylesheet"
        />
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script>
            const quill = new Quill('#editor', {
                theme: 'snow'
            });

            quill.on('text-change', (delta, oldDelta, source) => {
                document.getElementById('content').value = quill.root.innerHTML;
            });
        </script>
    @endpush
</x-layouts.core>
