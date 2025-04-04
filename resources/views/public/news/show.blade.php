<x-layouts.app
    title="{{ $news->title }}"
    description="{{ str($news?->content)?->stripTags() }}"
    image="{{ !empty($news?->getFirstMediaUrl('news')) ? $news?->getFirstMediaUrl('news') : asset('images/placeholder/empty.jpg') }}"
>
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('news.index') }}">
            Berita Terbaru
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ $news->title }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    {{ $news?->title }}
                </flux:heading>
                <flux:text>
                    Oleh {{ $news?->user?->name }} |
                    {{ $news?->created_at->isoFormat('DD MMM YYYY') }}
                </flux:text>
            </div>
        </div>

        <x-cards.app>
            <div class="flex flex-col gap-2">
                <img
                    src="{{ !empty($news?->getFirstMediaUrl('news')) ? $news?->getFirstMediaUrl('news') : asset('images/placeholder/empty.jpg') }}"
                    alt="cover"
                    class="aspect-video rounded-lg object-cover transition-all hover:brightness-50"
                >
                <div class="!text-zinc-800 dark:!text-white">
                    <article
                        id="editor"
                        class="rounded-lg !border-zinc-200 dark:!border-zinc-600"
                    >
                        {!! $news?->content !!}
                    </article>
                </div>
                <flux:button
                    icon="arrow-top-right-on-square"
                    onclick="share()"
                >
                    Bagikan Berita
                </flux:button>
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
                readOnly: true,
                modules: {
                    toolbar: null
                },
                theme: 'snow'
            });

            const share = async () => {
                if (!navigator.share) {
                    alert("Fitur berbagi tidak didukung di browser ini.");
                    return;
                }

                const data = {
                    title: {{ Js::from($news?->title) }},
                    text: {{ Js::from('📰 Baca berita menarik ini! ' . $news?->title . ' 🌍 Jangan sampai ketinggalan! ') }},
                    url: {{ Js::from(route('news.show', ['news' => $news])) }}
                };

                try {
                    await navigator.share(data);
                } catch (error) {
                    console.error("Gagal membagikan:", error);
                }
            };
        </script>
    @endpush
</x-layouts.app>
