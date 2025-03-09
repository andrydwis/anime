<x-layouts.core title="Tambah Berita">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item href="{{ route('core.news.index') }}">
            Berita
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Tambah Berita
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-row items-center justify-between">
        <div>
            <flux:heading
                size="xl"
                class="!font-semibold"
            >
                Tambah Berita
            </flux:heading>
            <flux:subheading>
                Berita terbaru seputar anime, manga, game, dan lainnya
            </flux:subheading>
        </div>
    </div>

    <x-cards.app>
        <x-forms
            action="{{ route('core.news.store') }}"
            method="POST"
        >
            <div class="flex flex-col gap-4">
                <flux:input
                    label="Gambar"
                    type="file"
                    name="image"
                />
                <flux:input
                    label="Link Gambar"
                    type="url"
                    name="image_url"
                    placeholder="Masukkan link gambar"
                    value="{{ old('image_url', isset($newsData['image']) ? $newsData['image'] : null) }}"
                    clearable
                />
                <flux:input
                    label="Judul"
                    type="text"
                    name="title"
                    placeholder="Masukkan judul berita"
                    value="{{ old('title', isset($newsData['title']) ? $newsData['title'] : null) }}"
                    required
                    clearable
                />
                <flux:field>
                    <flux:label>Konten</flux:label>

                    <flux:textarea
                        id="content"
                        name="content"
                        placeholder="Masukkan konten berita"
                        class="hidden"
                    >
                        {!! old('content', isset($newsData['content']) ? $newsData['content'] : null) !!}
                    </flux:textarea>
                    <!-- Create the editor container -->
                    <div class="bg-white !text-zinc-800">
                        <div id="editor">
                            {!! old('content', isset($newsData['content']) ? $newsData['content'] : null) !!}
                        </div>
                    </div>

                    <flux:error name="content" />
                </flux:field>
                <div class="flex flex-row items-center justify-end gap-2">
                    <flux:button href="{{ route('core.news.index') }}">
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
        </x-forms>
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
