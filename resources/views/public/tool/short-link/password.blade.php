<x-layouts.auth title="Password">
    <x-forms
        action="{{ route('links.authenticate', ['link' => $link]) }}"
        method="POST"
    >
        <div class="flex flex-col gap-4">
            <flux:input
                label="Password"
                type="password"
                name="password"
                placeholder="*****"
                description="Masukkan password untuk mengakses link tersebut"
                autocomplete="new-password"
                required
                viewable
            />
            <flux:button
                variant="primary"
                type="submit"
            >
                Masuk
            </flux:button>
        </div>
    </x-forms>
</x-layouts.auth>
