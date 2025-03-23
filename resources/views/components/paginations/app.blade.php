@if ($paginator->hasPages())
    <nav
        class="flex flex-row flex-wrap items-center justify-center gap-2 md:justify-between">
        <flux:subheading>
            {!! __('Showing') !!}
            @if ($paginator->firstItem())
                {{ $paginator->firstItem() }}
                {!! __('to') !!}
                {{ $paginator->lastItem() }}
            @else
                {{ $paginator->count() }}
            @endif
            {!! __('of') !!}
            {{ $paginator->total() }}
            {!! __('results') !!}
        </flux:subheading>
        <div class="flex flex-row items-center gap-2">
            <div class="flex flex-row items-center gap-1">
                @if ($paginator->onFirstPage())
                    <flux:button
                        icon="chevron-left"
                        disabled
                    />
                @else
                    <flux:button
                        icon="chevron-left"
                        href="{{ $paginator->previousPageUrl() }}"
                    />
                @endif
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <flux:button
                            icon="ellipsis-horizontal"
                            class="!hidden sm:!flex"
                            disabled
                        />
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <flux:button
                                    variant="primary"
                                    class="!hidden sm:!flex"
                                    disabled
                                >
                                    {{ $page }}
                                </flux:button>
                            @else
                                <flux:button
                                    href="{{ $url }}"
                                    class="!hidden sm:!flex"
                                >
                                    {{ $page }}
                                </flux:button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @if ($paginator->hasMorePages())
                    <flux:button
                        icon="chevron-right"
                        href="{{ $paginator->nextPageUrl() }}"
                    />
                @else
                    <flux:button
                        icon="chevron-right"
                        disabled
                    />
                @endif
            </div>
        </div>
    </nav>
@endif
