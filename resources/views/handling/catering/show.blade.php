@extends('admin.master')
@section('title', 'Detail Catering')

@push('styles')
    <style>
        :root {
            --haramain-primary: #1a4b8c;
            --haramain-secondary: #2a6fdb;
            --haramain-light: #e6f0fa;
            --haramain-accent: #3d8bfd;
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --border-color: #d1e0f5;
            --hover-bg: #f0f7ff;
            --bg-body: #f8fafd;
        }

        .service-detail-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--bg-body);
            min-height: 100vh;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            overflow: hidden;
            background: #fff;
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

        .card-title i {
            font-size: 1.5rem;
            color: var(--haramain-secondary);
        }

        .card-body {
            padding: 2rem;
        }

        /* Detail Sections */
        .card-section {
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            color: var(--haramain-primary);
            font-weight: 600;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.1rem;
        }

        .section-title i {
            color: var(--haramain-secondary);
        }

        .detail-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1.1rem;
            color: var(--text-primary);
            font-weight: 500;
            line-height: 1.5;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
        }

        .status-nego {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .status-deal {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .status-batal {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c6cb;
        }

        .status-done {
            background-color: #cfe2ff;
            color: #084298;
            border: 1px solid #b6d4fe;
        }

        .status-proses {
            background-color: #e2e3e5;
            color: #41464b;
            border: 1px solid #d3d6d8;
        }

        .status-tahap-persiapan,
        .status-tahap-produksi {
            background-color: #cff4fc;
            color: #055160;
            border: 1px solid #b6effb;
        }

        /* Footer */
        .card-footer {
            background-color: #f8fafd;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 0.875rem;
            padding: 1rem;
            text-align: center;
        }

        /* Buttons */
        .btn-custom {
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-warning {
            background-color: var(--warning-color);
            color: #fff;
            border: none;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            transform: translateY(-1px);
        }

        .btn-secondary-outline {
            background-color: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary-outline:hover {
            background-color: #fff;
            color: var(--text-primary);
            border-color: var(--text-secondary);
        }

        @media (max-width: 768px) {
            .service-detail-container {
                padding: 1rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .header-actions {
                width: 100%;
                display: flex;
                gap: 0.5rem;
            }

            .btn-custom {
                flex: 1;
                justify-content: center;
            }

            .detail-value {
                font-size: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="service-detail-container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9">
                <div class="card">

                    {{-- Header --}}
                    <div class="card-header">
                        <div>
                            <h5 class="card-title">
                                <i class="bi bi-info-circle"></i> Detail Catering
                            </h5>
                            <div class="text-muted small mt-1 ms-1">
                                ID Menu: #{{ $mealItem->id }} &bull; ID Order: #{{ $meal->id }}
                            </div>
                        </div>
                        <div class="header-actions">
                            <a href="{{ route('catering.edit', $mealItem->id) }}" class="btn btn-warning btn-custom">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="{{ route('catering.index') }}" class="btn btn-secondary-outline btn-custom">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        {{-- Status Banner --}}
                        <div class="text-center mb-5">
                            <span class="status-badge status-{{ Str::slug($meal->status) }}">
                                <i class="bi bi-bookmark-check"></i>
                                Status: {{ strtoupper($meal->status) }}
                            </span>
                        </div>

                        {{-- Section 1: Informasi Menu --}}
                        <div class="card-section">
                            <h6 class="section-title"><i class="bi bi-egg-fried"></i> Informasi Menu</h6>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="detail-label">Nama Menu</div>
                                    <div class="detail-value">{{ $mealItem->name }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">Harga Satuan</div>
                                    <div class="detail-value fw-bold text-primary">
                                        Rp {{ number_format($mealItem->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Informasi Travel/Layanan --}}
                        <div class="card-section">
                            <h6 class="section-title"><i class="bi bi-building"></i> Informasi Layanan</h6>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="detail-label">Kode Unik Service</div>
                                    <div class="detail-value">
                                        <span
                                            class="badge bg-light text-dark border">{{ $meal->service->unique_code ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-label">Nama Travel</div>
                                    <div class="detail-value">
                                        {{ $meal->service->pelanggan->nama_travel ?? 'Data Travel Terhapus' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 3: Detail Order --}}
                        <div class="card-section">
                            <h6 class="section-title"><i class="bi bi-calendar-range"></i> Detail Pemesanan</h6>
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="detail-label">Jumlah Porsi</div>
                                    <div class="detail-value">{{ $meal->jumlah }} Porsi</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="detail-label">Tanggal Mulai</div>
                                    <div class="detail-value">
                                        {{ \Carbon\Carbon::parse($meal->dari_tanggal)->translatedFormat('d F Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="detail-label">Tanggal Selesai</div>
                                    <div class="detail-value">
                                        {{ \Carbon\Carbon::parse($meal->sampai_tanggal)->translatedFormat('d F Y') }}
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="p-3 bg-light rounded-3 border border-light">
                                        <div class="detail-label mb-1">Total Estimasi (Hitungan Kasar)</div>
                                        <div class="detail-value text-success fs-5 fw-bold">
                                            Rp {{ number_format($mealItem->price * $meal->jumlah, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <i class="bi bi-clock-history me-1"></i>
                        Dibuat pada: {{ $meal->created_at->format('d M Y H:i') }} &bull;
                        Terakhir diupdate: {{ $meal->updated_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
