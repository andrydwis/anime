<footer>
    <x-cards.app class="mt-auto">
        <div class="flex flex-col gap-2">
            <div class="flex flex-row items-center gap-2">
                <flux:button
                    icon="github"
                    href="https://github.com/andrydwis/anime"
                />
                <flux:button
                    icon="envelope"
                    href="mailto:andry.dwi.s@gmail.com"
                />
                <flux:button
                    icon="linkedin"
                    href="https://www.linkedin.com/in/andry-dwi-suharmanto-09a964127/"
                />
                <flux:button
                    icon="coffee"
                    href="https://saweria.co/andrydwis"
                />
            </div>
            <flux:subheading class="lg:w-1/4">
                Weaboo.my.id adalah tempat terbaik untuk nonton anime gratis, bergabung
                dengan
                komunitas wibu, dan mendapatkan informasi terkini seputar dunia anime.
                Temukan
                anime favoritmu di sini!
            </flux:subheading>
            <flux:subheading class="lg:w-1/4">
                © {{ now()->year }} {{ config('app.name') }}
            </flux:subheading>
        </div>
    </x-cards.app>
</footer>
