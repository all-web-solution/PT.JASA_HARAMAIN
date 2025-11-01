@extends('admin.master')
@section('content')
<style>
/* === Responsiveness for 320px screens === */
@media screen and (max-width: 320px) {

        /* Container padding */
        .container-fluid {
            padding: 10px !important;
        }

        /* Kartu dashboard satu per baris */
        #cards-dashboard .col-xl-3,
        #cards-dashboard .col-md-6 {
            width: 100% !important;
            flex: 0 0 100%;
        }

        #card-reponsive {
            margin-bottom: 10px;
        }

        /* Ukuran teks lebih kecil */
        .card-title {
            font-size: 18px !important;
        }

        .card-subtitle {
            font-size: 13px !important;
        }

        /* Chart menyesuaikan lebar penuh */
        #charts .col-lg-8,
        #charts .col-lg-4 {
            width: 100% !important;
            flex: 0 0 100%;
        }

        .chart-container {
            margin-bottom: 15px;
        }

        /* Tombol dropdown & action */
        .btn {
            font-size: 12px !important;
            padding: 4px 8px !important;
        }

        /* === TABEL RESPONSIVE MOBILE === */
        .table-responsive {
            overflow-x: auto;
        }

        table.table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead {
            display: none;
            /* sembunyikan header tabel */
        }

        tbody tr {
            display: block;
            background: #fff;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        tbody td {
            display: flex;
            justify-content: space-between;
            padding: 5px 10px;
            border: none;
            text-align: right;
            /* Jaga agar data di kanan */
        }

        tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            color: #444;
            flex: 1;
            text-align: left;
            /* Label di kiri */
        }

        tbody td:last-child {
            border-bottom: none;
        }

        /* Teks judul tabel & tombol tambah order */
        #recent .card-header h5 {
            font-size: 16px !important;
        }

        #recent .btn-haramain {
            font-size: 12px !important;
            padding: 5px 8px !important;
        }
    }
</style>

