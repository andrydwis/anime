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
        <x-cards.app class="mx-auto w-full md:max-w-lg">
            <x-forms
                action="{{ route('profile.update') }}"
                method="PATCH"
            >
                <div class="flex flex-col gap-4">
                    <x-alerts.app />
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
            </x-forms>
        </x-cards.app>
    </div>
</x-layouts.app>
