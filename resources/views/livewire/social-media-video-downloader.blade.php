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
                    <flux:button
                        icon="video-camera"
                        href="{{ $data['videos']['sd']['url'] }}"
                        target="_blank"
                    >
                        Download Video SD
                    </flux:button>
                    <flux:button
                        icon="video-camera"
                        href="{{ $data['videos']['hd']['url'] }}"
                        target="_blank"
                    >
                        Download Video HD
                    </flux:button>
                </div>
            @endif
        </div>
    </x-cards.app>
</div>
