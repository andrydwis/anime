<div>
    <x-button
        :variant="$animeWatchlist ? 'danger' : 'primary'"
        :icon="$animeWatchlist ? 'bookmark-slash' : 'bookmark'"
        wire:click="{{ $animeWatchlist ? 'remove' : 'save' }}"
        wire:target="save, remove"
    >
        {{ $animeWatchlist ? 'Hapus dari Watchlist' : 'Simpan ke Watchlist' }}
    </x-button>
</div>
