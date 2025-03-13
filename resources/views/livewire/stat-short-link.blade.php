<div class="grid gap-4 md:grid-cols-2">
    <x-cards.app>
        <div class="flex flex-col gap-4">
            @if (session()->has('success'))
                <flux:callout
                    color="emerald"
                    icon="check-circle"
                    heading="{{ session()->get('success') }}"
                />
            @endif

            <flux:input
                label="Nama"
                icon="hashtag"
                placeholder="Nama short link kamu"
                wire:model="name"
                :readonly="!$isEdit"
                :clearable="$isEdit"
            />
            <flux:input
                label="Link *"
                icon="link"
                placeholder="Paste link kamu disini"
                wire:model="link"
                :readonly="!$isEdit"
                :clearable="$isEdit"
            />
            <flux:field>
                <flux:label>Custom Link</flux:label>

                <flux:description>Jika dikosongi, maka akan digenerate secara otomatis
                </flux:description>

                <flux:input.group>
                    <flux:input.group.prefix>
                        {{ config('app.url') }}
                    </flux:input.group.prefix>
                    <flux:input
                        placeholder="anime-favorit-saya"
                        wire:model="customLink"
                        :readonly="!$isEdit"
                        :clearable="$isEdit"
                    />
                </flux:input.group>

                <flux:error name="customLink" />
            </flux:field>
            <flux:input
                type="password"
                label="Password"
                icon="key"
                placeholder="Masukkan password"
                wire:model="password"
                autocomplete="new-password"
                :readonly="!$isEdit"
                viewable
            />
            <flux:input
                type="datetime-local"
                label="Batas Akhir"
                icon="calendar-date-range"
                wire:model="expiredAt"
                :readonly="!$isEdit"
                :clearable="$isEdit"
            />
            <flux:button
                :variant="$isEdit ? 'primary' : null"
                :wire:click="$isEdit ? 'generate' : 'toggleIsEdit'"
            >
                {{ $isEdit ? 'Generate' : 'Edit' }}
            </flux:button>
            @if ($isEdit)
                <flux:button wire:click="toggleIsEdit">
                    Batal
                </flux:button>
            @endif
        </div>
    </x-cards.app>

    <x-cards.app>
        <div class="flex flex-col gap-4">
            <flux:field>
                <flux:label>QR Code</flux:label>

                <img
                    src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $generatedLink }}"
                    alt="qr-code"
                    class="mx-auto mb-3 rounded-lg border border-zinc-200 p-1 dark:border-zinc-600"
                >

                <flux:button
                    icon="arrow-down-tray"
                    wire:click="downloadQrCode"
                    class="w-full"
                >
                    Download
                </flux:button>
            </flux:field>
        </div>
    </x-cards.app>

    <x-cards.app class="md:col-span-2">
        <div class="flex flex-col gap-4">
            <div class="flex flex-col">
                <flux:heading>
                    Statistik Short Link
                </flux:heading>
                <flux:subheading>
                    Jumlah klik, total unique pengunjung, dan data lainnya
                </flux:subheading>
            </div>
            <div class="grid gap-2 md:grid-cols-2">
                <x-cards.app>
                    <div class="flex flex-col">
                        <flux:subheading>
                            Total Dikunjungi
                        </flux:subheading>
                        <flux:heading size="xl">
                            {{ $totalVisits }} Kunjungan
                        </flux:heading>
                    </div>
                </x-cards.app>

                <x-cards.app>
                    <div class="flex flex-col">
                        <flux:subheading>
                            Total Pengunjung Unik
                        </flux:subheading>
                        <flux:heading size="xl">
                            {{ $totalUniqueVisitors }} Pengunjung
                        </flux:heading>
                    </div>
                </x-cards.app>

                @foreach ($topCountryCities as $countryCity)
                    <x-cards.app class="flex flex-col">
                        <div class="flex flex-col">
                            <flux:subheading>
                                {{ $countryCity['country_name'] ?? 'Tidak Diketahui' }},
                                {{ $countryCity['region_name'] ?? 'Tidak Diketahui' }}
                            </flux:subheading>
                            <flux:heading size="xl">
                                {{ $countryCity['total'] }} Kunjungan
                            </flux:heading>
                        </div>
                    </x-cards.app>
                @endforeach

                <x-cards.app class="md:col-span-2">
                    <div class="flex flex-col">
                        <flux:subheading>
                            Pengunjung Short Link 30 Hari Terakhir
                        </flux:subheading>
                        <div class="mt-2">
                            <div id="chart">
                            </div>
                        </div>
                    </div>
                </x-cards.app>
            </div>
        </div>
    </x-cards.app>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chartData = {
                series: [{
                    name: "Pengunjung",
                    data: {{ Js::from($chartLast30DayVisitors['data']) }}
                }],
                categories: {{ Js::from($chartLast30DayVisitors['labels']) }}
            };

            const options = {
                theme: {
                    mode: 'dark'
                },
                chart: {
                    height: 350,
                    type: 'area',
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#009966'], // Set line color
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: 'Grafik Pengunjung Short Link 30 Hari Terakhir',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    }
                },
                xaxis: {
                    categories: chartData.categories
                },
                series: chartData.series
            };

            new ApexCharts(document.querySelector("#chart"), options).render();
        });
    </script>
@endpush
