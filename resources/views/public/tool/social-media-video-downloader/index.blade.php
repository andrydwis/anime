<x-layouts.app title="Social Media Video Downloader">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item>
            Social Media Video Downloader
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
                    Social Media Video Downloader
                </flux:heading>
                <flux:text>
                    Download video dari social media dengan mudah
                </flux:text>
            </div>
        </div>
        <livewire:social-media-video-downloader />
    </div>
</x-layouts.app>
