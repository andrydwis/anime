<x-layouts.auth title="Login">
    <div class="mx-auto flex w-80 max-w-80 flex-col gap-8">
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
            Login dengan Google
        </flux:button>

        <flux:separator text="atau" />

        <form
            action="{{ route('login') }}"
            method="post"
        >
            @csrf
            <div class="flex flex-col gap-4">
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
                <flux:button
                    variant="primary"
                    type="submit"
                >
                    Login
                </flux:button>
            </div>
        </form>

        <flux:subheading class="text-center">
            Belum punya akun?
            <flux:link href="{{ route('register') }}">
                Daftar disini
            </flux:link>
        </flux:subheading>
    </div>
    </x-layouts.au>
