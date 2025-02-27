<footer>
    <x-cards.app class="mt-auto">
        <div class="flex flex-col lg:w-1/4">
            <flux:heading size="xl">
                🇯🇵 {{ config('app.name') }}
            </flux:heading>
            <flux:subheading class="mb-4">
                Weaboo.my.id adalah tempat terbaik untuk nonton anime gratis, bergabung
                dengan
                komunitas wibu, dan mendapatkan informasi terkini seputar dunia anime.
                Temukan
                anime favoritmu di sini!
            </flux:subheading>
            <flux:subheading class="mb-2">
                © {{ date('Y') }} {{ config('app.name') }}
            </flux:subheading>
            <flux:subheading>
                Made with ❤️
            </flux:subheading>
        </div>
    </x-cards.app>
</footer>
