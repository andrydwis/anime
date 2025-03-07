<footer class="mt-auto">
    <x-cards.app>
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
                Weaboo.my.id tidak menyimpan file apa pun di server kami. Kami hanya
                menyediakan tautan ke media yang dihosting oleh layanan pihak ketiga.
            </flux:subheading>
            <div class="flex flex-row flex-wrap items-center gap-2">
                <a href="{{ route('dmca') }}">
                    <flux:badge
                        as="button"
                        size="sm"
                    >
                        DMCA
                    </flux:badge>
                </a>
                <a href="{{ route('privacy-policy') }}">
                    <flux:badge
                        as="button"
                        size="sm"
                    >
                        Kebijakan Privasi
                    </flux:badge>
                </a>
                <a href="{{ route('terms-of-service') }}">
                    <flux:badge
                        as="button"
                        size="sm"
                    >
                        Syarat dan Ketentuan
                    </flux:badge>
                </a>
            </div>
            <flux:subheading class="lg:w-1/4">
                © {{ now()->year }} {{ config('app.name') }}
            </flux:subheading>
        </div>
    </x-cards.app>
</footer>
