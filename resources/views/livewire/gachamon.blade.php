<div class="flex flex-col gap-2">
    <flux:callout
        color="amber"
        icon="exclamation-circle"
        heading="Fitur Masih Dalam Pengembangan."
    />
    <div class="grid gap-2 md:grid-cols-2">
        <div class="flex flex-row justify-between gap-2 md:hidden">
            <flux:button
                variant="primary"
                icon="currency-dollar"
            >
                Wibux: {{ $currency }}
            </flux:button>
            <flux:button icon="clipboard-document-list">
                Misi Harian
            </flux:button>
        </div>

        @if (!empty($gachaResult))
            <x-cards.app
                wire:loading.remove
                wire:target="gacha"
            >
                <div class="flex flex-col gap-2">
                    <img
                        src="{{ $gachaResult['sprites']['other']['official-artwork']['front_default'] }}"
                        alt="sprite"
                        class="mx-auto aspect-square w-[200px] rounded-lg border border-zinc-200 object-contain p-4 dark:border-zinc-600"
                    >
                    <div class="flex flex-col">
                        <flux:heading>
                            {{ str()->title($gachaResult['name']) }}
                        </flux:heading>
                        @php
                            $species = collect(
                                $gachaResult['species']['names'],
                            )->firstWhere('language.name', 'ja-Hrkt');
                            $speciesName = $species['name'];
                        @endphp
                        <flux:subheading>
                            {{ str()->title($speciesName) }}
                        </flux:subheading>
                        <div class="mt-2 flex flex-row flex-wrap gap-2">
                            @foreach ($gachaResult['types'] as $type)
                                <flux:badge size="sm">
                                    {{ str()->title($type['type']['name']) }}
                                </flux:badge>
                            @endforeach
                        </div>
                    </div>
                    <flux:separator />
                    <flux:text>
                        @php
                            $flavorText = collect(
                                $gachaResult['species']['flavor_text_entries'],
                            )->firstWhere('language.name', 'en');
                        @endphp
                        {{ $flavorText['flavor_text'] }}
                    </flux:text>
                    <flux:separator />
                    <div class="flex flex-row items-center gap-2">
                        <flux:text>
                            Height / Weight:
                        </flux:text>
                        <flux:badge size="sm">
                            {{ $gachaResult['height'] }} dm
                        </flux:badge>
                        <flux:badge size="sm">
                            {{ $gachaResult['weight'] }} hg
                        </flux:badge>
                    </div>
                    <div class="flex flex-row flex-wrap items-center gap-2">
                        <flux:text>
                            Ability:
                        </flux:text>
                        @foreach ($gachaResult['abilities'] as $ability)
                            <flux:badge size="sm">
                                {{ str()->title($ability['ability']['name']) }}
                            </flux:badge>
                        @endforeach
                    </div>
                    <div class="flex flex-row flex-wrap items-center gap-2">
                        <flux:text>
                            Stats:
                        </flux:text>
                        @foreach ($gachaResult['stats'] as $stat)
                            <flux:badge size="sm">
                                {{ str()->title($stat['stat']['name']) }}:
                                {{ $stat['base_stat'] }}
                            </flux:badge>
                        @endforeach
                    </div>
                    <audio
                        id="cry-{{ $gachaResult['id'] }}"
                        controls
                        src="{{ $gachaResult['cries']['latest'] }}"
                        class="hidden"
                    ></audio>
                    <flux:button
                        icon="play"
                        onclick="document.getElementById('cry-{{ $gachaResult['id'] }}').play()"
                    >
                        Putar Suara Pokemon
                    </flux:button>
                </div>
            </x-cards.app>
        @else
            <x-cards.app
                wire:loading.remove
                wire:target="gacha"
            >
                <div class="flex flex-col gap-2">
                    <img
                        src="{{ asset('images/pokemon/pokeball.png') }}"
                        alt="pokeball"
                        class="z-10 mx-auto aspect-square w-[100px] object-contain transition-all hover:scale-110"
                    >
                    <div class="flex flex-col items-center">
                        <flux:heading class="text-center">
                            Klik Gacha untuk mendapatkan Pokemon!
                        </flux:heading>
                        <flux:subheading class="text-center">
                            Jangan lupa kerjakan misi harian untuk mendapatkan Wibux!
                        </flux:subheading>
                    </div>
                </div>
            </x-cards.app>
        @endif
        <x-cards.app
            wire:loading
            wire:target="gacha"
            class="relative"
        >
            <div class="flex h-full">
                <div class="m-auto flex flex-col gap-2">
                    <img
                        src="{{ asset('images/pokemon/pokeball.png') }}"
                        alt="pokeball"
                        class="z-10 mx-auto aspect-square w-[100px] animate-spin object-contain transition-all hover:scale-110"
                    >
                    <div class="flex flex-col items-center">
                        <flux:heading class="text-center">
                            Sedang Memanggil Pokemon ✨
                        </flux:heading>
                        <flux:subheading class="text-center">
                            Tunggu sebentar ya!
                        </flux:subheading>
                    </div>
                </div>
            </div>
        </x-cards.app>

        <flux:button
            variant="primary"
            icon="sparkles"
            wire:click="gacha"
            :disabled="$currency < $gachaCost"
            class="!flex md:!hidden"
        >
            Gacha!
        </flux:button>

        <div class="flex flex-col gap-2">
            <div class="hidden flex-row justify-between gap-2 md:flex">
                <flux:button
                    variant="primary"
                    icon="currency-dollar"
                >
                    Wibux: {{ $currency }}
                </flux:button>
                <flux:button icon="clipboard-document-list">
                    Misi Harian
                </flux:button>
            </div>
            <flux:heading>
                Riwayat Gacha
            </flux:heading>
            @php
                $gachaHistory = collect($gachaHistory)->reverse();
            @endphp
            @forelse ($gachaHistory as $history)
                <x-cards.app>
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row items-center gap-2">
                            <img
                                src="{{ $history['sprites']['other']['official-artwork']['front_default'] }}"
                                alt="sprite"
                                class="aspect-square w-[100px] rounded-lg border border-zinc-200 object-contain p-4 dark:border-zinc-600"
                            >
                            <div class="flex flex-col gap-2">
                                <div class="flex flex-col">
                                    <flux:heading>
                                        {{ str()->title($history['name']) }}
                                    </flux:heading>
                                    @php
                                        $species = collect(
                                            $history['species']['names'],
                                        )->firstWhere('language.name', 'ja-Hrkt');
                                        $speciesName = $species['name'];
                                    @endphp
                                    <flux:subheading>
                                        {{ str()->title($speciesName) }}
                                    </flux:subheading>
                                </div>
                                <div class="flex flex-row gap-2">
                                    @foreach ($history['types'] as $type)
                                        <flux:badge size="sm">
                                            {{ str()->title($type['type']['name']) }}
                                        </flux:badge>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </x-cards.app>
            @empty
                <x-cards.app>
                    <div class="flex flex-col">
                        <flux:heading>
                            Belum Ada Riwayat Gacha
                        </flux:heading>
                        <flux:subheading>
                            Ayo gacha sekarang!
                        </flux:subheading>
                    </div>
                </x-cards.app>
            @endforelse
        </div>
    </div>
    <flux:button
        variant="primary"
        icon="sparkles"
        wire:click="gacha"
        :disabled="$currency < $gachaCost"
        class="!hidden md:!flex"
    >
        Gacha!
    </flux:button>
