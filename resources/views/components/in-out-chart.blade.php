@props([
    'labels' => [],
    'itemIns' => [],
    'itemOuts' => [],
])

<div class="card card-outline card-primary shadow-sm">
    <div class="card-header">
        <h3 class="card-title fw-semibold">
            <i class="bi bi-bar-chart-line me-2"></i>
            Grafik Barang Masuk & Keluar
        </h3>
        <div class="card-tools">
            <span class="badge text-bg-success me-1">Masuk</span>
            <span class="badge text-bg-danger">Keluar</span>
        </div>
    </div>
    <div class="card-body">
        <div id="inventory-transaction-chart" style="min-height: 350px;"></div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartEl = document.querySelector('#inventory-transaction-chart');
        if (!chartEl || typeof ApexCharts === 'undefined') {
            return;
        }

        const options = {
            series: [
                {
                    name: 'Barang Masuk',
                    data: @json($itemIns),
                },
                {
                    name: 'Barang Keluar',
                    data: @json($itemOuts),
                },
            ],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false },
                fontFamily: 'inherit',
            },
            colors: ['#198754', '#dc3545'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '55%',
                },
            },
            dataLabels: { enabled: false },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent'],
            },
            xaxis: {
                categories: @json($labels),
            },
            yaxis: {
                title: { text: 'Jumlah (Qty)' },
                labels: {
                    formatter: (value) => Math.round(value),
                },
            },
            fill: { opacity: 1 },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
            },
            tooltip: {
                y: {
                    formatter: (value) => value + ' unit',
                },
            },
            noData: {
                text: 'Belum ada data transaksi',
            },
        };

        new ApexCharts(chartEl, options).render();
    });
</script>
@endpush
