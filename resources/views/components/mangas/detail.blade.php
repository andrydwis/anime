@props(['manga'])
<x-cards.app>
    <div class="flex flex-col gap-2">
        <div class="flex flex-col">
            <flux:heading
                size="xl"
                level="h1"
                class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
            >
                {{ $manga['title'] }}
            </flux:heading>
        </div>

        <div class="flex flex-row flex-wrap items-center gap-2">
            @php
                $colors = [
                    'zinc',
                    'red',
                    'orange',
                    'amber',
                    'yellow',
                    'lime',
                    'green',
                    'emerald',
                    'teal',
                    'cyan',
                    'sky',
                    'blue',
                    'indigo',
                    'violet',
                    'purple',
                    'fuchsia',
                    'pink',
                    'rose',
                ];
            @endphp

            @foreach ($manga['genres'] as $genre)
                @php
                    $randomColor = $colors[array_rand($colors)];
                @endphp
                <flux:badge
                    size="sm"
                    color="{{ $randomColor }}"
                >
                    {{ $genre }}
                </flux:badge>
            @endforeach
        </div>

        <div class="flex flex-row flex-wrap items-center gap-2">
            <flux:badge
                size="sm"
                color="emerald"
                icon="calendar-date-range"
            >
                {{ $manga['releaseDate'] }}
            </flux:badge>
        </div>

        <flux:text>
            {{ $manga['description']['en'] }}
        </flux:text>

        <flux:separator text="Daftar Chapter" />

        <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
            @foreach ($manga['chapters'] as $chapter)
                <flux:button
                    href="{{ route('manga.read', ['mangaId' => $manga['id'], 'chapterId' => $chapter['id']]) }}"
                >
                    {{ $chapter['title'] }}
                </flux:button>
            @endforeach
        </div>
    </div>
</x-cards.app>
