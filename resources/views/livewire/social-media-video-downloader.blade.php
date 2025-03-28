<div>
    <x-cards.app>
        <div class="flex flex-col gap-2">
            <flux:input
                label="URL"
                placeholder="Masukkan URL video"
                wire:model.debounce.500ms="url"
            />
            <flux:button
                icon="arrow-down-tray"
                wire:click="download"
            >
                Download
            </flux:button>
            @if ($data && $socialMedia == 'facebook')
                <flux:separator />
                <div class="grid gap-2 md:grid-cols-2">
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <img
                            src="{{ $data['thumbnail'] }}"
                            alt="thumbnail"
                            class="aspect-video w-full rounded-lg object-cover brightness-50"
                        >
                        <flux:heading>
                            {{ $data['title'] }}
                        </flux:heading>
                    </div>
                    @foreach ($data['formats'] as $format)
                        <flux:button
                            icon="video-camera"
                            target="_blank"
                            href="{{ $format['url'] }}"
                        >
                            {{ $format['format_id'] }} - {{ $format['resolution'] }}
                            ({{ $format['ext'] }})
                        </flux:button>
                    @endforeach
                </div>
            @elseif ($data && $socialMedia == 'youtube')
                <flux:separator />
                <div class="grid gap-2 md:grid-cols-2">
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <img
                            src="{{ $data['thumbnail'] }}"
                            alt="thumbnail"
                            class="aspect-video w-full rounded-lg object-cover brightness-50"
                        >
                        <flux:heading>
                            {{ $data['title'] }}
                        </flux:heading>
                    </div>
                    @foreach ($data['formats'] as $format)
                        <flux:button
                            icon="video-camera"
                            target="_blank"
                            href="{{ $format['url'] }}"
                        >
                            {{ $format['resolution'] }}
                            @if (!$format['has_audio'])
                                (Video Only)
                            @endif
                            ({{ $format['ext'] }})
                        </flux:button>
                    @endforeach
                </div>
            @elseif ($data && $socialMedia == 'tiktok')
                <flux:separator />
                <div class="grid gap-2 md:grid-cols-2">
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <img
                            src="{{ $data['data']['cover'] }}"
                            alt="thumbnail"
                            class="aspect-video w-full rounded-lg object-cover brightness-50"
                        >
                        <flux:heading>
                            {{ $data['data']['title'] }} -
                            {{ $data['data']['author']['nickname'] }}
                        </flux:heading>
                    </div>
                    <flux:button
                        icon="video-camera"
                        target="_blank"
                        class="md:col-span-2"
                        href="{{ $data['data']['play'] }}"
                    >
                        Download Video
                    </flux:button>
                </div>
            @endif
        </div>
    </x-cards.app>
</div>
