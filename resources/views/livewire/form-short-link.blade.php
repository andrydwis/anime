<div class="grid gap-4 md:grid-cols-2">
    <x-cards.app>
        <div class="flex flex-col gap-4">
            <flux:input
                label="Nama"
                icon="hashtag"
                placeholder="Nama short link kamu"
                wire:model="name"
                clearable
            />
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
                        class="mx-auto mb-3 rounded-lg border border-zinc-200 p-1 dark:border-zinc-600"
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

    <x-cards.app class="md:col-span-2">
        <div class="flex flex-col gap-4">
            <div>
                <flux:heading>
                    Daftar Short Link Saya
                </flux:heading>
                <flux:subheading>
                    Semua short link yang kamu buat
                </flux:subheading>
            </div>
            @forelse ($shortLinks as $link)
                <x-cards.app>
                    <div class="flex flex-col gap-4">
                        <flux:input
                            label="{{ $link?->name }}"
                            icon="link"
                            value="{{ config('app.url') }}/{{ $link?->link }}"
                            description="{{ $link?->original_link }}"
                            readonly
                            copyable
                        />
                        @if ($link?->password)
                            <flux:input
                                type="password"
                                label="Password"
                                icon="key"
                                value="{{ $link?->password }}"
                                readonly
                                viewable
                            />
                        @endif
                        @if ($link?->expired_at)
                            <flux:input
                                label="Batas Akhir"
                                icon="calendar-date-range"
                                value="{{ $link?->expired_at }}"
                                readonly
                            />
                        @endif
                        <div class="grid grid-cols-2 gap-2">
                            <flux:button
                                variant="danger"
                                icon="trash"
                                wire:click="destroy({{ $link->id }})"
                            >
                                Hapus
                            </flux:button>
                            <flux:button
                                icon="presentation-chart-line"
                                href="{{ route('tools.short-links.show', ['link' => $link]) }}"
                            >
                                Lihat Statistik
                            </flux:button>
                        </div>
                    </div>
                </x-cards.app>
            @empty
                <x-cards.app>
                    <div>
                        <flux:heading>
                            Belum ada short link
                        </flux:heading>
                        <flux:subheading>
                            Kamu belum membuat short link
                        </flux:subheading>
                    </div>
                </x-cards.app>
            @endforelse
        </div>
    </x-cards.app>
</div>

@script
@endscript
