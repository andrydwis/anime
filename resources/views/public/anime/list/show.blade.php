<x-layouts.app title="{{ $playlist?->name }}">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('anime.index') }}">
            Daftar Anime
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('anime.list.index') }}">
            Daftar Anime Saya
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ $playlist?->name }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <x-alerts.app />

    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    {{ $playlist?->name }}
                </flux:heading>
                <flux:subheading level="h2">
                    Detail playlist {{ $playlist?->name }}
                </flux:subheading>
            </div>
        </div>

        <x-cards.app>
            <div class="flex flex-col gap-2">
                <div class="!text-zinc-800 dark:!text-white">
                    <div
                        id="editor"
                        class="rounded-lg !border-zinc-200 dark:!border-zinc-600"
                    >
                        {!! $playlist?->description !!}
                    </div>
                </div>
                <livewire:form-anime-playlist
                    :playlist="$playlist"
                    :isMyPlaylist="$isMyPlaylist"
                />
                @if ($isMyPlaylist)
                    <flux:separator />
                    <div>
                        <flux:modal.trigger name="edit-playlist">
                            <flux:button
                                icon="pencil"
                                class="w-full"
                            >
                                Edit Playlist
                            </flux:button>
                        </flux:modal.trigger>
                        <flux:modal
                            name="edit-playlist"
                            class="md:min-h-auto h-full min-h-svh w-full !rounded-none md:h-3/4 md:!rounded-lg"
                        >
                            <form
                                action="{{ route('anime.list.update', ['playlist' => $playlist]) }}"
                                method="post"
                                class="flex min-h-full flex-col gap-4"
                            >
                                @csrf
                                @method('patch')
                                <div>
                                    <flux:heading>
                                        Tambah Playlist
                                    </flux:heading>
                                    <flux:subheading>
                                        Buat playlist baru kumpulan anime favoritmu
                                    </flux:subheading>
                                </div>

                                <flux:input
                                    label="Judul"
                                    placeholder="Judul playlist"
                                    name="name"
                                    value="{{ old('name', $playlist?->name) }}"
                                    required
                                    clearable
                                />

                                <flux:field>
                                    <flux:label>Deskripsi</flux:label>

                                    <flux:textarea
                                        id="description"
                                        name="description"
                                        placeholder="Masukkan deskripsi playlist"
                                        class="hidden"
                                    >
                                        {!! old('description', $playlist?->description) !!}
                                    </flux:textarea>
                                    <!-- Create the editor container -->
                                    <div class="bg-white !text-zinc-800">
                                        <div
                                            id="editor-playlist"
                                            class="!h-[200px] w-full"
                                        >
                                            {!! old('description', $playlist?->description) !!}
                                        </div>
                                    </div>

                                    <flux:error name="description" />
                                </flux:field>

                                <flux:button
                                    variant="primary"
                                    type="submit"
                                    class="mt-auto"
                                >
                                    Simpan
                                </flux:button>
                            </form>
                        </flux:modal>
                    </div>
                    <div>
                        <flux:modal.trigger name="delete-playlist">
                            <flux:button
                                variant="danger"
                                icon="trash"
                                class="w-full"
                            >
                                Hapus Playlist
                            </flux:button>
                        </flux:modal.trigger>
                        <flux:modal
                            variant="flyout"
                            position="bottom"
                            name="delete-playlist"
                        >
                            <div class="flex flex-col gap-2">
                                <div>
                                    <flux:heading size="lg">
                                        Hapus Playlist
                                    </flux:heading>
                                    <flux:subheading>
                                        Apakah kamu yakin
                                        ingin menghapus playlist
                                        ini?
                                    </flux:subheading>
                                </div>

                                <div class="flex flex-row items-center gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button>
                                            Batal
                                        </flux:button>
                                    </flux:modal.close>
                                    <form
                                        action="{{ route('anime.list.destroy', ['playlist' => $playlist]) }}"
                                        method="post"
                                    >
                                        @csrf
                                        @method('delete')
                                        <flux:button
                                            type="submit"
                                            variant="danger"
                                        >
                                            Hapus
                                        </flux:button>
                                    </form>
                                </div>
                            </div>
                        </flux:modal>
                    </div>
                @endif
            </div>
        </x-cards.app>
    </div>

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
                readOnly: true,
                modules: {
                    toolbar: null
                },
                theme: 'snow'
            });

            const quillPlaylist = new Quill('#editor-playlist', {
                theme: 'snow'
            });
        </script>
    @endpush
</x-layouts.app>
