<x-layouts.app title="Profil">
    <flux:breadcrumbs class="flex-wrap">
        <flux:breadcrumbs.item
            icon="home"
            href="{{ route('home') }}"
        />
        <flux:breadcrumbs.item>
            Profil
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col gap-2">
        <x-alerts.app />

        <x-cards.app class="mx-auto w-full md:max-w-lg">

            <form
                action="{{ route('profile.update') }}"
                method="post"
            >
                @method('patch')
                @csrf
                <div class="flex flex-col gap-4">
                    @if (session()->has('success'))
                        <div
                            x-data="{ open: true }"
                            x-show="open"
                            class="bg-accent flex flex-row gap-2 rounded-lg px-4 py-2 text-white"
                        >
                            <flux:icon.check-circle variant="solid" />
                            <span>
                                {{ session()->get('success') }}
                            </span>
                            <flux:button
                                variant="ghost"
                                size="xs"
                                icon="x-mark"
                                x-on:click="open = false"
                                class="ml-auto !text-white"
                            />
                        </div>
                    @endif

                    <flux:input
                        label="Nama"
                        type="text"
                        name="name"
                        placeholder="Masukkan nama kamu"
                        value="{{ old('name', $user?->name) }}"
                        required
                        clearable
                    />
                    <flux:input
                        label="Email"
                        type="email"
                        name="email"
                        placeholder="email@example.com"
                        value="{{ old('email', $user?->email) }}"
                        required
                        clearable
                    />
                    <flux:separator />
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
                        Simpan
                    </flux:button>
                </div>
            </form>
        </x-cards.app>
    </div>
</x-layouts.app>
