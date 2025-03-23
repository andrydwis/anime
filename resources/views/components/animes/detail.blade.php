@props(['animeId', 'anime'])
<x-cards.app>
    <div class="grid gap-2 md:grid-cols-2 lg:grid-cols-4">
        <img
            src="{{ $anime['data']['poster'] }}"
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
                    {{ !empty($anime['data']['title']) ? $anime['data']['title'] : $anime['data']['synonyms'] }}
                </flux:heading>
                <flux:heading
                    size="lg"
                    level="h1"
                    class="!font-semibold"
                >
                    {{ $anime['data']['japanese'] }}
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

                @foreach ($anime['data']['genreList'] as $genre)
                    @php
                        $randomColor = $colors[array_rand($colors)];
                    @endphp
                    <a
                        href="{{ route('anime.genre.show', ['genre' => $genre['genreId']]) }}">
                        <flux:badge
                            size="sm"
                            color="{{ $randomColor }}"
                        >
                            {{ $genre['title'] }}
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
                    {{ $anime['data']['status'] }}
                </flux:badge>
                <flux:badge
                    size="sm"
                    icon="numbered-list"
                >
                    {{ $anime['data']['episodes'] }} Episode
                </flux:badge>
                <flux:badge
                    size="sm"
                    icon="clock"
                >
                    {{ $anime['data']['duration'] }}
                </flux:badge>
            </div>
            <div class="flex flex-row flex-wrap items-center gap-2">
                <flux:badge
                    size="sm"
                    color="amber"
                    icon="star"
                >
                    {{ $anime['data']['score']['value'] }}/10
                </flux:badge>
                <flux:badge
                    size="sm"
                    color="cyan"
                    icon="cloud"
                >
                    {{ $anime['data']['season'] }}
                </flux:badge>
                <flux:badge
                    size="sm"
                    color="blue"
                    icon="home-modern"
                >
                    {{ $anime['data']['studios'] }}
                </flux:badge>
            </div>

            <flux:subheading level="h3">
                {{ implode(' ', $anime['data']['synopsis']['paragraphs']) }}
            </flux:subheading>
        </div>
    </div>

</x-cards.app>
