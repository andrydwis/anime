<div>
    @auth
        <flux:dropdown>
            <flux:button icon="bookmark">
                Simpan Anime
            </flux:button>

            <flux:menu>
                <flux:menu.item
                    :variant="$animeWatchlist ? 'danger' : 'default'"
                    :icon="$animeWatchlist ? 'bookmark-slash' : 'bookmark'"
                    wire:click="{{ $animeWatchlist ? 'remove' : 'save' }}"
                    wire:target="save, remove"
                >
                    {{ $animeWatchlist ? 'Hapus dari Watchlist' : 'Simpan ke Watchlist' }}
                </flux:menu.item>

                <flux:menu.separator />

                <flux:menu.submenu
                    icon="bookmark"
                    heading="Simpan ke..."
                >
                    @forelse ($animePlaylists as $playlist)
                        @php
                            // Extract all 'title' values from $playlist['data']
                            $playlistIds = collect($playlist['data'])->pluck('animeId');

                            // Check if $animeSynonyms exists in $playlistTitles
                            $isSaved = $playlistIds->contains($animeId);
                        @endphp
                        <flux:menu.item
                            :variant="$isSaved ? 'danger' : 'default'"
                            :icon="$isSaved ? 'bookmark-slash' : 'bookmark'"
                            wire:click="{{ $isSaved ? 'removeFromPlaylist(\'' . $playlist['id'] . '\')' : 'saveToPlaylist(\'' . $playlist['id'] . '\')' }}"
                        >
                            {{ $playlist['name'] }}
                        </flux:menu.item>
                    @empty
                        <flux:menu.item
                            icon="hashtag"
                            disabled
                        >
                            Belum Ada Playlist
                        </flux:menu.item>
                    @endforelse

                    <flux:menu.separator />

                    <flux:modal.trigger name="add-playlist">
                        <flux:menu.item icon="plus">
                            Tambah Playlist Baru
                        </flux:menu.item>
                    </flux:modal.trigger>
                </flux:menu.submenu>
            </flux:menu>
        </flux:dropdown>

        <flux:modal
            name="add-playlist"
            class="md:min-h-auto h-full min-h-svh w-full !rounded-none md:h-max md:!rounded-lg"
        >
            <x-forms
                wire:submit.prevent="saveToNewPlaylist"
                method="POST"
                class="flex min-h-full flex-col gap-4"
            >
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
                    wire:model="playlistName"
                    required
                    clearable
                />

                <flux:button
                    variant="primary"
                    type="submit"
                    class="mt-auto"
                >
                    Simpan
                </flux:button>
            </x-forms>
        </flux:modal>
    @else
        <flux:button
            icon="bookmark"
            href="{{ route('login') }}"
        >
            Simpan ke Anime
        </flux:button>
    @endauth
</div>
