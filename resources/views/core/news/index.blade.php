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
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 border border-zinc-200">
                    <thead>
                        <tr class="bg-zinc-100 dark:bg-zinc-600">
                            <th
                                scope="col"
                                class="px-4 py-2"
                            >
                                <flux:subheading>
                                    Judul
                                </flux:subheading>
                            </th>
                            <th
                                scope="col"
                                class="px-4 py-2"
                            >
                                <flux:subheading>
                                    Penulis
                                </flux:subheading>
                            </th>
                            <th
                                scope="col"
                                class="px-4 py-2"
                            >
                                <flux:subheading>
                                    Sudah Publish?
                                </flux:subheading>
                            </th>

                            <th
                                scope="col"
                                class="px-4 py-2"
                            >
                                <flux:subheading>
                                    Aksi
                                </flux:subheading>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200">
                        @forelse ($news as $newsData)
                            <tr class="hover:bg-zinc-200 dark:hover:bg-zinc-800">
                                <td class="whitespace-nowrap px-4 py-2">
                                    {{ $newsData?->title }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    {{ $newsData?->user?->name }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-center">
                                    <livewire:switch-publish-news :news="$newsData" />
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="5"
                                    class="whitespace-nowrap px-4 py-2 text-center"
                                >
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $news?->onEachSide(1)?->links('components.paginations.app') }}
            </div>
        </div>
    </x-cards.app>
</x-layouts.core>
