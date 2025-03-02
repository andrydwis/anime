@if ($paginator->hasPages())
    <nav class="flex flex-row items-center justify-between gap-2 flex-wrap">
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
            <flux:button.group>
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
                            disabled
                            icon="ellipsis-horizontal"
                        />
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <flux:button disabled>
                                    {{ $page }}
                                </flux:button>
                            @else
                                <flux:button href="{{ $url }}">
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
            </flux:button.group>
        </div>
    </nav>
@endif
