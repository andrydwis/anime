<div class="flex flex-col gap-2">
    <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
        @forelse ($playlist->data ?? [] as $anime)
            <div class="relative flex flex-col gap-2">
                <x-cards.anime :anime="$anime" />
                @if ($isMyPlaylist)
                    <flux:button
                        size="sm"
                        icon="trash"
                        wire:click="delete('{{ $anime['animeId'] }}')"
                        class="cursor-pointer"
                    >
                        Hapus
                    </flux:button>
                @endif
            </div>
        @empty
            <x-cards.app class="col-span-4">
                <flux:heading>
                    Belum ada anime
                </flux:heading>
                <flux:subheading>
                    Kamu belum menambahkan anime ke playlist
                </flux:subheading>
            </x-cards.app>
        @endforelse
    </div>
    @if ($isMyPlaylist)
        <div class="flex flex-col gap-2">
            <div>
                <flux:modal.trigger name="add-anime">
                    <flux:button
                        variant="primary"
                        icon="plus"
                        class="w-full"
                    >
                        Tambah Anime
                    </flux:button>
                </flux:modal.trigger>
                <flux:modal
                    name="add-anime"
                    class="md:min-h-auto h-full min-h-svh w-full !rounded-none md:h-3/4 md:!rounded-lg"
                >
                    <div class="flex min-h-full flex-col gap-4">
                        <div>
                            <flux:heading>
                                Cari Anime
                            </flux:heading>
                            <flux:subheading>
                                Masukkan judul anime yang kamu cari
                            </flux:subheading>
                        </div>

                        <flux:input
                            icon="magnifying-glass"
                            placeholder="Judul anime"
                            wire:model.live.debounce.500ms="search"
                        >
                            <x-slot name="iconTrailing">
                                <flux:icon.loading
                                    wire:loading
                                    wire:target="search"
                                />
                            </x-slot>
                        </flux:input>

                        <div
                            class="flex h-0 flex-grow flex-col gap-2 overflow-auto rounded-lg">
                            <div class="grid grid-cols-2 gap-2">
                                @for ($i = 0; $i < 8; $i++)
                                    <x-cards.app
                                        wire:loading
                                        wire:target="search"
                                        class="aspect-video animate-pulse !bg-zinc-200 dark:!bg-zinc-600"
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
                                @forelse ($animes as $anime)
                                    <div
                                        wire:loading.remove
                                        wire:target="search"
                                    >
                                        <div
                                            class="group relative flex flex-col overflow-hidden rounded-lg">
                                            <img
                                                loading="lazy"
                                                src="{{ $anime['poster'] }}"
                                                alt="cover"
                                                class="aspect-video object-cover transition-all group-hover:scale-110 group-hover:brightness-50"
                                            >
                                            @if (isset($anime['episodes']))
                                                <flux:badge
                                                    variant="solid"
                                                    size="sm"
                                                    color="emerald"
                                                    icon="play-circle"
                                                    class="pointer-events-none absolute right-2 top-2"
                                                >
                                                    Eps {{ $anime['episodes'] }}
                                                </flux:badge>
                                            @endif
                                            @if (!in_array($anime, $savedAnimes))
                                                <flux:button
                                                    icon="plus"
                                                    class="!absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 cursor-pointer !rounded-full !bg-white/50 !text-white opacity-0 transition-all group-hover:border-2 group-hover:!border-white group-hover:opacity-100"
                                                    wire:click="add('{{ $anime['animeId'] }}')"
                                                />
                                            @else
                                                <flux:button
                                                    icon="trash"
                                                    class="!absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 cursor-pointer !rounded-full !bg-red-600/50 !text-white opacity-0 transition-all group-hover:border-2 group-hover:!border-white group-hover:opacity-100"
                                                    wire:click="delete('{{ $anime['animeId'] }}')"
                                                />
                                            @endif
                                            @if (!in_array($anime, $savedAnimes))
                                                <div
                                                    class="pointer-events-none absolute bottom-0 w-full bg-white/75 p-2 dark:bg-zinc-900/50">
                                                    <flux:heading
                                                        class="line-clamp-1 group-hover:underline"
                                                    >
                                                        {{ $anime['title'] }}
                                                    </flux:heading>
                                                </div>
                                            @else
                                                <div
                                                    class="pointer-events-none absolute bottom-0 w-full bg-emerald-600/75 p-2 dark:bg-emerald-900/50">
                                                    <flux:heading
                                                        class="line-clamp-1 group-hover:underline"
                                                    >
                                                        {{ $anime['title'] }}
                                                    </flux:heading>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    @if ($search)
                                        <x-cards.app class="col-span-2">
                                            <flux:heading>
                                                Anime Tidak Ditemukan
                                            </flux:heading>
                                            <flux:subheading>
                                                Oops! Anime yang kamu cari tidak
                                                ditemukan.
                                                Coba
                                                cari
                                                kata
                                                kunci
                                                lain.
                                            </flux:subheading>
                                        </x-cards.app>
                                    @endif
                                @endforelse
                            </div>
                        </div>
                    </div>
                </flux:modal>
            </div>
            <flux:button
                icon="{{ $playlist?->is_public ? 'eye-slash' : 'globe-alt' }}"
                wire:click="toggleIsPublic"
            >
                {{ $playlist?->is_public ? 'Set Playlist Pribadi' : 'Set Playlist Publik' }}
            </flux:button>
        </div>

    @endif
</div>
