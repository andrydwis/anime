@props(['animeId', 'anime'])
<x-cards.app>
    <div class="grid gap-2 md:grid-cols-2 lg:grid-cols-4">
        <img
            src="{{ $anime['image'] }}"
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
                    {{ $anime['title'] }}
                </flux:heading>
                <flux:heading
                    size="lg"
                    level="h1"
                    class="!font-semibold"
                >
                    {{ $anime['details']['japanese-title'] }}
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

                @foreach ($anime['details']['genres'] as $genre)
                    @php
                        $randomColor = $colors[array_rand($colors)];
                    @endphp
                    <a href="{{ route('anime.genre.show', ['genre' => $genre['id']]) }}">
                        <flux:badge
                            size="sm"
                            color="{{ $randomColor }}"
                        >
                            {{ $genre['name'] }}
                        </flux:badge>
                    </a>
                @endforeach
            </div>

            <div class="flex flex-row flex-wrap items-center gap-2">
                <flux:badge
                    size="sm"
                    color="emerald"
                    icon="calendar-date-range"
                >
                    {{ $anime['details']['status'] }}
                </flux:badge>
                <flux:badge
                    size="sm"
                    icon="numbered-list"
                >
                    {{ $anime['episodes'] }} Episode
                </flux:badge>
                <flux:badge
                    size="sm"
                    icon="clock"
                >
                    {{ $anime['details']['duration'] }}
                </flux:badge>
            </div>
            <div class="flex flex-row flex-wrap items-center gap-2">
                <flux:badge
                    size="sm"
                    color="amber"
                    icon="star"
                >
                    {{ $anime['details']['mal-score'] }}/10
                </flux:badge>
                <flux:badge
                    size="sm"
                    color="cyan"
                    icon="cloud"
                >
                    {{ $anime['details']['season'] }}
                </flux:badge>
                @foreach ($anime['details']['studios'] as $studio)
                    <flux:badge
                        size="sm"
                        color="blue"
                        icon="home-modern"
                    >
                        {{ $studio }}
                    </flux:badge>
                @endforeach
            </div>

            <flux:subheading level="h3">
                {{ $anime['description'] }}
            </flux:subheading>
        </div>
    </div>

</x-cards.app>
