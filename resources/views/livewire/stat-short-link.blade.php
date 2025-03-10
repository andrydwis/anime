<div class="grid gap-4 md:grid-cols-2">
    <x-cards.app>
        <div class="flex flex-col gap-4">
            <flux:input
                label="Nama"
                icon="hashtag"
                placeholder="Nama short link kamu"
                wire:model="name"
                :readonly="!$isEdit"
                :clearable="$isEdit"
            />
            <flux:input
                label="Link *"
                icon="link"
                placeholder="Paste link kamu disini"
                wire:model="link"
                :readonly="!$isEdit"
                :clearable="$isEdit"
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
                        :readonly="!$isEdit"
                        :clearable="$isEdit"
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
                :readonly="!$isEdit"
                viewable
            />
            <flux:input
                type="datetime-local"
                label="Batas Akhir"
                icon="calendar-date-range"
                wire:model="expiredAt"
                :readonly="!$isEdit"
                :clearable="$isEdit"
            />
            <flux:button
                :variant="$isEdit ? 'primary' : null"
                :wire:click="$isEdit ? 'generate' : 'toggleIsEdit'"
            >
                {{ $isEdit ? 'Generate' : 'Edit' }}
            </flux:button>
            @if ($isEdit)
                <flux:button
                    wire:click="toggleIsEdit"
                >
                    Batal
                </flux:button>
            @endif
        </div>
    </x-cards.app>
</div>
