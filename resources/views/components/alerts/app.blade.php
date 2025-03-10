@if (session()->has('success'))
    <div>
        <div
            x-data="{ open: true }"
            x-show="open"
            class="bg-accent flex flex-row gap-2 rounded-lg px-4 py-2 text-white"
        >
            <flux:icon.check-circle variant="solid" />
            <span>
                {{ session()->get('success') }}
            </span>
            <flux:button
                variant="ghost"
                size="xs"
                icon="x-mark"
                x-on:click="open = false"
                class="ml-auto !text-white"
            />
        </div>
    </div>
@endif
