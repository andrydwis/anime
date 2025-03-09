<x-layouts.app title="Short Link">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item>
            Tools
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Short Link
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col">
                <flux:heading
                    size="xl"
                    level="h1"
                    class="from-accent !m-0 !bg-gradient-to-br to-cyan-600 bg-clip-text !font-semibold !text-transparent"
                >
                    Short Link
                </flux:heading>
                <flux:subheading level="h2">
                    Buat link yang lebih mudah untuk dishare, dan dapat ditracking
                </flux:subheading>
            </div>
        </div>
        <livewire:form-short-link />
    </div>
</x-layouts.app>
