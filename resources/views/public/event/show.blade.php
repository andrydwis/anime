<x-layouts.app
    title="{{ $event?->name }}"
    description="{{ str($event?->content)?->stripTags() }}"
    image="{{ !empty($event?->getFirstMediaUrl('event')) ? $event?->getFirstMediaUrl('event') : asset('images/placeholder/empty.jpg') }}"
>
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('events.index') }}">
            Event
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ $event?->name }}
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
                    {{ $event?->name }}
                </flux:heading>
                <flux:subheading level="h2">
                    Detail event {{ $event?->name }}
                </flux:subheading>
            </div>
        </div>

        <x-cards.app>
            <div class="flex flex-col gap-2">
                <img
                    src="{{ !empty($event?->getFirstMediaUrl('event')) ? $event?->getFirstMediaUrl('event') : asset('images/placeholder/empty.jpg') }}"
                    alt="cover"
                    class="aspect-video rounded-lg object-cover transition-all hover:brightness-50"
                >
                <x-cards.app>
                    <ol class="flex list-inside flex-col gap-2">
                        <li class="flex flex-row items-center gap-2">
                            <flux:subheading>
                                Tanggal:
                            </flux:subheading>
                            @if ($event?->start_date && $event?->end_date)
                                <flux:badge size="sm">
                                    {{ $event?->start_date?->isoFormat('DD MMM YYYY') }}
                                    -
                                    {{ $event?->end_date?->isoFormat('DD MMM YYYY') }}
                                </flux:badge>
                            @elseif($event?->start_date)
                                <flux:badge size="sm">
                                    {{ $event?->start_date?->isoFormat('DD MMM YYYY') }}
                                </flux:badge>
                            @else
                                <flux:badge size="sm">
                                    TBA
                                </flux:badge>
                            @endif
                        </li>
                        <li class="flex flex-row items-center gap-2">
                            <flux:subheading>
                                Daerah:
                            </flux:subheading>
                            <flux:badge size="sm">
                                {{ $event?->province?->name }},
                                {{ $event?->city?->name }}
                            </flux:badge>
                        </li>
                    </ol>
                </x-cards.app>
                <div class="!text-zinc-800 dark:!text-white">
                    <div
                        id="editor"
                        class="rounded-lg !border-zinc-200 dark:!border-zinc-600"
                    >
                        {!! $event?->content !!}
                    </div>
                </div>
                <flux:button
                    icon="arrow-top-right-on-square"
                    onclick="share()"
                >
                    Bagikan Event
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
                    title: @json($event?->name),
                    text: @json($event?->content),
                    url: @json(route('events.show', ['event' => $event]))
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
