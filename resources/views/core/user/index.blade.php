<x-layouts.core title="Daftar Pengguna">
    @if (session()->has('success'))
        <flux:callout
            color="emerald"
            icon="check-circle"
            heading="{{ session()->get('success') }}"
        />
    @endif

    <div class="flex flex-row flex-wrap items-center justify-between gap-2">
        <div>
            <flux:heading
                size="xl"
                class="!font-semibold"
            >
                Daftar Pengguna
            </flux:heading>
            <flux:subheading>
                Semua pengguna {{ config('app.name') }}
            </flux:subheading>
        </div>
    </div>

    <x-cards.app>
        <div class="flex flex-col gap-2">
            <x-tables.app>
                <x-tables.columns>
                    <x-tables.column>
                        Nama
                    </x-tables.column>
                    <x-tables.column>
                        Email
                    </x-tables.column>
                    <x-tables.column>
                        Role
                    </x-tables.column>
                    <x-tables.column>
                        Terakhir Login
                    </x-tables.column>
                    <x-tables.column>
                        Aksi
                    </x-tables.column>
                </x-tables.columns>
                <x-tables.rows>
                    @forelse ($users as $user)
                        <x-tables.row>
                            <x-tables.cell>
                                {{ $user?->name }}
                            </x-tables.cell>
                            <x-tables.cell>
                                <flux:link href="mailto:{{ $user->email }}">
                                    {{ $user?->email }}
                                </flux:link>
                            </x-tables.cell>
                            <x-tables.cell class="text-center">
                                <div
                                    class="flex flex-row items-center justify-center gap-2">
                                    @if ($user?->roles?->count() > 0)
                                        <flux:badge
                                            size="sm"
                                            color="emerald"
                                        >
                                            {{ $user?->roles?->first()?->name ?? '-' }}
                                        </flux:badge>
                                    @endif
                                </div>
                            </x-tables.cell>
                            <x-tables.cell class="text-center">
                                <div
                                    class="flex flex-row items-center justify-center gap-2">
                                    @if ($user?->last_login_at)
                                        <flux:badge
                                            size="sm"
                                            icon="clock"
                                        >
                                            {{ $user?->last_login_at?->diffForHumans() ?? '-' }}
                                        </flux:badge>
                                    @endif
                                </div>
                            </x-tables.cell>
                            <x-tables.cell>
                                <div
                                    class="flex flex-row items-center justify-center gap-2">
                                    <flux:tooltip content="Hapus">
                                        @php
                                            $isSelf = $user?->id === auth()->user()?->id;
                                        @endphp
                                        <div>
                                            <flux:modal.trigger
                                                name="delete-user-{{ $user?->id }}"
                                            >
                                                <flux:button
                                                    variant="danger"
                                                    icon="trash"
                                                    size="xs"
                                                    :disabled="$isSelf"
                                                />
                                            </flux:modal.trigger>
                                            <flux:modal
                                                variant="flyout"
                                                position="bottom"
                                                name="delete-user-{{ $user?->id }}"
                                            >
                                                <div class="flex flex-col gap-2">
                                                    <div>
                                                        <flux:heading size="lg">
                                                            Hapus Pengguna
                                                        </flux:heading>
                                                        <flux:subheading>
                                                            Apakah kamu yakin ingin
                                                            menghapus pengguna ini?
                                                        </flux:subheading>
                                                    </div>
                                                    <div
                                                        class="flex flex-row items-center gap-2">
                                                        <flux:spacer />
                                                        <flux:modal.close>
                                                            <flux:button>
                                                                Batal
                                                            </flux:button>
                                                        </flux:modal.close>
                                                        <x-forms
                                                            action="{{ route('core.users.destroy', ['user' => $user]) }}"
                                                            method="DELETE"
                                                        >
                                                            <flux:button
                                                                type="submit"
                                                                variant="danger"
                                                            >
                                                                Hapus
                                                            </flux:button>
                                                        </x-forms>
                                                    </div>
                                                </div>
                                            </flux:modal>
                                        </div>
                                    </flux:tooltip>
                                </div>
                            </x-tables.cell>
                        </x-tables.row>
                    @empty
                        <x-tables.row>
                            <x-tables.cell
                                colspan="5"
                                class="text-center"
                            >
                                Tidak ada data
                            </x-tables.cell>
                        </x-tables.row>
                    @endforelse
                </x-tables.rows>
            </x-tables.app>
            {{ $users?->onEachSide(1)?->links('components.paginations.app') }}
        </div>
    </x-cards.app>
</x-layouts.core>
