<x-layouts.core title="Dashboard">
    <div class="grid gap-2 lg:grid-cols-3">
        <x-cards.app>
            <flux:subheading>
                Total Pengguna {{ config('app.name') }}
            </flux:subheading>
            <flux:heading
                size="xl"
                class="flex flex-row items-center gap-2"
            >
                <flux:icon.users variant="solid" />
                {{ $totalUsers }} Pengguna
            </flux:heading>
        </x-cards.app>
        <x-cards.app>
            <flux:subheading>
                Total Pengguna Aktif Hari Ini
            </flux:subheading>
            <flux:heading
                size="xl"
                class="flex flex-row items-center gap-2"
            >
                <flux:icon.users variant="solid" />
                {{ $totalActiveUsers }} Pengguna
            </flux:heading>
        </x-cards.app>
        <x-cards.app>
            <flux:subheading>
                Total Anime Ditonton Hari Ini
            </flux:subheading>
            <flux:heading
                size="xl"
                class="flex flex-row items-center gap-2"
            >
                <flux:icon.tv variant="solid" />
                {{ $totalWatchedAnimes }} Anime
            </flux:heading>
        </x-cards.app>
    </div>
    <x-cards.app>
        <div id="chart">
        </div>
    </x-cards.app>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const chartData = {
                    series: [{
                        name: "Pengguna Baru",
                        data: {{ Js::from($newUsersChart['data']) }}
                    }],
                    categories: {{ Js::from($newUsersChart['labels']) }}
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
                        text: 'Grafik Pengguna Baru',
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
</x-layouts.core>
