<x-layouts.app title="Daftar Anime">
    <div class="flex flex-col gap-8">
        <flux:breadcrumbs class="flex-wrap">
            <flux:breadcrumbs.item
                icon="home"
                href="{{ route('home') }}"
            />
            <flux:breadcrumbs.item>
                Anime
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex flex-col gap-2">
            <div
                class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-col">
                    <flux:heading
                        size="xl"
                        level="h1"
                        class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                    >
                        Daftar Anime
                    </flux:heading>
                    <flux:subheading level="h2">
                        Semua anime yang tersedia
                    </flux:subheading>
                </div>
            </div>

            @if ($genres['data'])
                <x-cards.app>
                    <div class="flex flex-col gap-2">
                        <flux:heading
                            size="xl"
                            level="h3"
                            class="!font-bold"
                        >
                            Genre
                        </flux:heading>
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

                            @foreach ($genres['data']['genreList'] as $genre)
                                @php
                                    $randomColor = $colors[array_rand($colors)];
                                @endphp
                                <a
                                    href="{{ route('anime.genre.show', ['genre' => $genre['genreId']]) }}">
                                    <flux:badge
                                        size="sm"
                                        color="{{ $randomColor }}"
                                        href="{{ $genre['genreId'] }}"
                                    >
                                        {{ $genre['title'] }}
                                    </flux:badge>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </x-cards.app>
            @endif

            @if ($animes['data'])
                <x-cards.app>
                    <div
                        class="flex flex-col gap-2"
                        x-data="{ activeIndex: null }"
                    >
                        <flux:heading
                            size="xl"
                            level="h3"
                            class="!font-bold"
                        >
                            Berdasarkan Huruf
                        </flux:heading>
                        <div class="grid grid-cols-3 gap-2 lg:grid-cols-6">
                            @foreach ($animes['data']['list'] as $index => $list)
                                <flux:button
                                    x-on:click="
                                            if (activeIndex === {{ $index }}) {
                                                activeIndex = null; 
                                            } else {
                                                activeIndex = null; 
                                                setTimeout(() => activeIndex = {{ $index }}, 500);
                                            }
                                        "
                                >
                                    {{ $list['startWith'] }}
                                </flux:button>
                            @endforeach
                        </div>

                        <flux:separator />

                        @foreach ($animes['data']['list'] as $index => $list)
                            <ol
                                x-cloak
                                x-collapse
                                x-show="activeIndex === {{ $index }}"
                                class="list-inside list-decimal"
                            >
                                @foreach ($list['animeList'] as $anime)
                                    <li>
                                        <flux:link
                                            href="{{ route('anime.show', ['anime' => $anime['animeId']]) }}"
                                        >
                                            {{ $anime['title'] }}
                                        </flux:link>
                                    </li>
                                @endforeach
                            </ol>
                        @endforeach
                    </div>

                </x-cards.app>
            @endif
        </div>
    </div>
</x-layouts.app>
