@extends('admin.master')
@section('title', 'Detail Order Makanan')

@push('styles')
    <style>
        /* == CSS UTAMA (Disalin dari style referensi) == */
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
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --success-bg: rgba(40, 167, 69, 0.1);
            --warning-bg: rgba(255, 193, 7, 0.1);
            --danger-bg: rgba(220, 53, 69, 0.1);
            --primary-bg: var(--haramain-light);
        }

        .service-list-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--background-light);
            min-height: 100vh;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            background-color: #ffffff;
            overflow: hidden;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-weight: 700;
            color: var(--haramain-primary);
            margin: 0;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-title .title-text {
            font-weight: 600;
            color: var(--haramain-primary);
        }

        .card-title .subtitle-text {
            font-weight: 400;
            color: var(--text-secondary);
            font-size: 1rem;
            border-left: 2px solid var(--border-color);
            padding-left: 10px;
            margin-left: 2px;
        }

        .card-title i {
            font-size: 1.5rem;
            color: var(--haramain-secondary);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Tombol Aksi */
        .btn-action,
        .btn-secondary {
            background-color: var(--haramain-secondary);
            color: white;
            border-radius: 8px;
            padding: 0.625rem 1.25rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-action:hover {
            background-color: var(--haramain-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(26, 75, 140, 0.3);
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: var(--hover-bg);
            border-color: var(--haramain-secondary);
            color: var(--haramain-secondary);
        }

        /* == DESAIN GRID == */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .info-card {
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
        }

        .info-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            font-weight: 600;
            color: var(--haramain-primary);
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .info-card-title i {
            color: var(--haramain-secondary);
        }

        .info-card .content {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            flex-grow: 1;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            font-size: 0.9rem;
        }

        .info-item .label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-item .value {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1rem;
            text-transform: capitalize;
            word-break: break-word;
            /* Mencegah email/teks panjang overflow */
        }

        .info-item .status-value {
            margin-top: 0.25rem;
        }

        /* Grid Info Customer */
        .customer-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.25rem;
        }

        /* Badge Status */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: capitalize;
        }

        .badge-success {
            background-color: var(--success-bg);
            color: var(--success-color);
        }

        .badge-warning {
            background-color: var(--warning-bg);
            color: var(--warning-color);
        }

        .badge-danger {
            background-color: var(--danger-bg);
            color: var(--danger-color);
        }

        .badge-primary {
            background-color: var(--primary-bg);
            color: var(--haramain-secondary);
        }

        /* Media Query */
        @media (max-width: 992px) {

            .stats-grid,
            .customer-info-grid {
                grid-template-columns: 1fr 1fr;
                /* 2 kolom di tablet */
            }
        }

        @media (max-width: 768px) {
            .service-list-container {
                padding: 1rem;
            }

            .stats-grid,
            .customer-info-grid {
                grid-template-columns: 1fr;
                /* 1 kolom di HP */
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .card-title {
                font-size: 1.1rem;
            }

            .card-header div:last-child {
                display: flex;
                width: 100%;
                gap: 0.75rem;
            }

            .btn-action,
            .btn-secondary {
                flex-grow: 1;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">

        {{-- Asumsi Controller mengirim variabel $meal (Model Meal) --}}

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-person-badge"></i>
                    <span class="title-text">Detail Customer</span>
                </h5>
                <a href="{{ route('catering.customer') }}" class="btn-secondary"> {{-- Ganti dengan route index makanan Anda --}}
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                {{-- Controller Anda sudah me-load 'service.pelanggan' --}}
                @if ($meal->service?->pelanggan)
                    @php
                        $service = $meal->service;
                        $pelanggan = $service->pelanggan;
                    @endphp
                    <div class="customer-info-grid">
                        <div class="info-item">
                            <span class="label">Nama Travel</span>
                            <span class="value">{{ $pelanggan->nama_travel ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Penanggung Jawab</span>
                            <span class="value">{{ $pelanggan->penanggung_jawab ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Nomor Telepon</span>
                            <span class="value">{{ $pelanggan->phone ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Email</span>
                            <span class="value">{{ $pelanggan->email ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Tanggal Keberangkatan (Service)</span>
                            <span
                                class="value">{{ \Carbon\Carbon::parse($service->tanggal_keberangkatan)->isoFormat('D MMM YYYY') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Tanggal Kepulangan (Service)</span>
                            <span
                                class="value">{{ \Carbon\Carbon::parse($service->tanggal_kepulangan)->isoFormat('D MMM YYYY') }}</span>
                        </div>
                    </div>
                @else
                    <p style="color: var(--text-secondary); text-align: center; padding: 1rem;">
                        Data customer atau service tidak terhubung.
                    </p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-egg-fried"></i>
                    <div>
                        <span class="title-text">Detail Order Makanan: {{ $meal->mealItem?->name ?? 'N/A' }}</span>
                    </div>
                </h5>
                <a href="{{ route('catering.customer.edit', $meal->id) }}" class="btn-action"> {{-- Ganti # dengan route 'makanan.edit' --}}
                    <i class="bi bi-pencil-fill"></i>
                    Edit
                </a>
            </div>

            {{-- Logika Badge Status --}}
            @php
                $status = strtolower($meal->status);
                $statusClass = '';
                if (in_array($status, ['done', 'deal'])) {
                    $statusClass = 'badge-success';
                } elseif (in_array($status, ['pending', 'nego', 'tahap persiapan'])) {
                    $statusClass = 'badge-warning';
                } elseif (in_array($status, ['cancelled', 'batal'])) {
                    $statusClass = 'badge-danger';
                } else {
                    $statusClass = 'badge-primary';
                }
            @endphp

            <div class="card-body">

                <div class="stats-grid">

                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-info-circle-fill"></i> Info Makanan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Nama Makanan</span>
                                <span class="value">{{ $meal->mealItem?->name ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Jumlah</span>
                                <span class="value">{{ $meal->jumlah }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Status</span>
                                <span class="value status-value">
                                    <span class="badge {{ $statusClass }}">{{ $meal->status }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-calendar-check"></i> Info Jadwal</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Dari Tanggal</span>
                                <span class="value"
                                    style="text-transform: none;">{{ \Carbon\Carbon::parse($meal->dari_tanggal)->isoFormat('dddd, D MMMM Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Sampai Tanggal</span>
                                <span class="value"
                                    style="text-transform: none;">{{ \Carbon\Carbon::parse($meal->sampai_tanggal)->isoFormat('dddd, D MMMM Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-cash-coin"></i> Info Finansial & Supplier</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Supplier</span>
                                <span class="value">{{ $meal->supplier ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Harga Dasar</span>
                                <span class="value">SAR {{ number_format($meal->harga_dasar ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Harga Jual</span>
                                <span class="value">SAR {{ number_format($meal->harga_jual ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Profit</span>
                                <span class="value" style="color: var(--success-color);">
                                    SAR
                                    {{ number_format(($meal->harga_jual ?? 0) - ($meal->harga_dasar ?? 0), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
