<x-layouts.beta title="Anime X">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item>
            Anime X (BETA)
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <flux:callout
        icon="information-circle"
        color="red"
    >
        <flux:callout.heading>
            Perhatian! Halaman ini masih dalam tahap pengembangan.
        </flux:callout.heading>
        <flux:callout.text>
            Halaman ini masih dalam tahap pengembangan, jadi mungkin ada bug atau
            fitur yang belum lengkap.
        </flux:callout.text>
    </flux:callout>

    <flux:modal.trigger name="search">
        <flux:input
            as="button"
            placeholder="Cari anime..."
            icon="magnifying-glass"
        />
    </flux:modal.trigger>

    <div class="swiper w-full">
        <div class="swiper-wrapper">
            @foreach ($home['spotLightAnimes'] as $anime)
                <div class="swiper-slide">
                    <x-cards.app class="relative h-[300px] overflow-hidden md:h-[400px]">
                        <img
                            src="{{ $anime['img'] }}"
                            alt="cover"
                            class="absolute inset-0 h-full w-full rounded-lg object-cover"
                        >
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-white to-transparent dark:from-zinc-900">
                        </div>
                        <div
                            class="absolute bottom-0 left-0 z-40 flex w-full flex-col gap-2 p-4">
                            <div class="flex flex-col">
                                <flux:heading
                                    size="lg"
                                    level="h1"
                                    class="!font-bold"
                                >
                                    #Anime Spotlight {{ $anime['rank'] }}
                                </flux:heading>
                                <flux:heading
                                    size="xl"
                                    level="h1"
                                    class="line-clamp-2 !font-bold md:w-1/2"
                                >
                                    {{ $anime['name'] }}
                                </flux:heading>
                                <flux:subheading
                                    level="h2"
                                    class="line-clamp-3 md:w-1/2"
                                >
                                    {{ $anime['description'] }}
                                </flux:subheading>
                            </div>
                            <div class="flex flex-row flex-wrap items-center gap-2">
                                <flux:button
                                    variant="primary"
                                    icon="play-circle"
                                    href="{{ route('animex.show', ['animex' => $anime['id']]) }}"
                                >
                                    Nonton Sekarang
                                </flux:button>
                            </div>
                        </div>
                    </x-cards.app>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    Anime Terbaru
                </flux:heading>
                <flux:subheading level="h2">
                    Update terbaru anime season ini
                </flux:subheading>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
            @foreach ($home['latestEpisodes'] as $anime)
                <x-cards.animex :anime="$anime" />
            @endforeach
        </div>
    </div>

    @push('styles')
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
        />
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            const swiper = swiper = new Swiper(".swiper", {
                // scrollbar: {
                //     el: ".swiper-scrollbar",
                //     hide: true,
                // },
                spaceBetween: 8,
                grabCursor: true,
                loop: true,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
            });
        </script>
    @endpush
</x-layouts.beta>
