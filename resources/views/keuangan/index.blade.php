@extends('admin.master')
@section('title', 'Dashboard Keuangan')

@push('styles')
    <style>
        /* == VARIABLE & BASE STYLE == */
        :root {
            --haramain-primary: #1a4b8c;
            --haramain-secondary: #2a6fdb;
            --haramain-light: #e6f0fa;
            --haramain-accent: #3d8bfd;
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --border-color: #d1e0f5;
            --hover-bg: #f0f7ff;
            --background-light: #f8fafd;
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --success-bg: rgba(25, 135, 84, 0.1);
            --warning-bg: rgba(255, 193, 7, 0.1);
            --danger-bg: rgba(220, 53, 69, 0.1);
        }

        .dashboard-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--background-light);
            min-height: 100vh;
        }

        /* == STATS CARDS == */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
            border-color: var(--haramain-secondary);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .stat-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        /* Warna Spesifik Stat */
        .stat-card.primary .stat-value {
            color: var(--haramain-primary);
        }

        .stat-card.primary .stat-icon {
            background-color: var(--haramain-light);
            color: var(--haramain-primary);
        }

        .stat-card.warning .stat-value {
            color: #ff9800;
        }

        .stat-card.warning .stat-icon {
            background-color: rgba(255, 152, 0, 0.1);
            color: #ff9800;
        }

        .stat-card.success .stat-value {
            color: var(--success-color);
        }

        .stat-card.success .stat-icon {
            background-color: var(--success-bg);
            color: var(--success-color);
        }

        .stat-card.danger .stat-value {
            color: var(--danger-color);
        }

        .stat-card.danger .stat-icon {
            background-color: var(--danger-bg);
            color: var(--danger-color);
        }


        /* == STANDARD CARD (Chart & Table) == */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            background-color: #fff;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-weight: 700;
            color: var(--haramain-primary);
            margin: 0;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* == TABLE == */
        .table-responsive {
            overflow-x: auto;
            padding: 0;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            margin-bottom: 0;
        }

        .table thead th {
            background-color: var(--haramain-light);
            color: var(--haramain-primary);
            font-weight: 600;
            padding: 1rem 1.25rem;
            border-bottom: 2px solid var(--border-color);
            text-align: left;
            white-space: nowrap;
        }

        .table tbody tr {
            background-color: white;
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
        }

        .table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr td:first-child {
            border-left: 1px solid var(--border-color);
            border-radius: 8px 0 0 8px;
        }

        .table tbody tr td:last-child {
            border-right: 1px solid var(--border-color);
            border-radius: 0 8px 8px 0;
        }

        /* == BADGE == */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.75rem;
        }

        .bg-success {
            background-color: var(--success-color) !important;
        }

        .bg-danger {
            background-color: var(--danger-color) !important;
        }

        .bg-warning {
            background-color: var(--warning-color) !important;
        }

        /* == RESPONSIVE == */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }

            /* Card Grid menjadi 1 kolom di HP */
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            /* Table Responsive Card View */
            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                padding: 0.5rem;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                border: none;
                text-align: right;
                border-bottom: 1px solid var(--border-color);
            }

            .table tbody td:last-child {
                border-bottom: none;
            }

            .table tbody td:before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--haramain-primary);
                margin-right: 1rem;
                text-align: left;
            }

            /* Reset border radius table cells for mobile card view */
            .table tbody tr td:first-child {
                border-radius: 0;
                border-left: none;
            }

            .table tbody tr td:last-child {
                border-radius: 0;
                border-right: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">

        {{-- 1. STATISTIK CARDS (Baris 1: Counter) --}}
        <div class="stats-grid">
            <div class="stat-card danger">
                <div class="stat-header">
                    <span class="stat-title">Total Belum Bayar</span>
                    <div class="stat-icon"><i class="bi bi-clock-history"></i></div>
                </div>
                <span class="stat-value">{{ $dataBelumBayar->count() }}</span>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <span class="stat-title">Total Belum Lunas</span>
                    <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                </div>
                <span class="stat-value">{{ $dataBelumLunas->count() }}</span>
            </div>

            <div class="stat-card success">
                <div class="stat-header">
                    <span class="stat-title">Total Lunas</span>
                    <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
                </div>
                <span class="stat-value">{{ $dataLunas->count() }}</span>
            </div>

            <div class="stat-card primary">
                <div class="stat-header">
                    <span class="stat-title">Total Transaksi</span>
                    <div class="stat-icon"><i class="bi bi-receipt"></i></div>
                </div>
                {{-- Hitung total order jika belum ada variabelnya --}}
                <span
                    class="stat-value">{{ $dataBelumBayar->count() + $dataBelumLunas->count() + $dataLunas->count() }}</span>
            </div>
        </div>

        {{-- 2. STATISTIK CARDS (Baris 2: Nominal/Rupiah) --}}
        <div class="stats-grid">
            <div class="stat-card danger">
                <div class="stat-header">
                    <span class="stat-title">Nominal Belum Bayar</span>
                </div>
                <span class="stat-value" style="font-size: 1.4rem;">SAR {{ number_format($totalBelumBayar) }}</span>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <span class="stat-title">Nominal Belum Lunas</span>
                </div>
                <span class="stat-value" style="font-size: 1.4rem;">SAR {{ number_format($totalBelumLunas) }}</span>
            </div>

            <div class="stat-card success">
                <div class="stat-header">
                    <span class="stat-title">Nominal Lunas</span>
                </div>
                <span class="stat-value" style="font-size: 1.4rem;">SAR {{ number_format($totalLunas) }}</span>
            </div>

            <div class="stat-card primary">
                <div class="stat-header">
                    <span class="stat-title">Total Tagihan</span>
                </div>
                <span class="stat-value" style="font-size: 1.4rem;">SAR {{ number_format($totalKeseluruhan) }}</span>
            </div>
        </div>


        {{-- 3. CHARTS SECTION --}}
        <div class="row g-4 mb-4" id="charts">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title"><i class="bi bi-bar-chart-fill"></i> Performa Bulanan</h5>
                    </div>
                    <div class="card-body">
                        <div style="height: 300px; position: relative;">
                            <canvas id="monthlyPerformanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title"><i class="bi bi-pie-chart-fill"></i> Distribusi Status</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <div style="height: 300px; width: 100%; position: relative;">
                            <canvas id="statusDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data dari Controller
                const barLabels = @json($barChartLabels);
                const barDataBelumBayar = @json($barChartDataBelumBayar ?? []);
                const barDataBelumLunas = @json($barChartDataBelumLunas ?? []);
                const barDataLunas = @json($barChartDataLunas ?? []);
                const pieData = @json($pieChartData['data']);
                const pieLabels = @json($pieChartData['labels']);

                // 1. Bar Chart
                const ctxBar = document.getElementById('monthlyPerformanceChart');
                if (ctxBar) {
                    new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: barLabels,
                            datasets: [{
                                    label: 'Belum Bayar',
                                    data: barDataBelumBayar,
                                    backgroundColor: '#dc3545'
                                },
                                {
                                    label: 'Belum Lunas',
                                    data: barDataBelumLunas,
                                    backgroundColor: '#ffc107'
                                },
                                {
                                    label: 'Lunas',
                                    data: barDataLunas,
                                    backgroundColor: '#198754'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }

                // 2. Doughnut Chart
                const ctxPie = document.getElementById('statusDistributionChart');
                if (ctxPie) {
                    new Chart(ctxPie, {
                        type: 'doughnut',
                        data: {
                            labels: pieLabels,
                            datasets: [{
                                data: pieData,
                                backgroundColor: ['#dc3545', '#ffc107', '#198754'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
