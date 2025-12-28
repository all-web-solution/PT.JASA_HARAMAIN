@extends('admin.master')

@push('styles')
    <style>
        .service-badge{font-size:.75rem;padding:.25em .6em;font-weight:600;border-radius:4px;background-color:var(--haramain-light,#e6f0fa);color:var(--haramain-primary,#1a4b8c);margin-right:4px;margin-bottom:4px;display:inline-block;border:1px solid rgb(0 0 0 / .05)}@media screen and (max-width:768px){.container-fluid{padding:15px!important}#cards-dashboard .col-xl-3,#cards-dashboard .col-md-6{width:100%!important;flex:0 0 100%}#charts .col-lg-8,#charts .col-lg-4{width:100%!important;flex:0 0 100%}.chart-container{margin-bottom:20px;min-height:auto!important}.table-responsive{border:0}.table thead{display:none}.table tbody tr{display:block;background:#fff;margin-bottom:15px;border:1px solid #eee;border-radius:12px;box-shadow:0 2px 8px rgb(0 0 0 / .05);padding:15px}.table tbody td{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border:none;border-bottom:1px dashed #eee;text-align:right;font-size:.9rem}.table tbody td:last-child{border-bottom:none;justify-content:center;padding-top:15px}.table tbody td::before{content:attr(data-label);font-weight:600;color:#6c757d;text-align:left;margin-right:20px;font-size:.85rem;text-transform:uppercase}.table tbody td[data-label="Layanan"]{flex-direction:column;align-items:flex-start;text-align:left;gap:5px}.table tbody td[data-label="Layanan"]::before{margin-bottom:5px}}
    </style>
@endpush

@section('content')
    <div class="container-fluid p-3 p-md-4">

        <div class="row g-3 mb-4" id="cards-dashboard">
            <x-card-component class="col-xl-3 col-md-6" title="Jamaah Bulan Ini" :count="\App\Models\Service::totalJamaahBulanIni()" icon="bi bi-people"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Total jamaah bulan ini" />
            <x-card-component class="col-xl-3 col-md-6" title="Total Travel" :count="\App\Models\Pelanggan::count()" icon="bi bi-building"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Jumlah travel terdaftar" />
            <x-card-component class="col-xl-3 col-md-6" title="Total Service" :count="12" icon="bi bi-card-checklist"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Total tipe layanan tersedia" />
            <x-card-component class="col-xl-3 col-md-6" title="Total Request" :count="\App\Models\Service::count()" icon="bi bi-clipboard-data"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Jumlah permintaan layanan" />
        </div>

        <div class="row g-4" id="charts">
            <div class="col-lg-8">
                <div class="chart-container h-100 p-3 bg-white rounded shadow-sm border">
                    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                        <h5 class="fw-bold mb-0" style="color: var(--haramain-primary);">
                            <i class="bi bi-bar-chart-line me-2"></i>Monthly Performance
                        </h5>

                        {{-- Form Filter Tahun --}}
                        <form action="{{ route('admin.index') }}" method="GET" id="filterForm">
                            <select class="form-select form-select-sm shadow-none border-secondary" name="year"
                                onchange="document.getElementById('filterForm').submit()" style="min-width: 100px;">
                                @if (isset($availableYears) && count($availableYears) > 0)
                                    @foreach ($availableYears as $year)
                                        <option value="{{ $year }}"
                                            {{ isset($selectedYear) && $year == $selectedYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                @endif
                            </select>
                        </form>
                    </div>
                    <div style="position: relative; height: 350px; width: 100%;">
                        <canvas id="monthly-chart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="chart-container h-100 p-3 bg-white rounded shadow-sm border">
                    <h5 class="fw-bold mb-3" style="color: var(--haramain-primary);">
                        <i class="bi bi-pie-chart me-2"></i>Service Distribution
                    </h5>
                    <div class="d-flex align-items-center justify-content-center"
                        style="position: relative; height: 350px; width: 100%;">
                        <canvas id="service-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-lg" id="recent">
                    <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0" style="color: var(--haramain-primary);">
                                <i class="bi bi-clock-history me-2"></i>Recent Activity
                            </h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.agenda.index') }}"
                                    class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm d-flex align-items-center">
                                    <i class="bi bi-calendar-week me-2"></i> Timeline Agenda
                                </a>
                                <a href="{{ route('admin.services') }}"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-3">
                        <div class="table-responsive px-4 pb-3">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light text-muted">
                                    <tr>
                                        <th class="py-3 ps-3 rounded-start">Kode</th>
                                        <th class="py-3">Customer</th>
                                        <th class="py-3">Keberangkatan</th>
                                        <th class="py-3 text-center">Jemaah</th>
                                        <th class="py-3">Layanan</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3 pe-3 rounded-end text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $recentServices = \App\Models\Service::with('pelanggan')
                                            ->latest()
                                            ->take(10)
                                            ->get();
                                    @endphp

                                    @forelse ($recentServices as $service)
                                        <tr>
                                            <td data-label="Kode" class="fw-bold text-primary ps-3">
                                                {{ $service->unique_code }}
                                            </td>
                                            <td data-label="Customer">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-initials bg-light text-primary rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 32px; height: 32px; font-size: 12px;">
                                                        {{ substr($service->pelanggan->nama_travel ?? 'U', 0, 2) }}
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="d-block fw-semibold text-dark">{{ $service->pelanggan->nama_travel ?? 'Umum' }}</span>
                                                        <small class="text-muted"
                                                            style="font-size: 0.75rem;">{{ $service->pelanggan->penanggung_jawab ?? '-' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Keberangkatan">
                                                <div>
                                                    <i class="bi bi-calendar-event me-1 text-muted"></i>
                                                    {{ \Carbon\Carbon::parse($service->tanggal_keberangkatan)->format('d M Y') }}
                                                </div>
                                                <small class="text-muted">
                                                    s/d
                                                    {{ \Carbon\Carbon::parse($service->tanggal_kepulangan)->format('d M Y') }}
                                                </small>
                                            </td>
                                            <td data-label="Jemaah" class="text-center">
                                                <span class="badge bg-light text-dark border">
                                                    <i class="bi bi-people-fill me-1"></i> {{ $service->total_jamaah }}
                                                </span>
                                            </td>
                                            <td data-label="Layanan">
                                                @php
                                                    $layanan = $service->services;
                                                    if (is_string($layanan)) {
                                                        $layanan = json_decode($layanan, true);
                                                    }
                                                @endphp

                                                @if (is_array($layanan) && count($layanan) > 0)
                                                    @foreach ($layanan as $item)
                                                        @if ($loop->index < 2)
                                                            <span class="service-badge">{{ $item }}</span>
                                                        @elseif($loop->index == 2)
                                                            <span class="service-badge">+{{ count($layanan) - 2 }}</span>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <span class="text-muted fst-italic small">Tidak ada layanan</span>
                                                @endif
                                            </td>
                                            <td data-label="Status">
                                                @php
                                                    $statusClass = match ($service->status) {
                                                        'deal' => 'success',
                                                        'done' => 'success',
                                                        'batal' => 'danger',
                                                        'nego' => 'warning',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <span
                                                    class="badge bg-soft-{{ $statusClass }} text-{{ $statusClass }} px-3 py-2 rounded-pill text-uppercase"
                                                    style="background-color: var(--bs-{{ $statusClass }}-bg-subtle); color: var(--bs-{{ $statusClass }}-text-emphasis);">
                                                    {{ $service->status }}
                                                </span>
                                            </td>
                                            <td data-label="Aksi" class="text-end pe-3">
                                                <a href="{{ route('admin.services.show', $service->id) }}"
                                                    class="btn btn-sm btn-light border text-primary" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                Belum ada aktivitas terbaru.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const dataCashIn = @json($monthlyCashIn ?? array_fill(0, 12, 0));
        const dataDebt = @json($monthlyDebt ?? array_fill(0, 12, 0));

        const serviceLabels = @json($serviceDistribution['labels'] ?? []);
        const serviceData = @json($serviceDistribution['data'] ?? []);

        // ---------------------------------------------
        // 1. MONTHLY PERFORMANCE CHART (Stacked Bar)
        // ---------------------------------------------
        var ctx1 = document.getElementById("monthly-chart").getContext("2d");
        var myChart1 = new Chart(ctx1, {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                        label: "Sudah Dibayar (Cash In)",
                        data: dataCashIn,
                        backgroundColor: "rgba(16, 185, 129, 0.8)", // Hijau
                        borderRadius: 4,
                        order: 2
                    },
                    {
                        label: "Belum Dibayar (Piutang)",
                        data: dataDebt,
                        backgroundColor: "rgba(239, 68, 68, 0.8)", // Merah
                        borderRadius: 4,
                        order: 1 // Layer di atas
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000000) return 'SAR ' + (value / 1000000000).toFixed(1) + ' M';
                                if (value >= 1000000) return 'SAR ' + (value / 1000000).toFixed(0) + ' Jt';
                                return 'SAR ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(context.parsed.y);
                                }
                                return label;
                            },
                            footer: function(tooltipItems) {
                                let total = 0;
                                tooltipItems.forEach(function(tooltipItem) {
                                    total += tooltipItem.parsed.y;
                                });
                                return 'Total Omset: ' + new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(total);
                            }
                        }
                    }
                }
            }
        });

        // ---------------------------------------------
        // 2. SERVICE DISTRIBUTION CHART (Doughnut)
        // ---------------------------------------------
        const pieColors = [
            'rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)', 'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)', 'rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)',
            'rgba(201, 203, 207, 0.7)', 'rgba(233, 30, 99, 0.7)', 'rgba(103, 58, 183, 0.7)',
            'rgba(0, 150, 136, 0.7)', 'rgba(139, 195, 74, 0.7)', 'rgba(121, 85, 72, 0.7)'
        ];

        var ctx2 = document.getElementById("service-chart").getContext("2d");
        var myChart2 = new Chart(ctx2, {
            type: "doughnut",
            data: {
                labels: serviceLabels,
                datasets: [{
                    data: serviceData,
                    backgroundColor: pieColors,
                    borderColor: "#ffffff",
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    </script>
@endpush
