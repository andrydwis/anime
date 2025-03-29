<div>
    <flux:modal.trigger name="search">
        <flux:button icon="magnifying-glass" />
    </flux:modal.trigger>

    <flux:modal
        name="search"
        class="md:min-h-auto h-full min-h-svh w-full !rounded-none md:h-3/4 md:!rounded-lg"
    >
        <div class="flex min-h-full flex-col gap-4">
            <div class="flex flex-col">
                <flux:heading>
                    Cari Anime atau Manga
                </flux:heading>
                <flux:text>
                    Masukkan judul anime atau manga yang kamu cari
                </flux:text>
            </div>

            <flux:input
                icon="magnifying-glass"
                placeholder="Judul anime atau manga"
                wire:model.live.debounce.500ms="search"
            >
                <x-slot name="iconTrailing">
                    <flux:icon.loading
                        wire:loading
                        wire:target="search"
                    />
                </x-slot>
            </flux:input>

            <div class="flex h-0 flex-grow flex-col gap-2 overflow-auto rounded-lg">
                <div class="grid grid-cols-2 gap-2 md:grid-cols-3">
                    @for ($i = 0; $i < 9; $i++)
                        <x-cards.app
                            wire:loading
                            wire:target="search"
                            class="aspect-[3/4] animate-pulse !bg-zinc-200 !p-2 dark:!bg-zinc-600"
                        >
                            <div class="flex flex-col gap-2">
                                <div
                                    class="w-full rounded-lg bg-white p-4 dark:bg-zinc-400">
                                </div>
                                <div
                                    class="w-3/4 rounded-lg bg-white p-4 dark:bg-zinc-400">
                                </div>
                            </div>
                        </x-cards.app>
                    @endfor
                    @if ($search && !empty($animes))
                        <div class="col-span-2 md:col-span-3">
                            <flux:heading>
                                Anime
                            </flux:heading>
                        </div>
                    @endif
                    @foreach ($animes as $anime)
                        <x-cards.anime
                            wire:loading.remove
                            wire:target="search"
                            :anime="$anime"
                        />
                    @endforeach
                    @if ($search && !empty($mangas))
                        <div class="col-span-2 md:col-span-3">
                            <flux:heading>
                                Manga
                            </flux:heading>
                        </div>
                    @endif
                    @foreach ($mangas as $manga)
                        <div>
                            <flux:link
                                href="{{ route('manga.show', ['manga' => $manga['id']]) }}"
                            >
                                {{ $manga['title'] }}
                            </flux:link>
                        </div>
                    @endforeach

                    @if ($search && !empty($animes) && !empty($mangas))
                        <x-cards.app
                            wire:loading.remove
                            wire:target="search"
                            class="col-span-2 md:col-span-3"
                        >
                            <flux:heading>
                                Anime atau Manga Tidak Ditemukan
                            </flux:heading>
                            <flux:text>
                                Oops! Anime yang kamu cari tidak ditemukan.
                                Coba cari kata kunci lain.
                            </flux:text>
                        </x-cards.app>
                    @endif
                </div>
            </div>
        </div>
    </flux:modal>
</div>
