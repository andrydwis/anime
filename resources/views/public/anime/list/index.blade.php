<x-layouts.app title="Daftar Anime">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('anime.index') }}">
            Daftar Anime
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Daftar Anime Saya
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    @if (session()->has('success'))
        <flux:callout
            color="emerald"
            icon="check-circle"
            heading="{{ session()->get('success') }}"
        />
    @endif

    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    Daftar Anime Saya
                </flux:heading>
                <flux:subheading level="h2">
                    Semua anime yang pernah kamu tonton, favorit, dan watchlist
                    yang kamu buat
                </flux:subheading>
            </div>
        </div>

        <x-cards.app>
            <div class="flex flex-col gap-2">
                <div class="flex flex-row items-center justify-between gap-2">
                    <flux:heading
                        size="xl"
                        level="h3"
                        class="!font-bold"
                    >
                        Playlist
                    </flux:heading>
                    @if ($playlists?->isNotEmpty())
                        <flux:modal.trigger name="add-playlist">
                            <flux:button
                                variant="primary"
                                icon="plus"
                                class="!hidden md:!flex"
                            >
                                Tambah Playlist
                            </flux:button>
                            <flux:button
                                variant="primary"
                                icon="plus"
                                class="md:!hidden"
                                square
                            />
                        </flux:modal.trigger>
                    @endif
                </div>
                <div class="grid gap-2 lg:grid-cols-2">
                    @forelse ($playlists as $playlist)
                        <flux:button
                            icon="film"
                            href="{{ route('anime.list.show', $playlist) }}"
                        >
                            {{ $playlist?->name }}
                        </flux:button>
                    @empty
                        <flux:modal.trigger name="add-playlist">
                            <flux:button
                                variant="primary"
                                icon="plus"
                                class="col-span-2 md:mx-auto"
                            >
                                Tambah Playlist
                            </flux:button>
                        </flux:modal.trigger>
                    @endforelse
                </div>
            </div>
            <flux:modal
                name="add-playlist"
                class="md:min-h-auto h-full min-h-svh w-full !rounded-none md:h-3/4 md:!rounded-lg"
            >
                <x-forms
                    action="{{ route('anime.list.store') }}"
                    method="POST"
                    class="flex min-h-full flex-col gap-4"
                >
                    <div>
                        <flux:heading>
                            Tambah Playlist
                        </flux:heading>
                        <flux:subheading>
                            Buat playlist baru kumpulan anime favoritmu
                        </flux:subheading>
                    </div>

                    <flux:input
                        label="Judul"
                        placeholder="Judul playlist"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        clearable
                    />

                    <flux:field>
                        <flux:label>Deskripsi</flux:label>

                        <flux:textarea
                            id="description"
                            name="description"
                            placeholder="Masukkan deskripsi playlist"
                            class="hidden"
                        >
                            {!! old('description') !!}
                        </flux:textarea>
                        <!-- Create the editor container -->
                        <div class="bg-white !text-zinc-800">
                            <div
                                id="editor"
                                class="!h-[200px] w-full"
                            >
                                {!! old('description') !!}
                            </div>
                        </div>

                        <flux:error name="description" />
                    </flux:field>

                    <flux:button
                        variant="primary"
                        type="submit"
                        class="mt-auto"
                    >
                        Simpan
                    </flux:button>
                </x-forms>
            </flux:modal>
        </x-cards.app>

        <x-cards.app>
            <div class="flex flex-col gap-2">
                <flux:heading
                    size="xl"
                    level="h3"
                    class="!font-bold"
                >
                    Watchlist
                </flux:heading>
                <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
                    @forelse ($watchlists as $animeData)
                        @php
                            $anime = $animeData->data['anime']['data'];
                            $anime['animeId'] = $animeData->data['animeId'];
                        @endphp
                        <x-cards.anime :anime="$anime" />
                    @empty
                        <x-cards.app class="col-span-4">
                            <flux:heading>
                                Belum ada watchlist
                            </flux:heading>
                            <flux:subheading>
                                Kamu belum pernah menambahkan anime ke watchlist
                            </flux:subheading>
                        </x-cards.app>
                    @endforelse
                </div>
            </div>
        </x-cards.app>

        <x-cards.app>
            <div class="flex flex-col gap-2">
                <flux:heading
                    size="xl"
                    level="h3"
                    class="!font-bold"
                >
                    Riwayat Menonton
                </flux:heading>
                <div class="flex flex-col gap-2">
                    @forelse ($histories as $date => $animes)
                        <flux:subheading>
                            {{ $date }}
                        </flux:subheading>
                        <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
                            @foreach ($animes as $animeData)
                                @if ($animeData['type'] == 'anime')
                                    @php
                                        // Extract data from $animeData
                                        $anime = $animeData->data['anime']['data'];
                                        $episodeId = $animeData->data['episodeId'];
                                        $anime['animeId'] = $animeData->data['animeId'];
                                        $anime['episodeId'] = $episodeId;
                                        $episodeList = $anime['episodeList'];

                                        // Find the matching episode using a helper function
                                        $matchingEpisode = collect(
                                            $episodeList,
                                        )->firstWhere('episodeId', $episodeId);

                                        // Add the episode title to the anime data if a match is found
                                        $anime['episodes'] = $matchingEpisode
                                            ? $matchingEpisode['title']
                                            : null;
                                    @endphp
                                    <x-cards.anime :anime="$anime" />
                                @else
                                    @php
                                        $anime = $animeData['data']['anime']['info'];
                                        $episode = $animeData['data']['episode'];
                                        $anime['episodes']['sub'] = $episode['episodeNo'];
                                        $anime['episodeId'] = str()->remove(
                                            $anime['id'] . '?ep=',
                                            $episode['episodeId'],
                                        );
                                    @endphp
                                    <x-cards.animex :anime="$anime" />
                                @endif
                            @endforeach
                        </div>
                    @empty
                        <x-cards.app>
                            <flux:heading>
                                Belum ada riwayat anime yang pernah kamu tonton
                            </flux:heading>
                            <flux:subheading>
                                Kamu belum pernah menonton anime apapun, coba cari
                                anime yang kamu sukai
                                <flux:link href="{{ route('anime.recent.index') }}">
                                    disini
                                </flux:link>
                            </flux:subheading>
                        </x-cards.app>
                    @endforelse
                </div>
            </div>
        </x-cards.app>
    </div>

    @push('styles')
        <link
            href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css"
            rel="stylesheet"
        />
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script>
            const quill = new Quill('#editor', {
                theme: 'snow'
            });

            quill.on('text-change', (delta, oldDelta, source) => {
                document.getElementById('description').value = quill.root.innerHTML;
            });
        </script>
    @endpush
</x-layouts.app>
