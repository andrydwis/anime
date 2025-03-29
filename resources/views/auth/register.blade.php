<x-layouts.auth title="Daftar">
    <flux:brand
        href="{{ route('home') }}"
        name="{{ config('app.name') }}"
        class="!mx-auto"
    >
        🇯🇵
    </flux:brand>

    <flux:button
        icon="google"
        class="w-full"
        href="{{ route('socialite.redirect', ['driver' => 'google']) }}"
    >
        Daftar dengan Google
    </flux:button>

    <flux:separator text="atau" />

    <x-forms
        action="{{ route('register') }}"
        method="POST"
    >
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
                autocomplete="new-password"
                viewable
            />
            <flux:input
                label="Konfirmasi Password"
                type="password"
                name="password_confirmation"
                placeholder="*****"
                autocomplete="new-password"
                viewable
            />
            <flux:button
                variant="primary"
                type="submit"
            >
                Daftar
            </flux:button>
        </div>
    </x-forms>

    <flux:text class="text-center">
        Sudah punya akun?
        <flux:link href="{{ route('login') }}">
            Login
        </flux:link>
    </flux:text>
</x-layouts.auth>
