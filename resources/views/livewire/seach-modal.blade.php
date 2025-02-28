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
        placeholder="Search orders"
        wire:model.live.debounce.500ms="search"
    >
        <x-slot name="iconTrailing">
            <flux:icon.loading
                wire:loading
                wire:target="search"
            />
        </x-slot>
    </flux:input>

    <div class="grid gap-4 lg:grid-cols-2">
        @forelse ($animes as $anime)
            <x-cards.anime :anime="$anime" />
        @empty
            <x-cards.app class="col-span-2">
                <flux:heading>
                    Anime Tidak Ditemukan
                </flux:heading>
                <flux:subheading>
                    Oops! Anime yang kamu cari tidak ditemukan. Coba cari kata kunci lain.
                </flux:subheading>
            </x-cards.app>
        @endforelse
    </div>
</div>
