<x-layouts.auth>
    <div class="mx-auto flex w-80 max-w-80 flex-col gap-4">
        <flux:brand
            href="{{ route('home') }}"
            name="{{ config('app.name') }}"
            class="!mx-auto mb-8"
        >
            🇯🇵
        </flux:brand>

        <div class="space-y-4">
            <flux:button
                icon="google"
                class="w-full"
            >
                Daftar dengan Google
            </flux:button>
        </div>

        <flux:separator text="atau" />

        <form
            action="{{ route('register') }}"
            method="post"
        >
            @csrf
            <div class="flex flex-col gap-4">
                <flux:input
                    label="Nama"
                    type="text"
                    name="name"
                    placeholder="Masukkan nama kamu"
                />

                <flux:input
                    label="Email"
                    type="email"
                    name="email"
                    placeholder="email@example.com"
                    clearable
                />

                <flux:input
                    label="Password"
                    type="password"
                    name="password"
                    placeholder="*****"
                    viewable
                />

                <flux:input
                    label="Konfirmasi Password"
                    type="password"
                    name="password_confirmation"
                    placeholder="*****"
                    viewable
                />

                <flux:button
                    variant="primary"
                    type="submit"
                >
                    Daftar
                </flux:button>
            </div>
        </form>

        <flux:subheading class="text-center">
            Sudah punya akun?
            <flux:link href="/register">
                Login
            </flux:link>
        </flux:subheading>
    </div>
    </x-layouts.app>
