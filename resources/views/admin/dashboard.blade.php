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
                text-align: center
            }

            tbody td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #444;
                flex: 1;
                text-align: center;
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

    <div class="container-fluid p-3">
        <!-- Stats Cards -->
        <div class="row g-3 mb-4" id="cards-dashboard">
            <x-card-component title="Jamaah Bulan Ini" :count="\App\Models\Service::totalJamaahBulanIni()" icon="bi bi-people"
                iconColor="var(--haramain-primary)" textColor="text-success" desc="under maintenance!" />

            <x-card-component title="Total Travel" :count="\App\Models\Pelanggan::count()" icon="bi bi-currency-dollar"
                iconColor="var(--haramain-primary)" textColor="text-success" desc="under maintenance!" />

            <x-card-component title="Total Service" :count="12" icon="bi bi-currency-dollar"
                iconColor="var(--haramain-primary)" textColor="text-success" desc="under maintenance!" />

            <x-card-component title="Total Request" :count="\App\Models\Service::count()" icon="bi bi-currency-dollar"
                iconColor="var(--haramain-primary)" textColor="text-success" desc="under maintenance!" />

            <x-card-component title="Total Payment" :count="\App\Models\Order::count()" icon="bi bi-currency-dollar"
                iconColor="var(--haramain-primary)" textColor="text-success" desc="under maintenance!" />

            <x-card-component title="Total Nego" :count="\App\Models\Service::where('status', 'nego')->count()" icon="bi bi-currency-dollar"
                iconColor="var(--haramain-primary)" textColor="text-success" desc="under maintenance!" />

            <x-card-component title="Maintenance" :count="0" icon="bi bi-currency-dollar"
                iconColor="var(--haramain-primary)" textColor="text-success" desc="under maintenance!" />

            <x-card-component title="Maintenance" :count="0" icon="bi bi-currency-dollar"
                iconColor="var(--haramain-primary)" textColor="text-success" desc="under maintenance!" />

        </div>

        <!-- Charts -->
        <div class="row g-4" id="charts">
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
                                <li><a class="dropdown-item" href="#">Last Year</a></li>
                                <li><a class="dropdown-item" href="#">Custom Range</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center"
                        style="height: 300px; background: linear-gradient(45deg, #f5f7fa, #e8eff8); border-radius: 8px;">
                        <div class="text-center text-muted">
                            <i class="bi bi-bar-chart fs-1 mb-2"></i>
                            <p>Monthly Performance Chart</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="chart-container h-100">
                    <h5 class="fw-bold mb-3" style="color: var(--haramain-primary);">
                        <i class="bi bi-pie-chart me-2"></i>Service Distribution
                    </h5>
                    <div class="d-flex align-items-center justify-content-center"
                        style="height: 300px; background: linear-gradient(45deg, #f5f7fa, #e8eff8); border-radius: 8px;">
                        <div class="text-center text-muted">
                            <i class="bi bi-pie-chart fs-1 mb-2"></i>
                            <p>Service Distribution Chart</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm" id="recent">
                    <div class="card-header bg-white border-0 pb-0 pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-2" style="color: var(--haramain-primary);">
                                <i class="bi bi-clock-history me-2"></i>Recent Activity
                            </h5>
                            {{-- <a href="#" class="btn btn-haramain btn-sm">
                                <i class="bi bi-plus-circle me-1"></i>New Order
                            </a> --}}
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Customer</th>
                                        <th>Tanggal Keberangkatan</th>
                                        <th>Tanggal Kepulangan</th>
                                        <th>Jumlah</th>
                                        <th>Layanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Models\Service::all() as $service)
                                        <tr>
                                            <td data-label="Kode unik">{{ $service->unique_code }}</td>
                                            <td data-label="Customer/Travel">{{ $service->pelanggan->nama_travel }}</td>
                                            <td data-label="Tgl keberangkatan">{{ $service->tanggal_keberangkatan }}</td>
                                            <td data-label="Tgl kepulangan">{{ $service->tanggal_kepulangan }}</td>
                                            <td data-label="Jumlah jamaah">{{ $service->total_jamaah }}</td>
                                            <td data-label="Layanan yang di pilih">
                                                {{ implode(', ', (array) $service->services) }}</td>
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
@endsection
