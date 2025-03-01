<div class="flex flex-col gap-4">
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

    <div class="grid grid-cols-2 gap-2">
        @for ($i = 0; $i < 8; $i++)
            <x-cards.app
                wire:loading
                wire:target="search"
                class="aspect-video animate-pulse"
            />
        @endfor
        @forelse ($animes as $anime)
            <x-cards.anime
                wire:loading.remove
                wire:target="search"
                :anime="$anime"
            />
        @empty
            @if ($search)
                <x-cards.app class="col-span-2">
                    <flux:heading>
                        Anime Tidak Ditemukan
                    </flux:heading>
                    <flux:subheading>
                        Oops! Anime yang kamu cari tidak ditemukan. Coba cari kata kunci
                        lain.
                    </flux:subheading>
                </x-cards.app>
            @endif
        @endforelse
    </div>
</div>
