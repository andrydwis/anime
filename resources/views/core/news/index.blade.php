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
        <div class="flex flex-row items-center gap-2">
            <div>
                <flux:modal.trigger name="scrape">
                    <flux:button icon="sparkles">
                        Scraping Berita
                    </flux:button>
                </flux:modal.trigger>
                <flux:modal
                    name="scrape"
                    class="md:min-h-auto h-full min-h-svh w-full !rounded-none md:h-3/4 md:!rounded-lg"
                >
                    <x-forms
                        action="{{ route('core.news.create') }}"
                        method="GET"
                        class="flex min-h-full flex-col gap-4"
                    >
                        <div>
                            <flux:heading>
                                Scraping Berita
                            </flux:heading>
                            <flux:subheading>
                                Masukkan link berita yang akan di scraping
                            </flux:subheading>
                        </div>

                        <flux:input
                            type="url"
                            label="Link Berita"
                            icon="link"
                            placeholder="Link Berita di MyAnimeList"
                            name="url"
                        />

                        <div class="flex">
                            <flux:spacer />

                            <flux:button
                                type="submit"
                                variant="primary"
                            >
                                Scraping
                            </flux:button>
                        </div>
                    </x-forms>
                </flux:modal>
            </div>
            <flux:button
                variant="primary"
                icon="plus"
                href="{{ route('core.news.create') }}"
            >
                Tambah
            </flux:button>
        </div>
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
                    @forelse ($news as $newsData)
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
                                                        <x-forms
                                                            action="{{ route('core.news.destroy', ['news' => $newsData]) }}"
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
                                <flux:subheading>
                                    Tidak ada berita
                                </flux:subheading>
                            </x-tables.cell>
                        </x-tables.row>
                    @endforelse
                </x-tables.rows>
            </x-tables.app>
            {{ $news?->onEachSide(1)?->links('components.paginations.app') }}
        </div>
    </x-cards.app>
</x-layouts.core>
