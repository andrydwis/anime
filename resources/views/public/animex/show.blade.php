<x-layouts.beta
    title="{{ $detail['info']['name'] }}"
    description="{{ $detail['info']['description'] }}"
    image="{{ $detail['info']['img'] }}"
>
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item href="{{ route('animex.index') }}">
            Animex (BETA)
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            {{ $detail['info']['name'] }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="overflow-hidden rounded-lg">
        <video
            id="video"
            playsinline
            controls
            crossorigin="anonymous"
            data-poster="{{ $detail['info']['img'] }}"
            class="aspect-video w-full rounded-lg"
        >
            @foreach ($stream['tracks'] as $track)
                @if ($track['kind'] == 'captions')
                    <track
                        src="{{ $track['file'] }}"
                        kind="subtitles"
                        label="{{ $track['label'] }}"
                        srclang="{{ str()->lower($track['label']) }}"
                        {{ isset($track['default']) ? 'default' : '' }}
                    >
                @endif
            @endforeach
        </video>
    </div>

    @push('styles')
        <link
            rel="stylesheet"
            href="https://cdn.plyr.io/3.7.8/plyr.css"
        />
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
        <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
        <script>
            // Select the video element
            const video = document.getElementById('video');
            const source = {{ Js::from($stream['sources'][0]['url']) }};

            if (Hls.isSupported()) {
                const hls = new Hls();
                hls.loadSource(source);
                hls.attachMedia(video);

                hls.on(Hls.Events.MANIFEST_PARSED, function() {
                    // Extract available qualities from HLS levels
                    const availableQualities = hls.levels.map((level) => level.height);

                    // Define Plyr options dynamically after manifest is parsed
                    const plyrOptions = {
                        controls: [
                            'play-large', 'play',
                            'progress', 'current-time', 'duration', 'mute',
                            'volume',
                            'captions', 'settings', 'pip',
                            'fullscreen',
                        ],
                        quality: {
                            default: availableQualities[0],
                            options: availableQualities,
                            forced: true,
                            onChange: (newQuality) => updateQuality(newQuality),
                        },
                    };

                    // Initialize Plyr after setting up the options
                    const player = new Plyr(video, plyrOptions);

                    // Function to update video quality
                    function updateQuality(newQuality) {
                        hls.levels.forEach((level, levelIndex) => {
                            if (level.height === newQuality) {
                                hls.currentLevel = levelIndex;
                            }
                        });
                    }

                    // Store references to hls and player for debugging or future use
                    window.hls = hls;
                    window.player = player;
                });
            } else {
                console.error('HLS is not supported in this browser.');
            }
        </script>
    @endpush
</x-layouts.beta>
