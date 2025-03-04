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
            <flux:button
                variant="subtle"
                size="sm"
                icon="arrow-path"
                class="!absolute right-0 top-0 mr-12 mt-4"
                wire:click="clear"
            />
            <img
                src="{{ asset('images/cta/ai.png') }}"
                alt="ai"
                class="absolute bottom-0 left-1/2 aspect-[3/4] h-1/2 -translate-x-1/2 object-fill"
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
                    class="flex h-0 flex-grow flex-col gap-2 overflow-auto rounded-lg"
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

                <div class="z-50 flex flex-col gap-2">
                    <div class="flex-row flex overflow-x-auto items-center gap-2">
                        @foreach ($messageRecommendations as $messageRecommendation)
                            <flux:button size="sm" wire:click="message = '{{ $messageRecommendation }}'">
                                {{ $messageRecommendation }}
                            </flux:button>
                        @endforeach
                    </div>
                    <flux:input.group class="!bg-zinc-800">
                        <flux:input
                            icon="sparkles"
                            placeholder="Anime rekomendasi tahun {{ now()?->year }}"
                            name="message"
                            wire:model="message"
                            wire:keydown.enter="ask"
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
            </div>
        </flux:modal>
    @else
        <flux:button
            variant="primary"
            icon="sparkles"
            href="{{ route('login') }}"
        />
    @endauth
</div>

@push('scripts')
    <script>
        Livewire.hook('commit', ({
            component,
            commit,
            respond,
            succeed,
            fail
        }) => {
            // Equivalent of 'message.sent'

            succeed(({
                snapshot,
                effects
            }) => {
                // Equivalent of 'message.received'

                queueMicrotask(() => {
                    // Equivalent of 'message.processed'
                    const container = document.querySelector(
                        '#chat-container');
                    if (container) {
                        // Add a delay of 500ms (0.5 seconds) before scrolling
                        setTimeout(() => {
                            const lastChild = container
                                .lastElementChild;
                            if (lastChild) {
                                lastChild.scrollIntoView({
                                    behavior: 'smooth'
                                });

                            } else {
                                console.warn(
                                    'No child elements found in the container'
                                );
                            }
                        }, 500); // Adjust the delay time as needed
                    } else {
                        console.error('Chat container not found!');
                    }
                })
            })

            fail(() => {
                // Equivalent of 'message.failed'
            })
        })
    </script>
@endpush