<div class="container-fluid p-4">
    <!-- Stats Cards -->
    <div class="row g-3 mb-4" id="cards-dashboard">
        <div class="col-xl-3 col-md-6" id="card-reponsive">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle mb-1">Total Belum bayar</h6>
                            <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">
                                {{ $dataBelumBayar->count() }}
                            </h3>
                            <p class="card-text text-danger mb-0"><small>3 overdue</small></p>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-clock-history fs-4" style="color: #ff9800;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6" id="card-reponsive">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle mb-1">Total belum lunas</h6>
                            <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">
                                {{ $dataBelumLunas->count() }}
                            </h3>
                            <p class="card-text text-danger mb-0"><small>3 overdue</small></p>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-hourglass-split fs-4" style="color: #ff9800;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6" id="card-reponsive">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle mb-1">Total lunas</h6>
                            <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">
                                {{ $dataLunas->count() }}
                            </h3>
                            <p class="card-text text-success mb-0"><small>+10 this week</small></p>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-check-circle fs-4" style="color: #4caf50;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6" id="card-reponsive">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle mb-1">Total Keseluruhan</h6>
                            <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">
                                Rp. {{ number_format($totalKeseluruhan) }}
                            </h3>
                            <p class="card-text text-muted mb-0"><small>All status combined</small></p>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-currency-dollar fs-4" style="color: #0d6efd;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Catatan: Saya memindahkan 3 kartu total ke bawah agar lebih rapi -->
        <div class="col-xl-4 col-md-6" id="card-reponsive">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-1">Jumlah Belum bayar</h6>
                    <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">
                        Rp. {{ number_format($totalBelumBayar) }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6" id="card-reponsive">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-1">Jumlah belum lunas</h6>
                    <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">
                        Rp. {{ number_format($totalBelumLunas) }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6" id="card-reponsive">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-1">Jumlah lunas</h6>
                    <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">
                        Rp. {{ number_format($totalLunas) }}
                    </h3>
                </div>
            </div>
        </div>
    </div>



    <!-- Charts (INI BAGIAN YANG DIPERBAIKI) -->
    <div class="row g-4" id="charts">

        <!-- Kolom Grafik Batang (8 unit) -->
        <div class="col-lg-8">
            <div class="chart-container h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="color: var(--haramain-primary);">
                        <i class="bi bi-bar-chart-line me-2"></i>Monthly Performance
                    </h5>
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            style="background-color: var(--haramain-light); color: var(--haramain-primary); border: 1px solid rgba(0, 0, 0, 0.08);">
                            This Year
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="chart-wrapper" style="height: 300px;">
                    <canvas id="monthlyPerformanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Kolom Grafik Bulat (4 unit) -->
        <div class="col-lg-4">
            <div class="chart-container h-100">
                <h5 class="fw-bold mb-3" style="color: var(--haramain-primary);">
                    <i class="bi bi-pie-chart me-2"></i>Status Distribution
                </h5>
                <div class="chart-wrapper d-flex justify-content-center align-items-center"
                    style="height: 300px;">
                    <canvas id="statusDistributionChart" style="max-height: 300px; max-width: 300px;"></canvas>
                </div>
            </div>
        </div>

    </div>
    <!-- Akhir bagian Charts -->


    <!-- Recent Activity Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" id="recent">
                <div class="card-header bg-white border-0 pb-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-2" style="color: var(--haramain-primary);">
                            <i class="bi bi-clock-history me-2"></i>Recent Activity
                        </h5>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Tagihan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\Order::latest()->take(10)->get() as $order)
                                    <!-- Ambil 10 terbaru saja -->
                                    <tr>
                                        <td data-label="Invoice">{{ $order->invoice }}</td>
                                        <td data-label="Customer">
                                            {{ $order->service->pelanggan->nama_travel ?? 'Customer Dihapus' }}</td>
                                        <td data-label="Tagihan">Rp. {{ number_format($order->total_amount) }}</td>
                                        <td data-label="Status">
                                            @if ($order->status_pembayaran == 'lunas')
                                                <span class="badge bg-success">Lunas</span>
                                            @elseif ($order->status_pembayaran == 'belum_lunas')
                                                <span class="badge bg-danger">Belum Lunas</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Belum Bayar</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Chart.js harus di-push ke stack 'scripts' di master layout Anda -->
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pastikan script ini dieksekusi setelah DOM siap
        document.addEventListener('DOMContentLoaded', function() {

            // Ambil data labels
            const barLabels = @json($barChartLabels);

            // (PERUBAHAN) Ambil 3 set data untuk grafik batang
            // Pastikan controller Anda mengirim variabel:
            // $barChartDataBelumBayar, $barChartDataBelumLunas, $barChartDataLunas
            const barDataBelumBayar = @json($barChartDataBelumBayar ?? []);
            const barDataBelumLunas = @json($barChartDataBelumLunas ?? []);
            const barDataLunas = @json($barChartDataLunas ?? []);

            // Ambil data untuk pie chart (tidak berubah)
            const pieData = @json($pieChartData['data']);
            const pieLabels = @json($pieChartData['labels']);

            // ===================================
            // 1. GRAFIK BATANG (Monthly Performance) - (UPDATED)
            // ===================================
            const ctxBar = document.getElementById('monthlyPerformanceChart');
            if (ctxBar) {
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: barLabels, // ['Jan', 'Feb', ...]

                        // (PERUBAHAN) Tampilkan 3 datasets
                        datasets: [
                        {
                            label: 'Total Belum Bayar',
                            data: barDataBelumBayar,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)', // Merah
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        {
                            label: 'Total Belum Lunas',
                            data: barDataBelumLunas,
                            backgroundColor: 'rgba(255, 206, 86, 0.6)', // Kuning
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        {
                            label: 'Total Pemasukan Lunas',
                            data: barDataLunas,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)', // Hijau (konsisten dgn pie)
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }
                    ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // Agar chart mengisi tinggi div
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value, index, values) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                    }
                                }
                            }
                        },
                        plugins: {
                            // (PERUBAHAN) Tampilkan legenda karena ada > 1 dataset
                            legend: {
                                display: true,
                                position: 'bottom'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += 'Rp ' + new Intl.NumberFormat('id-ID')
                                                .format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // ===================================
            // 2. GRAFIK BULAT (Status Distribution) - (Tidak Berubah)
            // ===================================
            const ctxPie = document.getElementById('statusDistributionChart');
            if (ctxPie) {
                new Chart(ctxPie, {
                    type: 'doughnut',
                    data: {
                        labels: pieLabels, // ['Belum Bayar', 'Belum Lunas', 'Lunas']
                        datasets: [{
                            label: 'Distribusi Status',
                            data: pieData, // [5000, 2000, 15000]
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)', // Merah (Belum Bayar)
                                'rgba(255, 206, 86, 0.7)', // Kuning (Belum Lunas)
                                'rgba(75, 192, 192, 0.7)' // Hijau (Lunas)
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed !== null) {
                                            label += 'Rp ' + new Intl.NumberFormat('id-ID')
                                                .format(context.parsed);
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }); // Akhir document.addEventListener
    </script>
@endpush


@endsection
