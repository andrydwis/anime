<x-layouts.core title="Berita">
    <x-alerts.app />

    <div class="flex flex-row items-center justify-between">
        <div>
            <flux:heading
                size="xl"
                class="!font-semibold"
            >
                Berita
            </flux:heading>
            <flux:subheading>
                Berita terbaru seputar anime, manga, game, dan lainnya
            </flux:subheading>
        </div>
        <flux:button
            variant="primary"
            icon="plus"
            href="{{ route('core.news.create') }}"
        >
            Tambah
        </flux:button>
    </div>

    <x-cards.app>
        <div class="flex flex-col gap-2">
            <x-tables.app>
                <x-tables.columns>
                    <x-tables.column>
                        Judul
                    </x-tables.column>
                    <x-tables.column>
                        Penulis
                    </x-tables.column>
                    <x-tables.column>
                        Sudah Publish?
                    </x-tables.column>
                    <x-tables.column>
                        Aksi
                    </x-tables.column>
                </x-tables.columns>
                <x-tables.rows>
                    @foreach ($news as $newsData)
                        <x-tables.row>
                            <x-tables.cell>
                                {{ $newsData?->title }}
                            </x-tables.cell>
                            <x-tables.cell>
                                {{ $newsData?->user?->name }}
                            </x-tables.cell>
                            <x-tables.cell class="text-center">
                                <livewire:switch-publish-news :news="$newsData" />
                            </x-tables.cell>
                            <x-tables.cell>
                                <div
                                    class="flex flex-row items-center justify-center gap-2">
                                    <flux:tooltip content="Edit">
                                        <flux:button
                                            icon="pencil"
                                            size="xs"
                                            href="{{ route('core.news.edit', ['news' => $newsData]) }}"
                                        />
                                    </flux:tooltip>
                                    <flux:tooltip content="Hapus">
                                        <div>
                                            <flux:modal.trigger
                                                name="delete-news-{{ $newsData?->id }}"
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
                                                name="delete-news-{{ $newsData?->id }}"
                                            >
                                                <div class="flex flex-col gap-2">
                                                    <div>
                                                        <flux:heading size="lg">
                                                            Hapus Berita
                                                        </flux:heading>
                                                        <flux:subheading>
                                                            Apakah kamu yakin
                                                            ingin menghapus berita
                                                            ini?
                                                        </flux:subheading>
                                                    </div>

                                                    <div
                                                        class="flex flex-row items-center gap-2">
                                                        <flux:spacer />
                                                        <flux:modal.close>
                                                            <flux:button>
                                                                Batal
                                                            </flux:button>
                                                        </flux:modal.close>
                                                        <form
                                                            action="{{ route('core.news.destroy', ['news' => $newsData]) }}"
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
                                    </flux:tooltip>
                                </div>
                            </x-tables.cell>
                        </x-tables.row>
                    @endforeach
                </x-tables.rows>
            </x-tables.app>
            {{ $news?->onEachSide(1)?->links('components.paginations.app') }}
        </div>
    </x-cards.app>
</x-layouts.core>
