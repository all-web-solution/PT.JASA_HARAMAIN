@extends('admin.master')
@section('title', 'Detail Service')
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
            --checked-color: #2a6fdb;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        .service-create-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f8fafd;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            overflow: hidden;
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

        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .form-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .form-section-title {
            font-size: 1.1rem;
            color: var(--haramain-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-section-title i {
            color: var(--haramain-secondary);
        }

        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-col {
            flex: 1;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--haramain-secondary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--haramain-primary);
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: #f8f9fa;
        }

        /* --- Style Baru Khusus Halaman Detail --- */

        /* Container untuk setiap item (Hotel, Transport, dll) */
        .service-detail-block {
            background-color: #ffffff;
            /* Berbeda dari .detail-form di 'create' */
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .service-detail-title {
            font-weight: 700;
            color: var(--haramain-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.1rem;
        }

        .service-detail-title i {
            color: var(--haramain-secondary);
        }

        /* Untuk baris info (Label: Value) */
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.85rem 0;
            border-bottom: 1px dashed var(--border-color);
            font-size: 0.95rem;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: var(--text-secondary);
        }

        .detail-value {
            font-weight: 500;
            color: var(--text-primary);
            text-align: right;
        }

        /* Badge untuk Status */
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 700;
            color: white;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .status-deal {
            background-color: var(--success-color);
        }

        .status-nego {
            background-color: var(--warning-color);
            color: var(--text-primary);
        }

        .status-pending {
            background-color: var(--text-secondary);
        }

        .status-cancel {
            background-color: var(--danger-color);
        }

        /* Untuk item list seperti Dokumen, Wakaf, dll */
        .summary-list .list-group-item {
            background-color: var(--haramain-light);
            border: none;
            margin-bottom: 5px;
            border-radius: 5px;
            font-weight: 500;
        }

        .summary-list .badge {
            font-size: 0.9rem;
            background-color: var(--haramain-secondary) !important;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
                margin-bottom: 0;
            }

            #title {
                display: none;
            }

            #action_button {
                display: flex;
                justify-content: space-between;
            }

            #action_button a:first-child {
                margin-right: 80px;
            }

            #travel {
                display: block;
            }
        }

        .summary-list .list-group-item.bg-light {
            background-color: #f8f9fa !important;
            border-left: 4px solid #0d6efd;
        }
    </style>
@endpush

