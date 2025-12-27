@extends('admin.master')
@section('title', 'Pembayaran Order: ' . $order->invoice)

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
            --background-light: #f8fafd;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --success-bg: rgba(40, 167, 69, 0.1);
            --warning-bg: rgba(255, 193, 7, 0.1);
            --danger-bg: rgba(220, 53, 69, 0.1);
            --primary-bg: var(--haramain-light);

            /* === STATUS COLORS === */
            --status-nego: #ffc107;
            /* Kuning/Orange */
            --status-deal: #0d6efd;
            /* Biru (Default Haramain) */
            --status-persiapan: #6f42c1;
            /* Ungu */
            --status-produksi: #0dcaf0;
            /* Cyan/Biru Muda */
            --status-selesai: #198754;
            /* Hijau */
            --status-batal: #dc3545;
            /* Merah */
        }

        .service-list-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--background-light);
            min-height: 100vh;
        }

        /* === GENERAL CARD STYLING === */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / .05);
            border: 1px solid var(--border-color);
            background-color: #fff;
            overflow: hidden;
            margin-bottom: 2rem;
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
            padding: 1.5rem;
        }

        /* === INFO BOX (Customer & Trip) === */
        .info-box {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            height: 100%;
            position: relative;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .info-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .info-box-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px dashed var(--border-color);
            font-weight: 700;
            color: var(--text-secondary);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-table td {
            padding: 4px 0;
            font-size: 0.95rem;
            color: var(--text-primary);
        }

        .info-table td:first-child {
            color: var(--text-secondary);
            width: 130px;
            font-weight: 500;
        }

        /* === SERVICE CARD SPECIFIC (Agar Rincian Layanan Rapi) === */
        .service-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .service-card-header {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid var(--border-color);
        }

        /* Warna Header Card Service Berdasarkan Kategori */
        .service-card.transport .service-card-header {
            background: linear-gradient(to right, #e3f2fd, #fff);
            color: #0c5460;
        }

        .service-card.hotel .service-card-header {
            background: linear-gradient(to right, #e3f2fd, #fff);
            color: #0c5460;
        }

        .service-card.document .service-card-header {
            background: linear-gradient(to right, #e3f2fd, #fff);
            color: #0c5460;
        }

        .service-card.tour .service-card-header {
            background: linear-gradient(to right, #e3f2fd, #fff);
            color: #0c5460;
        }

        .service-card.other .service-card-header {
            background: linear-gradient(to right, #e3f2fd, #fff);
            color: #0c5460;
        }

        .service-card-body {
            padding: 1rem;
        }

        .service-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .service-list li {
            position: relative;
            padding-left: 1.2rem;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: var(--text-primary);
            line-height: 1.4;
        }

        /* === INDICATOR STATUS LOGIC === */
        /* Default Bullet */
        .service-list li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: var(--haramain-secondary);
            font-weight: bold;
            font-size: 1.2em;
            line-height: 1;
            top: 0;
        }

        /* Color Overrides based on Class */
        .service-list li.status-nego::before {
            color: var(--status-nego);
        }

        .service-list li.status-deal::before {
            color: var(--status-deal);
        }

        .service-list li.status-tahap-persiapan::before {
            color: var(--status-persiapan);
        }

        .service-list li.status-tahap-produksi::before {
            color: var(--status-produksi);
        }

        .service-list li.status-selesai::before {
            color: var(--status-selesai);
        }

        .service-list li.status-batal::before {
            color: var(--status-batal);
        }

        .service-list li.status-batal {
            color: #999;
            text-decoration: line-through;
        }

        .service-list li.status-batal::before {
            text-decoration: none;
        }

        .badge-details {
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 5px;
            vertical-align: middle;
        }

        /* === LEGEND SECTION === */
        .status-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px dashed var(--border-color);
            justify-content: center;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        /* === STATS & INFO CARDS === */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .info-card {
            background-color: #fff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
        }

        .info-card.success-card {
            background-color: var(--success-bg);
            border-color: var(--success-color);
        }

        .info-card.danger-card {
            background-color: var(--danger-bg);
            border-color: var(--danger-color);
        }

        .info-card.warning-card {
            background-color: var(--warning-bg);
            border-color: var(--warning-color);
        }

        .info-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            font-weight: 600;
            color: var(--haramain-primary);
            margin-bottom: 1.25rem;
            padding-bottom: .75rem;
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
            font-size: .9rem;
        }

        .info-item .label {
            font-size: .8rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: .25rem;
        }

        .info-item .value {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1rem;
            text-transform: capitalize;
            word-break: break-word;
        }

        .info-item .value-large {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .info-card.success-card .info-item .value-large {
            color: var(--success-color);
        }

        .info-card.danger-card .info-item .value-large {
            color: var(--danger-color);
        }

        /* === UTILITIES & BUTTONS === */
        .text-haramain {
            color: var(--haramain-primary);
        }

        .btn-action,
        .btn-secondary,
        .btn-submit {
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: .9rem;
            cursor: pointer;
            border: none;
        }

        .btn-secondary {
            background-color: #fff;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            padding: .625rem 1.25rem;
        }

        .btn-secondary:hover {
            background-color: var(--hover-bg);
            border-color: var(--haramain-secondary);
            color: var(--haramain-secondary);
        }

        .btn-submit {
            background-color: var(--haramain-secondary);
            color: #fff;
            padding: .75rem 1.5rem;
        }

        .btn-submit:hover {
            background-color: var(--haramain-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgb(26 75 140 / .3);
        }

        .btn-submit[disabled] {
            background-color: var(--text-secondary);
            cursor: not-allowed;
            opacity: .7;
            transform: none;
            box-shadow: none;
        }

        .alert-custom {
            border-radius: 8px;
            padding: 1rem;
            border: 1px solid;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* === TABLE STYLES === */
        .table-responsive {
            padding: 0;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 .75rem;
        }

        .table thead th {
            background-color: var(--haramain-light);
            color: var(--haramain-primary);
            font-weight: 600;
            padding: 1rem 1.25rem;
            border-bottom: 2px solid var(--border-color);
            text-align: center;
            white-space: nowrap;
        }

        .table tbody tr {
            background-color: #fff;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
        }

        .table tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            text-align: center;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr td:first-child {
            border-left: 1px solid var(--border-color);
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .table tbody tr td:last-child {
            border-right: 1px solid var(--border-color);
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* === FORM STYLES === */
        .payment-form-container {
            padding: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-column {
            columns: 3;
            column-gap: 2rem;
        }

        .form-label {
            display: block;
            margin-bottom: .5rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .form-control,
        .form-select {
            display: block;
            width: 100%;
            padding: .75rem 1rem;
            font-size: .9rem;
            color: var(--text-secondary);
            background-color: #fff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--haramain-accent);
            outline: 0;
            box-shadow: 0 0 0 .2rem rgb(42 111 219 / .25);
        }

        /* === MEDIA QUERIES === */
        @media (max-width: 992px) {

            .stats-grid,
            .customer-info-grid {
                grid-template-columns: 1fr 1fr;
            }

            .form-column {
                columns: 1;
            }
        }

        @media (max-width: 768px) {
            .service-list-container {
                padding: 1rem;
            }

            .stats-grid,
            .customer-info-grid {
                grid-template-columns: 1fr;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .card-title {
                font-size: 1.1rem;
            }

            #action_button {
                width: 100%;
                display: flex;
                gap: 10px;
            }

            #action_button .btn,
            #action_button a {
                flex: 1;
                justify-content: center;
            }

            /* Responsive Table (Card Style) */
            .table thead {
                display: none;
            }

            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 1.5rem;
                border: 1px solid var(--border-color);
            }

            .table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                padding: 0.8rem 1rem;
            }

            .table td:before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--haramain-primary);
                text-align: left;
            }
        }
    </style>
@endpush

@section('content')

    @php
        // -------------------------------------------------------------------
        // BAGIAN 1: LOGIC PENGECEKAN STATUS
        // -------------------------------------------------------------------
        $items = $order->service->getAllItemsFromService();
        $totalItems = $items->count();

        // Hitung item yang BELUM final
        $itemsBelumFinal = $items->where('status', 'nego')->count();
        $itemsSudahFinal = $totalItems - $itemsBelumFinal;
        $semuaFinal = $totalItems > 0 && $itemsBelumFinal === 0;

        // --- LOGIKA KEUANGAN ---
        $orderInduk = $orders->last();
        $totalTagihanInduk = $orderInduk->total_amount_final ?? ($orderInduk->total_estimasi ?? 0);
        $totalDibayarAkumulatif = $orders->sum('total_yang_dibayarkan');

        $orderAktif = $orders->first();
        $sisaHutangSaatIni = $orderAktif->sisa_hutang ?? 0;
        $statusPembayaranSaatIni = $orderAktif->status_pembayaran ?? 'estimasi';
        $hargaSudahFinal = $orderInduk->status_harga == 'final';
    @endphp

    <div class="service-list-container">

        @if (session('success'))
            <div class="alert alert-success alert-custom mb-3"
                style="border-color: var(--success-color); background-color: var(--success-bg); color: var(--success-color);">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-custom mb-3"
                style="border-color: var(--danger-color); background-color: var(--danger-bg); color: var(--danger-color);">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- CARD 1: DETAIL CUSTOMER & LAYANAN --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-person-badge"></i>
                    <span class="title-text">Detail Customer</span>
                </h5>
                <div id="action_button">
                    <a href="{{ route('invoice.show', $order->id) }}" target="_blank" class="btn-action btn-submit"
                        style="background-color: var(--haramain-primary);">
                        <i class="bi bi-receipt-cutoff"></i> Invoice
                    </a>
                    <a href="{{ route('admin.order') }}" class="btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                {{-- 1. INFORMASI UTAMA (GRID LAYOUT) --}}
                <div class="row g-4 mb-4">
                    {{-- Info Customer --}}
                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-box-header">
                                <i class="bi bi-person-badge fs-5 text-primary"></i>
                                <span>Informasi Pelanggan</span>
                            </div>
                            <table class="info-table w-100">
                                <tr>
                                    <td>Nama Travel</td>
                                    <td class="fw-bold">{{ $order->service->pelanggan->nama_travel }}</td>
                                </tr>
                                <tr>
                                    <td>Penanggung Jawab</td>
                                    <td class="fw-bold">{{ $order->service->pelanggan->penanggung_jawab }}</td>
                                </tr>
                                <tr>
                                    <td>Kontak</td>
                                    <td>{{ $order->service->pelanggan->phone }}</td>
                                </tr>
                                <tr>
                                    <td>Kode Service</td>
                                    <td class="text-haramain fw-bold">{{ $order->service->unique_code }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Info Keberangkatan --}}
                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-box-header">
                                <i class="bi bi-calendar-range fs-5 text-success"></i>
                                <span>Detail Perjalanan</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center px-2 mb-3">
                                <div class="text-center">
                                    <small class="text-secondary text-uppercase d-block mb-1"
                                        style="font-size: 0.7rem;">Berangkat</small>
                                    <div class="fw-bold fs-6">
                                        {{ \Carbon\Carbon::parse($order->service->tanggal_keberangkatan)->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="text-secondary"><i class="bi bi-arrow-right fs-4"></i></div>
                                <div class="text-center">
                                    <small class="text-secondary text-uppercase d-block mb-1"
                                        style="font-size: 0.7rem;">Pulang</small>
                                    <div class="fw-bold fs-6">
                                        {{ \Carbon\Carbon::parse($order->service->tanggal_kepulangan)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="bg-light rounded p-2 text-center border">
                                <span class="text-secondary small me-2">Total Jamaah:</span>
                                <span class="fw-bold text-dark">{{ $order->service->total_jamaah }} Orang</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- RINCIAN LAYANAN (CARD GRID) --}}
                <h6 class="fw-bold text-haramain mb-3 d-flex align-items-center">
                    <span class="bg-primary rounded-circle me-2"
                        style="width: 8px; height: 8px; display: inline-block;"></span>
                    Rincian Layanan
                </h6>

                <div class="row g-3">
                    @php $hasContent = false; @endphp

                    {{-- A. HOTEL --}}
                    @if ($order->service->hotels->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card hotel">
                                <div class="service-card-header">
                                    <i class="bi bi-building"></i> Hotel
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->hotels as $hotel)
                                            <li class="status-{{ Str::slug($hotel->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($hotel->status ?? 'Deal') }}">
                                                <span class="fw-bold">{{ $hotel->nama_hotel }}</span>
                                                <br><small class="text-muted">{{ $hotel->type }} |
                                                    {{ $hotel->jumlah_kamar }} Kamar</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- B. TRANSPORTASI --}}
                    @if ($order->service->planes->isNotEmpty() || $order->service->transportationItem->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card transport">
                                <div class="service-card-header">
                                    <i class="bi bi-airplane-engines"></i> Transportasi
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->planes as $plane)
                                            <li class="status-{{ Str::slug($plane->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($plane->status ?? 'Deal') }}">
                                                <span class="badge bg-info text-dark badge-details ms-0">Udara</span>
                                                {{ $plane->maskapai }} <small
                                                    class="text-muted">({{ $plane->rute }})</small>
                                            </li>
                                        @endforeach
                                        @foreach ($order->service->transportationItem as $item)
                                            <li class="status-{{ Str::slug($item->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($item->status ?? 'Deal') }}">
                                                <span class="badge bg-secondary badge-details ms-0">Darat</span>
                                                {{ $item->transportation->nama ?? 'Bus' }}
                                                <br><small class="text-muted ps-1">Rute:
                                                    {{ $item->route->route ?? '-' }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- C. DOKUMEN --}}
                    @if ($order->service->documents->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card document">
                                <div class="service-card-header">
                                    <i class="bi bi-file-earmark-text"></i> Dokumen
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->documents as $doc)
                                            <li class="status-{{ Str::slug($doc->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($doc->status ?? 'Deal') }}">
                                                {{ $doc->document->name ?? 'Dokumen' }}
                                                @if ($doc->documentChild)
                                                    <small class="text-muted">({{ $doc->documentChild->name }})</small>
                                                @endif
                                                <span
                                                    class="badge bg-light text-dark border badge-details">{{ $doc->jumlah }}
                                                    Pcs</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- D. TOUR --}}
                    @if ($order->service->tours->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card tour">
                                <div class="service-card-header">
                                    <i class="bi bi-map"></i> Paket Tour
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->tours as $tour)
                                            <li class="status-{{ Str::slug($tour->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($tour->status ?? 'Deal') }}">
                                                {{ $tour->tourItem->name ?? 'Tour' }}
                                                <br><small class="text-muted"><i class="bi bi-bus-front"></i>
                                                    {{ $tour->transportation->nama ?? '-' }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- E. MEALS --}}
                    @if ($order->service->meals->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card other">
                                <div class="service-card-header">
                                    <i class="bi bi-egg-fried"></i> Katering (Meals)
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->meals as $meal)
                                            <li class="status-{{ Str::slug($meal->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($meal->status ?? 'Deal') }}">
                                                {{ $meal->mealItem->name ?? 'Menu' }} <span
                                                    class="badge bg-light text-dark border badge-details">{{ $meal->jumlah }}
                                                    Pcs</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- F. HANDLING --}}
                    @if ($order->service->handlings->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card other">
                                <div class="service-card-header">
                                    <i class="bi bi-briefcase"></i> Handling
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->handlings as $handling)
                                            <li class="status-{{ Str::slug($handling->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($handling->status ?? 'Deal') }}">
                                                {{ ucfirst($handling->name) }}
                                                @if ($handling->handlingHotels)
                                                    ({{ $handling->handlingHotels->nama }})
                                                @elseif ($handling->handlingPlanes)
                                                    ({{ $handling->handlingPlanes->nama_bandara }})
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- G. GUIDE --}}
                    @if ($order->service->guides->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card other">
                                <div class="service-card-header">
                                    <i class="bi bi-people"></i> Muthowif / Guide
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->guides as $guide)
                                            <li class="status-{{ Str::slug($guide->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($guide->status ?? 'Deal') }}">
                                                {{ $guide->guideItem->nama ?? 'Guide' }} ({{ $guide->jumlah }} Orang)
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- H. BADAL UMRAH --}}
                    @if ($order->service->badals->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card other">
                                <div class="service-card-header">
                                    <i class="bi bi-heart"></i> Badal Umrah
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->badals as $badal)
                                            <li class="status-{{ Str::slug($badal->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($badal->status ?? 'Deal') }}">
                                                An. {{ $badal->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- I. WAKAF --}}
                    @if ($order->service->wakafs->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card other">
                                <div class="service-card-header">
                                    <i class="bi bi-gift"></i> Wakaf
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->wakafs as $wakaf)
                                            <li class="status-{{ Str::slug($wakaf->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($wakaf->status ?? 'Deal') }}">
                                                {{ $wakaf->wakaf->nama ?? 'Wakaf' }} ({{ $wakaf->jumlah }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- J. DORONGAN --}}
                    @if ($order->service->dorongans->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card other">
                                <div class="service-card-header">
                                    <i class="bi bi-person-wheelchair"></i> Kursi Roda
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->dorongans as $dorongan)
                                            <li class="status-{{ Str::slug($dorongan->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($dorongan->status ?? 'Deal') }}">
                                                {{ $dorongan->dorongan->name ?? 'Kursi Roda' }}
                                                ({{ $dorongan->jumlah }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- K. KONTEN --}}
                    @if ($order->service->contents->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card other">
                                <div class="service-card-header">
                                    <i class="bi bi-camera"></i> Dokumentasi
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->contents as $content)
                                            <li class="status-{{ Str::slug($content->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($content->status ?? 'Deal') }}">
                                                {{ $content->content->name ?? 'Paket' }} ({{ $content->jumlah }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- L. EXCHANGE --}}
                    @if ($order->service->exchanges->isNotEmpty())
                        @php $hasContent = true; @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card other">
                                <div class="service-card-header">
                                    <i class="bi bi-currency-exchange"></i> Penukaran Uang
                                </div>
                                <div class="service-card-body">
                                    <ul class="service-list">
                                        @foreach ($order->service->exchanges as $exchange)
                                            <li class="status-{{ Str::slug($exchange->status ?? 'deal') }}"
                                                title="Status: {{ ucfirst($exchange->status ?? 'Deal') }}">
                                                {{ strtoupper($exchange->tipe) }}:
                                                {{ number_format($exchange->jumlah_input) }} -> {{ $exchange->hasil }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- EMPTY STATE --}}
                    @if (!$hasContent)
                        <div class="col-12">
                            <div class="alert alert-secondary d-flex align-items-center" role="alert">
                                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                                <div>Tidak ada layanan spesifik yang tercatat untuk order ini.</div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- LEGEND (KETERANGAN WARNA STATUS) --}}
                @if ($hasContent)
                    <div class="status-legend">
                        <div class="legend-item">
                            <span class="legend-dot" style="background-color: var(--status-nego);"></span> Nego
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background-color: var(--status-deal);"></span> Deal
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background-color: var(--status-persiapan);"></span> Tahap
                            Persiapan
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background-color: var(--status-produksi);"></span> Tahap
                            Produksi
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background-color: var(--status-selesai);"></span> Selesai
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background-color: var(--status-batal);"></span> Batal
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- CARD 2: RINGKASAN INVOICE --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span class="title-text">Ringkasan Invoice: {{ $order->invoice }}</span>
                </h5>
            </div>
            <div class="card-body">
                @php
                    $status = strtolower($order->status_pembayaran);
                    $statusClass = '';
                    if (in_array($status, ['lunas'])) {
                        $statusClass = 'badge-success';
                    } elseif (in_array($status, ['belum_bayar'])) {
                        $statusClass = 'badge-danger';
                    } elseif (in_array($status, ['belum_lunas'])) {
                        $statusClass = 'badge-info';
                    } else {
                        // 'estimasi'
                        $statusClass = 'badge-warning';
                    }
                @endphp
                <div class="stats-grid">
                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-cash-stack"></i> Total Tagihan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Total Amount (Final)</span>
                                <span class="value value-large">SAR
                                    {{ number_format($totalTagihanInduk, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Total Estimasi (Awal)</span>
                                <span class="value">SAR
                                    {{ number_format($orderInduk->total_estimasi ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-card success-card">
                        <h6 class="info-card-title"><i class="bi bi-check-circle-fill"></i> Total Dibayar</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Sudah Dibayar</span>
                                <span class="value value-large">SAR
                                    {{ number_format($totalDibayarAkumulatif ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-card danger-card">
                        <h6 class="info-card-title"><i class="bi bi-exclamation-triangle-fill"></i> Sisa Tagihan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Sisa Hutang</span>
                                <span class="value value-large">SAR
                                    {{ number_format($sisaHutangSaatIni ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Status Pembayaran</span>
                                <span class="value badge {{ $statusClass }}">{{ $order->status_pembayaran }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 3: FINALISASI TAGIHAN --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-calculator"></i>
                    <span class="title-text">Finalisasi Tagihan</span>
                </h5>
            </div>
            <div class="card-body">

                {{-- Tampilkan Alert Sesuai Status --}}
                @if ($hargaSudahFinal)
                    <div class="alert alert-success alert-custom" role="alert">
                        <i class="bi bi-lock-fill" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong>Harga Sudah Final.</strong>
                            Total tagihan telah dikunci.
                        </div>
                    </div>
                @elseif ($semuaFinal)
                    <div class="alert alert-info alert-custom" role="alert">
                        <i class="bi bi-check2-circle" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong>Siap Dihitung:</strong>
                            Semua **{{ $totalItems }}** item layanan sudah final (status bukan 'nego'). Silakan klik
                            tombol di bawah.
                        </div>
                    </div>
                @else
                    {{-- Ini berarti !$semuaFinal && $totalItems > 0 --}}
                    <div class="alert alert-warning alert-custom" role="alert">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong>Menunggu Divisi:</strong>
                            Masih ada **{{ $itemsBelumFinal }}** dari **{{ $totalItems }}** item layanan yang statusnya
                            'nego'.
                        </div>
                    </div>
                @endif

                {{-- Form Tombol Kalkulasi --}}
                <form action="{{ route('order.calculateFinal', $order->id) }}" method="POST"
                    style="margin-top: 1.5rem;">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="btn-submit" @if (!$semuaFinal || $hargaSudahFinal) disabled @endif>
                        <i class="bi bi-calculator"></i>
                        @if ($hargaSudahFinal)
                            Total Sudah Final
                        @else
                            Hitung & Finalkan Total Tagihan
                        @endif
                    </button>

                    @if (!$semuaFinal && !$hargaSudahFinal && $totalItems > 0)
                        <small class="text-muted d-block mt-2">Tombol akan aktif setelah **{{ $itemsBelumFinal }}** item
                            lagi (yang masih 'nego') diselesaikan oleh divisi.</small>
                    @endif
                </form>
            </div>
        </div>

        {{-- CARD 4: RIWAYAT TABLE --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-hourglass-split"></i>
                    <span class="title-text">Riwayat Tagihan & Pembayaran</span>
                </h5>
            </div>
            <div class="card-body table-card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Invoice</th>
                                <th>Tanggal Bayar</th>
                                <th>Total Dibayar</th>
                                <th>Status</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $item)
                                @php
                                    $status = strtolower($item->status_pembayaran);
                                    $statusClass = '';
                                    if (in_array($status, ['lunas'])) {
                                        $statusClass = 'badge-success';
                                    } elseif (in_array($status, ['belum_bayar', 'belum_lunas'])) {
                                        $statusClass = 'badge-danger';
                                    } else {
                                        $statusClass = 'badge-warning';
                                    }
                                @endphp
                                <tr>
                                    <td data-label="No.">{{ $loop->iteration }}</td>
                                    <td data-label="Invoice">{{ $item->order->invoice }}</td>
                                    <td data-label="Tanggal Bayar">{{ $item->tanggal_bayar->format('d M y') }}</td>
                                    <td data-label="Total Dibayar">SAR
                                        {{ number_format($item->jumlah_bayar ?? 0, 0, ',', '.') }}</td>
                                    <td data-label="Status"><span>{{ $item->status }}</span></td>
                                    <td data-label="Bukti">
                                        @if ($item->bukti_pembayaran)
                                            <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank"
                                                class="btn-action btn-view" title="Lihat Bukti">
                                                <i class="bi bi-image-fill" style="color: var(--haramain-accent)"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 2rem;">
                                        Belum ada riwayat tagihan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