</div>

@push('scripts')
    <script
        src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"
    ></script>
@endpush

@script
    <script>
        //when livewire gacha-result event is fired, play the sound
        Livewire.on('gacha-result', (event) => {
            const audio = new Audio(event['cries']['latest']);
            audio.play();

            const defaults = {
                spread: 360,
                ticks: 30, // Reduced from 50 to make the animation shorter
                gravity: 4, // Increased gravity to pull particles down faster
                decay: 0.94,
                startVelocity: 50, // Increased velocity to make particles move faster
                shapes: ["star"],
                colors: ["FFE400", "FFBD00", "E89400", "FFCA6C", "FDFFB8"],
            };

            function shoot() {
                confetti({
                    ...defaults,
                    particleCount: 40,
                    scalar: 1.2,
                    shapes: ["star"],
                    origin: {
                        x: 0.5,
                        y: 0.5
                    }, // Center of the screen
                });

                confetti({
                    ...defaults,
                    particleCount: 10,
                    scalar: 0.75,
                    shapes: ["circle"],
                    origin: {
                        x: 0.5,
                        y: 0.5
                    }, // Center of the screen
                });
            }

            // Trigger the confetti bursts at different times
            setTimeout(shoot, 0); // First burst
            setTimeout(shoot, 100); // Second burst
            setTimeout(shoot, 200); // Third burst
        });
    </script>
@endscript