@section('content')
    <div class="service-create-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title" id="title">
                    <i class="bi bi-file-earmark-text"></i> Detail Permintaan Service
                </h5>
                <div id="action_button">
                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="{{ route('admin.services') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">

                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-building"></i> Data Travel & Permintaan
                    </h6>
                    <div class="form-row">
                        <div class="form-col">
                            <div class="detail-item" id="travel">
                                <span class="detail-label">Nama Travel</span>
                                <br>
                                <span class="detail-value">{{ $service->pelanggan->nama_travel ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item" id="travel">
                                <span class="detail-label">Penanggung Jawab</span>
                                <br>
                                <span class="detail-value">{{ $service->pelanggan->penanggung_jawab ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item" id="travel">
                                <span class="detail-label">Email</span>
                                <br>
                                <span class="detail-value">{{ $service->pelanggan->email ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item" id="travel">
                                <span class="detail-label">Telepon</span>
                                <br>
                                <span class="detail-value">{{ $service->pelanggan->phone ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="detail-item" id="travel">
                                <span class="detail-label">Tanggal Keberangkatan</span>
                                <br>
                                <span
                                    class="detail-value">{{ \Carbon\Carbon::parse($service->tanggal_keberangkatan)->format('d M Y') }}</span>
                            </div>
                            <div class="detail-item" id="travel">
                                <span class="detail-label">Tanggal Kepulangan</span>
                                <br>
                                <span
                                    class="detail-value">{{ \Carbon\Carbon::parse($service->tanggal_kepulangan)->format('d M Y') }}</span>
                            </div>
                            <div class="detail-item" id="travel">
                                <span class="detail-label">Jumlah Jamaah</span>
                                <br>
                                <span class="detail-value">{{ $service->total_jamaah }} Orang</span>
                            </div>
                            <div class="detail-item" id="travel">
                                <span class="detail-label">Status</span>
                                <br>
                                <span class="detail-value">
                                    <span class="status-badge status-{{ strtolower($service->status) }}">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-card-checklist"></i> Rincian Layanan yang Dipesan
                    </h6>
                    @if ($service->planes?->isNotEmpty() || $service->transportationItem?->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-airplane"></i> Transportasi</h6>

                            @foreach ($service->planes ?? [] as $tiket)
                                <div class="p-3 mb-2" style="background: var(--haramain-light); border-radius: 8px;">
                                    <strong>Tiket Pesawat: {{ $tiket->maskapai ?? 'N/A' }}
                                        ({{ $tiket->rute ?? 'N/A' }})
                                    </strong>
                                    <div class="detail-item"><span class="detail-label">Tanggal</span><span
                                            class="detail-value">{{ $tiket->tanggal_keberangkatan ? \Carbon\Carbon::parse($tiket->tanggal_keberangkatan)->format('d M Y') : 'N/A' }}</span>
                                    </div>
                                    <div class="detail-item"><span class="detail-label">Jumlah</span><span
                                            class="detail-value">{{ $tiket->jumlah_jamaah ?? 0 }} Pax</span></div>
                                    @if ($tiket->keterangan)
                                        <div class="detail-item"><span class="detail-label">Ket</span><span
                                                class="detail-value">{{ $tiket->keterangan }}</span></div>
                                    @endif
                                </div>
                            @endforeach

                            @foreach ($service->transportationItem ?? [] as $bus)
                                <div class="p-3 mb-2" style="background: var(--haramain-light); border-radius: 8px;">
                                    <strong>Transport Darat: {{ $bus->transportation?->nama ?? 'N/A' }}</strong>
                                    <div class="detail-item"><span class="detail-label">Rute</span><span
                                            class="detail-value">{{ $bus->route?->route ?? 'N/A' }}</span></div>
                                    <div class="detail-item"><span class="detail-label">Periode</span><span
                                            class="detail-value">{{ $bus->dari_tanggal ? \Carbon\Carbon::parse($bus->dari_tanggal)->format('d M') : 'N/A' }}
                                            -
                                            {{ $bus->sampai_tanggal ? \Carbon\Carbon::parse($bus->sampai_tanggal)->format('d M Y') : 'N/A' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- HOTEL (Perbaikan Tipe Kamar) --}}
                    @if ($service->hotels?->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-building"></i> Hotel</h6>
                            @foreach ($service->hotels as $hotel)
                                <div class="p-3 mb-2" style="background: var(--haramain-light); border-radius: 8px;">
                                    <strong>{{ $hotel->nama_hotel ?? 'N/A' }}</strong>
                                    <div class="detail-item"><span class="detail-label">Check-in</span><span
                                            class="detail-value">{{ $hotel->tanggal_checkin ? \Carbon\Carbon::parse($hotel->tanggal_checkin)->format('d M Y') : 'N/A' }}</span>
                                    </div>
                                    <div class="detail-item"><span class="detail-label">Check-out</span><span
                                            class="detail-value">{{ $hotel->tanggal_checkout ? \Carbon\Carbon::parse($hotel->tanggal_checkout)->format('d M Y') : 'N/A' }}</span>
                                    </div>
                                    {{-- Tampilkan tipe jika ada --}}
                                    @if ($hotel->type)
                                        <div class="detail-item"><span class="detail-label">Tipe Kamar</span><span
                                                class="detail-value">{{ $hotel->type }} ({{ $hotel->jumlah_type ?? 0 }}
                                                Kamar)</span>
                                        </div>
                                    @endif
                                    <div class="detail-item"><span class="detail-label">Total Kamar</span><span
                                            class="detail-value">{{ $hotel->jumlah_kamar ?? 0 }} Kamar</span>
                                    </div>
                                    @if ($hotel->catatan)
                                        {{-- Ganti dari 'keterangan' ke 'catatan' sesuai model --}}
                                        <div class="detail-item"><span class="detail-label">Catatan</span><span
                                                class="detail-value">{{ $hotel->catatan }}</span></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- DOKUMEN --}}
                    @if ($service->documents?->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-file-text"></i> Dokumen</h6>

                            @php
                                $groupedDocs = $service->documents->groupBy(
                                    fn($doc) => $doc->document?->id ?? $doc->document_id,
                                );
                            @endphp

                            <ul class="list-group summary-list">
                                @foreach ($groupedDocs as $parentId => $docs)
                                    @php
                                        $parentName =
                                            optional($docs->first()->document)->name ?? 'Dokumen Tidak Dikenal';
                                        $hasChildren = $docs->contains(fn($d) => !is_null($d->document_children_id));
                                        $totalPax = $docs->sum('jumlah');
                                    @endphp

                                    <li class="list-group-item bg-light fw-bold">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fs-6">{{ $parentName }}</span>
                                            <span class="badge bg-primary rounded-pill">{{ $totalPax }} Pax</span>
                                        </div>
                                    </li>

                                    @if ($hasChildren)
                                        @foreach ($docs->whereNotNull('document_children_id') as $child)
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center ps-4">
                                                <div class="text-muted">
                                                    {{ $child->documentChild?->name ?? 'Sub Dokumen Tidak Dikenal' }}
                                                </div>
                                                <span class="badge rounded-pill">{{ $child->jumlah ?? 0 }} Pax</span>
                                            </li>
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- HANDLING (Perbaikan) --}}
                    @if ($service->handlings?->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-briefcase"></i> Handling</h6>
                            @foreach ($service->handlings as $handling)
                                <div class="p-3 mb-2" style="background: var(--haramain-light); border-radius: 8px;">
                                    {{-- Ambil tipe dari $handling->name --}}
                                    <strong>Handling {{ ucfirst($handling->name ?? 'N/A') }}</strong>
                                    @if (strtolower($handling->name ?? '') == 'hotel')
                                        @php $detail = $handling->handlingHotels?->first(); @endphp
                                        <div class="detail-item"><span class="detail-label">Hotel</span><span
                                                class="detail-value">{{ $detail?->nama ?? 'N/A' }}</span></div>
                                        <div class="detail-item"><span class="detail-label">Tanggal</span><span
                                                class="detail-value">{{ $detail?->tanggal ? \Carbon\Carbon::parse($detail->tanggal)->format('d M Y') : 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item"><span class="detail-label">Pax</span><span
                                                class="detail-value">{{ $detail?->pax ?? 0 }}</span></div>
                                    @elseif (strtolower($handling->name ?? '') == 'bandara')
                                        @php $detail = $handling->handlingPlanes?->first(); @endphp
                                        <div class="detail-item"><span class="detail-label">Bandara</span><span
                                                class="detail-value">{{ $detail?->nama_bandara ?? 'N/A' }}</span></div>
                                        <div class="detail-item"><span class="detail-label">Kedatangan</span><span
                                                class="detail-value">{{ $detail?->kedatangan_jamaah ? \Carbon\Carbon::parse($detail->kedatangan_jamaah)->format('d M Y') : 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item"><span class="detail-label">Jamaah</span><span
                                                class="detail-value">{{ $detail?->jumlah_jamaah ?? 0 }}</span></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- PENDAMPING (Perbaikan - Bukan Pivot) --}}
                    @if ($service->guides?->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-people"></i> Pendamping</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->guides as $guide)
                                    <li class="list-group-item">
                                        {{-- Ambil nama dari relasi guideItem --}}
                                        <strong>{{ $guide->guideItem?->nama ?? 'N/A' }}</strong>
                                        ({{ $guide->jumlah ?? 0 }} Orang)
                                        <small class="d-block text-muted">
                                            {{-- Ambil tanggal dari kolom di tabel guides --}}
                                            Periode:
                                            {{ $guide->muthowif_dari ? \Carbon\Carbon::parse($guide->muthowif_dari)->format('d M Y') : 'N/A' }}
                                            s/d
                                            {{ $guide->muthowif_sampai ? \Carbon\Carbon::parse($guide->muthowif_sampai)->format('d M Y') : 'N/A' }}
                                        </small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- KONTEN (Perbaikan - Bukan Pivot) --}}
                    @if ($service->contents?->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-camera"></i> Konten</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->contents as $content)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{-- Ambil nama dari relasi content --}}
                                        {{ $content->content?->name ?? 'N/A' }}
                                        {{-- Ambil jumlah dari model ContentCustomer --}}
                                        <span class="badge rounded-pill">{{ $content->jumlah ?? 0 }} Pax</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- ===================================================== --}}
                    {{-- 💸 DETAIL PENUKARAN REYAL (Versi blok per item) --}}
                    {{-- ===================================================== --}}
                    @if ($service->exchanges?->isNotEmpty())
                        @foreach ($service->exchanges as $exchange)
                            <div class="service-detail-block">
                                <h6 class="service-detail-title">
                                    <i class="bi bi-currency-exchange"></i> Penukaran Reyal
                                </h6>
                                <div class="p-3 mb-3" style="background: var(--haramain-light); border-radius: 8px;">
                                    <strong>
                                        Tipe: {{ ucfirst($exchange->tipe ?? 'N/A') }}
                                        ({{ $exchange->tipe == 'tamis' ? 'Rupiah → Reyal' : ($exchange->tipe == 'tumis' ? 'Reyal → Rupiah' : 'N/A') }})
                                    </strong>

                                    @if ($exchange->tipe == 'tamis')
                                        <div class="detail-item">
                                            <span class="detail-label">Jumlah (Rp)</span>
                                            <span class="detail-value">
                                                Rp {{ number_format($exchange->jumlah_input ?? 0, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Kurs (Rp)</span>
                                            <span class="detail-value">
                                                Rp {{ number_format($exchange->kurs ?? 0, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Hasil (SAR)</span>
                                            <span class="detail-value">
                                                {{ number_format($exchange->hasil ?? 0, 2, ',', '.') }} SAR
                                            </span>
                                        </div>
                                    @elseif ($exchange->tipe == 'tumis')
                                        <div class="detail-item">
                                            <span class="detail-label">Jumlah (SAR)</span>
                                            <span class="detail-value">
                                                {{ number_format($exchange->jumlah_input ?? 0, 2, ',', '.') }} SAR
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Kurs (Rp)</span>
                                            <span class="detail-value">
                                                Rp {{ number_format($exchange->kurs ?? 0, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Hasil (Rp)</span>
                                            <span class="detail-value">
                                                Rp {{ number_format($exchange->hasil ?? 0, 2, ',', '.') }}
                                            </span>
                                        </div>
                                    @endif

                                    <div class="detail-item">
                                        <span class="detail-label">Tgl Penyerahan</span>
                                        <span class="detail-value">
                                            {{ $exchange->tanggal_penyerahan
                                                ? \Carbon\Carbon::parse($exchange->tanggal_penyerahan)->format('d M Y')
                                                : 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- ===================================================== --}}
                    {{-- 💸 DETAIL REYAL (versi berbentuk table) --}}
                    {{-- ===================================================== --}}
                    {{-- @if ($service->exchanges->isNotEmpty())
                        <div class="card mt-4">
                            <div class="card-header" style="background-color: #f8f9fa;">
                                <h5 class="card-title mb-0" style="color: #1a4b8c;">
                                    <i class="bi bi-currency-exchange"></i> Detail Penukaran Reyal
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tipe</th>
                                                <th>Tanggal Penyerahan</th>
                                                <th>Jumlah Input</th>
                                                <th>Kurs</th>
                                                <th>Hasil</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($service->exchanges as $exchange)
                                                <tr>
                                                    <td style="text-transform: uppercase;">
                                                        <strong>{{ $exchange->tipe }}</strong>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($exchange->tanggal_penyerahan)->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        <strong>{{ $exchange->tipe == 'tamis' ? 'Rp' : 'SAR' }}</strong>
                                                        {{ number_format($exchange->jumlah_input, 2, ',', '.') }}
                                                    </td>
                                                    <td>{{ number_format($exchange->kurs, 2, ',', '.') }}</td>
                                                    <td>
                                                        <strong>{{ $exchange->tipe == 'tamis' ? 'SAR' : 'Rp' }}</strong>
                                                        {{ number_format($exchange->hasil, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif --}}

                    {{-- TOUR (Perbaikan - Bukan Pivot) --}}
                    @if ($service->tours?->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-geo-alt"></i> Tour</h6>
                            @foreach ($service->tours as $tour)
                                <div class="p-3 mb-2" style="background: var(--haramain-light); border-radius: 8px;">
                                    {{-- Ambil nama dari relasi tourItem --}}
                                    <strong>Tour: {{ $tour->tourItem?->name ?? 'N/A' }}</strong>
                                    <div class="detail-item"><span class="detail-label">Tanggal</span><span
                                            {{-- Ambil tanggal dari kolom di tabel tours --}}
                                            class="detail-value">{{ $tour->tanggal_keberangkatan ? \Carbon\Carbon::parse($tour->tanggal_keberangkatan)->format('d M Y') : 'N/A' }}</span>
                                    </div>
                                    <div class="detail-item"><span class="detail-label">Transport</span><span
                                            {{-- Ambil transport dari relasi transportation --}}
                                            class="detail-value">{{ $tour->transportation?->nama ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- MEALS (Perbaikan - Bukan Pivot) --}}
                    @if ($service->meals?->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-egg-fried"></i> Meals</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->meals as $meal)
                                    <li class="list-group-item">
                                        {{-- Ambil nama dari relasi mealItem --}}
                                        <strong>{{ $meal->mealItem?->name ?? 'N/A' }}</strong> ({{ $meal->jumlah ?? 0 }}
                                        Pax)
                                        <small class="d-block text-muted">
                                            {{-- Ambil tanggal dari kolom di tabel meals --}}
                                            Periode:
                                            {{ $meal->dari_tanggal ? \Carbon\Carbon::parse($meal->dari_tanggal)->format('d M Y') : 'N/A' }}
                                            s/d
                                            {{ $meal->sampai_tanggal ? \Carbon\Carbon::parse($meal->sampai_tanggal)->format('d M Y') : 'N/A' }}
                                        </small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- DORONGAN (Perbaikan - Bukan Pivot) --}}
                    @if ($service->dorongans?->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-basket"></i> Dorongan</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->dorongans as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{-- Ambil nama dari relasi dorongan --}}
                                        {{ $item->dorongan?->name ?? 'N/A' }}
                                        {{-- Ambil jumlah dari model DoronganOrder --}}
                                        <span class="badge rounded-pill">{{ $item->jumlah ?? 0 }} Pax</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- WAQAF (Perbaikan - Bukan Pivot) --}}
                    @if ($service->wakafs?->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-gift"></i> Wakaf</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->wakafs as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{-- Ambil nama dari relasi wakaf --}}
                                        {{ $item->wakaf?->nama ?? 'N/A' }}
                                        {{-- Ambil jumlah dari model WakafCustomer --}}
                                        <span class="badge rounded-pill">{{ $item->jumlah ?? 0 }} Unit</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- BADAL (Perbaikan - Nama Kolom) --}}
                    @if ($service->badals?->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-gift"></i> Badal Umrah</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->badals as $item)
                                    <li class="list-group-item">
                                        {{-- Kolom di db adalah 'name' --}}
                                        <strong>Atas Nama: {{ $item->name ?? 'N/A' }}</strong>
                                        <small class="d-block text-muted">Tgl Pelaksanaan:
                                            {{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d M Y') : 'N/A' }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>

                @php
                    $order = $service->orders->first();
                    $totalAmount = $order ? $order->total_amount : 0;
                @endphp
                <div class="form-section p-3" style="background: var(--haramain-light); border-radius: 8px;">
                    <h6 class="form-section-title">
                        <i class="bi bi-cash-coin"></i> Total Biaya
                    </h6>
                    <div class="detail-item" style="border: none;" id="travel">
                        <span class="detail-label" style="font-size: 1.2rem;">Total Akhir</span>
                        <br>
                        <span class="detail-value" style="font-size: 1.5rem; color: var(--haramain-primary);">
                            Rp {{ number_format($totalAmount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    html: '<strong>{{ session('success') }}</strong><br><small> Mohon periksa kembali data yang telah Anda input untuk memastikan tidak ada kesalahan.</small>',
                    icon: 'success',
                    confirmButtonText: 'Oke'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });
    </script>
@endpush
