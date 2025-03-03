<div>
    <flux:modal.trigger name="search">
        <flux:button icon="magnifying-glass" />
    </flux:modal.trigger>

    <flux:modal
        name="search"
        class="md:min-h-auto h-full min-h-svh w-full !rounded-none md:h-3/4 md:!rounded-lg"
    >
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
                        class="aspect-video animate-pulse !bg-zinc-200 dark:!bg-zinc-600"
                    >
                        <div class="flex flex-col gap-2">
                            <div class="w-full rounded-lg bg-white p-4 dark:bg-zinc-400">
                            </div>
                            <div class="w-3/4 rounded-lg bg-white p-4 dark:bg-zinc-400">
                            </div>
                        </div>
                    </x-cards.app>
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
                                Oops! Anime yang kamu cari tidak ditemukan. Coba cari kata
                                kunci
                                lain.
                            </flux:subheading>
                        </x-cards.app>
                    @endif
                @endforelse
            </div>
        </div>
    </flux:modal>
</div>
