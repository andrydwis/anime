<x-layouts.core title="Daftar Pengguna">
    <div class="flex flex-col gap-8">
        <x-cards.app>
            <div class="flex flex-col gap-2">
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
                            wire:on-click="open = false"
                            class="ml-auto !text-white"
                        />
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table
                        class="min-w-full divide-y divide-zinc-200 border border-zinc-200"
                    >
                        <thead>
                            <tr class="bg-zinc-100 dark:bg-zinc-600">
                                <th
                                    scope="col"
                                    class="px-4 py-2"
                                >
                                    <flux:subheading>
                                        Nama
                                    </flux:subheading>
                                </th>
                                <th
                                    scope="col"
                                    class="px-4 py-2"
                                >
                                    <flux:subheading>
                                        Email
                                    </flux:subheading>
                                </th>
                                <th
                                    scope="col"
                                    class="px-4 py-2"
                                >
                                    <flux:subheading>
                                        Role
                                    </flux:subheading>
                                </th>
                                <th
                                    scope="col"
                                    class="px-4 py-2"
                                >
                                    <flux:subheading>
                                        Terakhir Login
                                    </flux:subheading>
                                </th>
                                <th
                                    scope="col"
                                    class="px-4 py-2"
                                >
                                    <flux:subheading>
                                        Aksi
                                    </flux:subheading>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200">
                            @foreach ($users as $user)
                                <tr class="hover:bg-zinc-200 dark:hover:bg-zinc-800">
                                    <td class="whitespace-nowrap px-4 py-2">
                                        {{ $user?->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2">
                                        <flux:link href="mailto:{{ $user->email }}">
                                            {{ $user?->email }}
                                        </flux:link>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2">
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
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2">
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
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2">
                                        <div
                                            class="flex flex-row items-center justify-center gap-2">
                                            <flux:tooltip content="Hapus">
                                                @php
                                                    $isSelf =
                                                        $user?->id ===
                                                        auth()->user()?->id;
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
                                                                <flux:heading
                                                                    size="lg"
                                                                >
                                                                    Hapus Pengguna
                                                                </flux:heading>
                                                                <flux:subheading>
                                                                    Apakah kamu yakin
                                                                    ingin
                                                                    menghapus pengguna
                                                                    ini?
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
                                                                <form
                                                                    action="{{ route('core.users.destroy', ['user' => $user]) }}"
                                                                    method="post"
                                                                >
                                                                    @csrf
                                                                    @method('delete')
                                                                    <flux:button
                                                                        type="submit"
                                                                        variant="danger"
                                                                    >
                                                                        Hapus
                                                                    </flux:button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </flux:modal>
                                                </div>
                                            </flux:tooltip>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $users?->onEachSide(1)?->links('components.paginations.app') }}
                </div>
            </div>
        </x-cards.app>
    </div>
</x-layouts.core>
