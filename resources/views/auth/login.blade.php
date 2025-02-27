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
                href="{{ route('socialite.redirect', ['driver' => 'google']) }}"
            >
                Login dengan Google
            </flux:button>
        </div>

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

                <flux:field>
                    <div class="mb-3 flex flex-row justify-between">
                        <flux:label>Password</flux:label>
                        <flux:link
                            href="#"
                            variant="subtle"
                            class="text-sm"
                        >
                            Lupa Password?
                        </flux:link>
                    </div>

                    <flux:input
                        type="password"
                        placeholder="*****"
                        name="password"
                        viewable
                    />
                </flux:field>

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
