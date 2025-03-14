@props(['anime'])
<x-cards.app>
    <div class="grid gap-2 md:grid-cols-2 lg:grid-cols-4">
        <img
            src="{{ $anime['info']['img'] }}"
            alt="cover"
            class="w-full rounded-lg"
        >
        <div class="flex flex-col gap-2 lg:col-span-3">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    {{ $anime['info']['name'] }}
                </flux:heading>
                <flux:heading
                    size="lg"
                    level="h1"
                    class="!font-semibold"
                >
                    {{ $anime['moreInfo']['Japanese:'] }}
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

                @foreach ($anime['moreInfo']['Genres'] as $genre)
                    @php
                        $randomColor = $colors[array_rand($colors)];
                    @endphp
                    <flux:badge
                        size="sm"
                        color="{{ $randomColor }}"
                        href="{{ $genre }}"
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
                    {{ $anime['moreInfo']['Status:'] }}
                </flux:badge>
                <flux:badge
                    size="sm"
                    icon="numbered-list"
                >
                    {{ $anime['info']['episodes']['sub'] }} Episode
                </flux:badge>
                <flux:badge
                    size="sm"
                    icon="clock"
                >
                    {{ $anime['info']['duration'] }}
                </flux:badge>
            </div>
            <div class="flex flex-row flex-wrap items-center gap-2">
                <flux:badge
                    size="sm"
                    color="amber"
                    icon="star"
                >
                    {{ $anime['moreInfo']['MAL Score:'] }}/10
                </flux:badge>
                <flux:badge
                    size="sm"
                    color="cyan"
                    icon="cloud"
                >
                    {{ $anime['moreInfo']['Premiered:'] }}
                </flux:badge>
                <flux:badge
                    size="sm"
                    color="blue"
                    icon="home-modern"
                >
                    {{ $anime['moreInfo']['Studios:'] }}
                </flux:badge>
            </div>

            <flux:subheading level="h3">
                {{ $anime['info']['description'] }}
            </flux:subheading>
        </div>
    </div>

</x-cards.app>
