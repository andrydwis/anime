<x-layouts.app>
    <div class="relative flex flex-col gap-8">
        <img
            src="{{ asset('images/cta/shrine.jpg') }}"
            alt="shrine"
            class="rounded-lg"
        >

        <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">
            <flux:button
                variant="filled"
                icon="users"
                href="/wibunitas"
            >
                Wibunitas
                <flux:badge color="emerald">New</flux:badge>
            </flux:button>
        </div>

        <flux:separator />

        <div class="flex flex-col gap-2">
            <flux:heading
                size="xl"
                level="h1"
            >
                Anime Sedang Berjalan
            </flux:heading>
            <flux:subheading>
                Update terbaru anime season ini
            </flux:subheading>
        </div>
    </div>
</x-layouts.app>
