<div>
    @auth
        <flux:modal.trigger name="ai">
            <flux:button
                variant="primary"
                icon="sparkles"
            />
        </flux:modal.trigger>

        <flux:modal
            name="ai"
            class="md:min-h-auto h-full min-h-svh w-full !rounded-none md:h-3/4 md:!rounded-lg"
        >
            <div class="flex min-h-full flex-col gap-4">
                <div>
                    <flux:heading>
                        Waifu AI
                    </flux:heading>
                    <flux:subheading>
                        Tanya apapun tentang anime atau manga
                    </flux:subheading>
                </div>

                <div
                    id="chat-container"
                    class="flex h-0 flex-grow rounded-lg flex-col gap-2 overflow-auto"
                >
                    @foreach ($messages as $message)
                        @if ($message['role'] === 'assistant')
                            <x-cards.app class="!bg-accent w-3/4 !text-white">
                                {!! str()->markdown($message['content']) !!}
                            </x-cards.app>
                        @else
                            <x-cards.app class="max-w-3/4 ml-auto text-right">
                                {{ $message['content'] }}
                            </x-cards.app>
                        @endif
                    @endforeach
                </div>

                <flux:input.group class="mt-auto">
                    <flux:input
                        placeholder="Anime rekomendasi tahun {{ now()?->year }}"
                        name="message"
                        wire:model="message"
                        clearable
                    />
                    <flux:button
                        variant="primary"
                        icon="paper-airplane"
                        wire:click="ask"
                    >
                        Kirim
                    </flux:button>
                </flux:input.group>
            </div>
        </flux:modal>
    @else
        <flux:button
            icon="sparkles"
            href="{{ route('login') }}"
        />
    @endauth
</div>
