<div class="grid gap-4 md:grid-cols-2">
    <x-cards.app>
        <div class="flex flex-col gap-4">
            <flux:input
                label="Link *"
                icon="link"
                placeholder="Paste link kamu disini"
                wire:model="link"
                clearable
            />
            <flux:field>
                <flux:label>Custom Link</flux:label>

                <flux:input.group>
                    <flux:input.group.prefix>
                        {{ config('app.url') }}
                    </flux:input.group.prefix>
                    <flux:input
                        placeholder="anime-favorit-saya"
                        wire:model="customLink"
                        clearable
                    />
                </flux:input.group>

                <flux:error name="customLink" />
            </flux:field>
            <flux:input
                type="password"
                label="Password"
                icon="key"
                placeholder="Masukkan password"
                wire:model="password"
                autocomplete="new-password"
                viewable
            />
            <flux:input
                type="datetime-local"
                label="Batas Akhir"
                icon="calendar-date-range"
                wire:model="expiredAt"
                clearable
            />
            <flux:button
                variant="primary"
                wire:click="generate"
            >
                Generate
            </flux:button>
        </div>
    </x-cards.app>
    <x-cards.app>
        @if ($generatedLink)
            <div class="flex flex-col gap-4">
                <div>
                    <x-alerts.app />
                </div>

                <flux:input
                    label="Short Link"
                    icon="link"
                    wire:model="generatedLink"
                    readonly
                    copyable
                />

                <flux:field>
                    <flux:label>QR Code</flux:label>

                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $generatedLink }}"
                        alt="qr-code"
                        class="mb-3 rounded-lg border border-zinc-200 p-1 dark:border-zinc-600 mx-auto"
                    >

                    <flux:button
                        icon="arrow-down-tray"
                        wire:click="downloadQrCode"
                        class="w-full"
                    >
                        Download
                    </flux:button>
                </flux:field>
            </div>
        @else
            <div>
                <flux:heading>
                    Hasil generate short link akan muncul disini 👇🏻
                </flux:heading>
                <flux:subheading>
                    Isi form terlebih dahulu, lalu klik generate.
                </flux:subheading>
            </div>
        @endif
    </x-cards.app>
</div>

@script
@endscript
