@extends('admin.master')
@section('title', 'Detail Harga Hotel')

@push('styles')
    <style>
        /* === HARAMAIN STYLE VARIABLES === */
        :root {
            --haramain-navy: #1a4b8c;
            /* Primary Dark */
            --haramain-blue: #2a6fdb;
            /* Secondary/Action */
            --haramain-soft: #e6f0fa;
            /* Light Background */
            --text-main: #2d3748;
            --text-muted: #718096;
            --border-color: #e2e8f0;
            --card-shadow: 0 10px 30px rgba(26, 75, 140, 0.05);
            /* Premium Shadow */
        }

        .haramain-container {
            max-width: 950px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 80vh;
        }

        /* === MAIN CARD STYLING === */
        .haramain-card {
            background: #ffffff;
            border-radius: 16px;
            /* Sudut lebih bulat */
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            position: relative;
        }

        /* Hero Section (Top) */
        .card-hero {
            padding: 2rem 2.5rem;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            border-bottom: 1px dashed var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hero-title-group h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--haramain-navy);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-type {
            background: var(--haramain-soft);
            color: var(--haramain-blue);
            font-size: 0.8rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .price-display {
            text-align: right;
        }

        .price-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .price-amount {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--haramain-blue);
            line-height: 1;
        }

        .price-amount span {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        /* Content Grid */
        .card-content {
            display: grid;
            grid-template-columns: 1fr 1px 1fr 1px 1.2fr;
            /* 3 Kolom dipisah garis */
            background: #fff;
        }

        .content-col {
            padding: 2rem;
        }

        .vertical-divider {
            background: var(--border-color);
            width: 1px;
            height: auto;
            margin: 1.5rem 0;
            /* Memberi jarak atas bawah pada garis */
        }

        /* Item Styling */
        .info-item {
            margin-bottom: 1.5rem;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            font-weight: 700;
            margin-bottom: 6px;
            display: block;
        }

        .info-value {
            font-size: 0.95rem;
            color: var(--text-main);
            font-weight: 600;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.5;
        }

        /* Icon Box Styling */
        .icon-box {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        /* Variasi Warna Icon */
        .icon-blue {
            background: rgba(42, 111, 219, 0.1);
            color: var(--haramain-blue);
        }

        .icon-navy {
            background: rgba(26, 75, 140, 0.1);
            color: var(--haramain-navy);
        }

        .icon-orange {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .icon-green {
            background: rgba(72, 187, 120, 0.1);
            color: #48bb78;
        }

        .icon-red {
            background: rgba(245, 101, 101, 0.1);
            color: #f56565;
        }

        /* Buttons */
        .btn-nav {
            border-radius: none;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .btn-back {
            background: #fff;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
        }

        .btn-back:hover {
            background: #f7fafc;
            color: var(--text-main);
        }

        .btn-action {
            background: var(--haramain-navy);
            color: #fff;
            border: none;
            box-shadow: 0 4px 6px rgba(26, 75, 140, 0.2);
        }

        .btn-action:hover {
            background: var(--haramain-blue);
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .card-content {
                grid-template-columns: 1fr;
                /* Stack vertical */
            }

            .vertical-divider {
                width: 100%;
                height: 1px;
                margin: 0;
            }

            .content-col {
                padding: 1.5rem;
            }

            .card-hero {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
            }

            .price-display {
                text-align: left;
            }
        }
    </style>
@endpush

@section('content')
    <div class="haramain-container">

        {{-- Header Navigation --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-0" style="color: var(--text-main)">Detail Data</h5>
                <small style="color: var(--text-muted)">Manajemen Harga & Supplier Hotel</small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('hotel.price.index') }}" class="btn btn-nav btn-back">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('hotel.price.edit', $priceList->id) }}" class="btn btn-nav btn-action">
                    <i class="bi bi-pencil-square me-1"></i> Edit Data
                </a>
            </div>
        </div>

        {{-- MAIN CARD --}}
        <div class="haramain-card">

            {{-- 1. Hero Section --}}
            <div class="card-hero">
                <div class="hero-title-group">
                    <h2>
                        {{ $priceList->nama_hotel }}
                    </h2>
                    <span class="badge-type">
                        <i class="bi bi-door-open me-1"></i> {{ $priceList->tipe_kamar }}
                    </span>
                </div>

                <div class="price-display">
                    <div class="price-label">Harga Satuan</div>
                    <div class="price-amount">
                        <span>SAR</span> {{ number_format($priceList->harga, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- 2. Content Grid --}}
            <div class="card-content">

                {{-- COL 1: Waktu & Durasi --}}
                <div class="content-col">
                    <div class="info-item">
                        <span class="info-label">Check-In</span>
                        <div class="info-value">
                            <div class="icon-box icon-blue"><i class="bi bi-calendar-check"></i></div>
                            <div>
                                {{ $priceList->tanggal ? \Carbon\Carbon::parse($priceList->tanggal_checkIn)->format('d M Y') : '-' }}
                                <div class="small text-muted fw-normal">Tanggal Masuk</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Check-Out</span>
                        <div class="info-value">
                            <div class="icon-box icon-red"><i class="bi bi-calendar-x"></i></div>
                            <div>
                                {{ $priceList->tanggal_checkOut ? \Carbon\Carbon::parse($priceList->tanggal_checkOut)->format('d M Y') : '-' }}
                                <div class="small text-muted fw-normal">Tanggal Keluar</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Durasi Menginap</span>
                        <div class="info-value">
                            <div class="icon-box icon-navy"><i class="bi bi-moon-stars"></i></div>
                            <div>
                                @if ($priceList->tanggal && $priceList->tanggal_checkOut)
                                    {{ $durasi }} Malam
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="vertical-divider"></div>

                {{-- COL 2: Supplier Info --}}
                <div class="content-col" style="background-color: #fcfcfc;">
                    <div class="info-item">
                        <span class="info-label text-primary">Supplier Utama</span>
                        <div class="info-value">
                            <div class="icon-box icon-green"><i class="bi bi-building-check"></i></div>
                            <div>
                                @if ($priceList->supplier_utama)
                                    {{ $priceList->supplier_utama }}
                                    <div class="small text-muted fw-normal mt-1">
                                        <i class="bi bi-telephone me-1"></i> {{ $priceList->kontak_supplier_utama ?? '-' }}
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr style="border-top: 1px dashed var(--border-color); margin: 1.5rem 0;">

                    <div class="info-item">
                        <span class="info-label">Supplier Cadangan</span>
                        <div class="info-value">
                            <div class="icon-box icon-orange"><i class="bi bi-building-exclamation"></i></div>
                            <div>
                                @if ($priceList->supplier_cadangan)
                                    {{ $priceList->supplier_cadangan }}
                                    <div class="small text-muted fw-normal mt-1">
                                        <i class="bi bi-telephone me-1"></i>
                                        {{ $priceList->kontak_supplier_cadangan ?? '-' }}
                                    </div>
                                @else
                                    <span class="text-muted small fst-italic">Tidak ada data</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="vertical-divider"></div>

                {{-- COL 3: Detail Tambahan --}}
                <div class="content-col">
                    <div class="info-item">
                        <span class="info-label">Add-On / Fasilitas</span>
                        <div class="info-value">
                            <div class="icon-box icon-navy"><i class="bi bi-plus-circle"></i></div>
                            <div>
                                @if ($priceList->add_on)
                                    {{ $priceList->add_on }}
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="info-item mt-4">
                        <span class="info-label">Catatan Penting</span>
                        <div class="p-3 bg-light rounded border border-light mt-2">
                            <div class="d-flex gap-2">
                                <i class="bi bi-sticky text-warning mt-1"></i>
                                <span class="small text-secondary" style="line-height: 1.6;">
                                    @if ($priceList->catatan)
                                        {!! nl2br(e($priceList->catatan)) !!}
                                    @else
                                        <i class="text-muted">Tidak ada catatan.</i>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top text-end">
                        <small class="text-muted" style="font-size: 0.7rem;">
                            Terakhir diupdate: {{ $priceList->updated_at->format('d M Y, H:i') }}
                        </small>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
