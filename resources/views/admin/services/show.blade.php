@extends('admin.master')

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
            font-weight: 500;
            color: var(--text-secondary);
        }

        .detail-value {
            font-weight: 600;
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
        }
    </style>
@endpush

@section('content')
    <div class="service-create-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-file-earmark-text"></i> Detail Permintaan Service
                </h5>
                <div>
                    {{-- Tombol Aksi (Edit, Cetak, dll) --}}
                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="{{ route('admin.services') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
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
                            <div class="detail-item">
                                <span class="detail-label">Nama Travel</span>
                                <span class="detail-value">{{ $service->pelanggan->nama_travel ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Penanggung Jawab</span>
                                <span class="detail-value">{{ $service->pelanggan->penanggung_jawab ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Email</span>
                                <span class="detail-value">{{ $service->pelanggan->email ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Telepon</span>
                                <span class="detail-value">{{ $service->pelanggan->phone ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="detail-item">
                                <span class="detail-label">Tanggal Keberangkatan</span>
                                <span
                                    class="detail-value">{{ \Carbon\Carbon::parse($service->tanggal_keberangkatan)->format('d M Y') }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Tanggal Kepulangan</span>
                                <span
                                    class="detail-value">{{ \Carbon\Carbon::parse($service->tanggal_kepulangan)->format('d M Y') }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Jumlah Jamaah</span>
                                <span class="detail-value">{{ $service->total_jamaah }} Orang</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Status</span>
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

                    {{-- TRANSPORTASI --}}
                    {{-- Asumsi: $service->transportations adalah relasi --}}
                    @if ($service->transportations && $service->transportations->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-airplane"></i> Transportasi</h6>

                            @foreach ($service->transportations->where('type', 'airplane') as $tiket)
                                <div class="p-3 mb-2" style="background: var(--haramain-light); border-radius: 8px;">
                                    <strong>Tiket Pesawat: {{ $tiket->maskapai }} ({{ $tiket->rute }})</strong>
                                    <div class="detail-item"><span class="detail-label">Tanggal</span><span
                                            class="detail-value">{{ \Carbon\Carbon::parse($tiket->tanggal)->format('d M Y') }}</span>
                                    </div>
                                    <div class="detail-item"><span class="detail-label">Jumlah</span><span
                                            class="detail-value">{{ $tiket->jumlah }} Pax</span></div>
                                    @if ($tiket->keterangan)
                                        <div class="detail-item"><span class="detail-label">Ket</span><span
                                                class="detail-value">{{ $tiket->keterangan }}</span></div>
                                    @endif
                                </div>
                            @endforeach

                            @foreach ($service->transportations->where('type', 'bus') as $bus)
                                <div class="p-3 mb-2" style="background: var(--haramain-light); border-radius: 8px;">
                                    <strong>Transport Darat: {{ $bus->transportation->nama ?? 'N/A' }}</strong>
                                    <div class="detail-item"><span class="detail-label">Rute</span><span
                                            class="detail-value">{{ $bus->route->route ?? 'N/A' }}</span></div>
                                    <div class="detail-item"><span class="detail-label">Periode</span><span
                                            class="detail-value">{{ \Carbon\Carbon::parse($bus->tanggal_dari)->format('d M') }}
                                            - {{ \Carbon\Carbon::parse($bus->tanggal_sampai)->format('d M Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- HOTEL --}}
                    {{-- Asumsi: $service->hotels adalah relasi --}}
                    @if ($service->hotels && $service->hotels->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-building"></i> Hotel</h6>
                            @foreach ($service->hotels as $hotel)
                                <div class="p-3 mb-2" style="background: var(--haramain-light); border-radius: 8px;">
                                    <strong>{{ $hotel->nama_hotel }}</strong>
                                    <div class="detail-item"><span class="detail-label">Check-in</span><span
                                            class="detail-value">{{ \Carbon\Carbon::parse($hotel->tanggal_checkin)->format('d M Y') }}</span>
                                    </div>
                                    <div class="detail-item"><span class="detail-label">Check-out</span><span
                                            class="detail-value">{{ \Carbon\Carbon::parse($hotel->tanggal_checkout)->format('d M Y') }}</span>
                                    </div>
                                    <div class="detail-item"><span class="detail-label">Total Kamar</span><span
                                            class="detail-value">{{ $hotel->jumlah_kamar }} Kamar</span></div>
                                    @if ($hotel->keterangan)
                                        <div class="detail-item"><span class="detail-label">Ket</span><span
                                                class="detail-value">{{ $hotel->keterangan }}</span></div>
                                    @endif

                                    {{-- Tipe Kamar (Pivot?) --}}
                                    @if ($hotel->types?->isNotEmpty())
                                        <div class="mt-2">
                                            <small class="detail-label">Rincian Tipe Kamar:</small>
                                            <ul class="list-group summary-list mt-1">
                                                @foreach ($hotel->types as $type)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center p-2">
                                                        {{ $type->nama_tipe }}
                                                        <span
                                                            class="badge rounded-pill">{{ $type->pivot?->jumlah_kamar_tipe }}
                                                            Kamar</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- DOKUMEN --}}
                    {{-- Asumsi: $service->documents adalah relasi --}}
                    @if ($service->documents && $service->documents->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-file-text"></i> Dokumen</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->documents as $doc)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            {{ $doc->name }}
                                            @if ($doc->pivot?->keterangan)
                                                <small class="d-block text-muted">Ket:
                                                    {{ $doc->pivot?->keterangan }}</small>
                                            @endif
                                        </div>
                                        <span class="badge rounded-pill">{{ $doc->pivot?->jumlah_dokumen }} Pax</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- HANDLING --}}
                    {{-- Asumsi: $service->handlings adalah relasi --}}
                    @if ($service->handlings && $service->handlings->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-briefcase"></i> Handling</h6>
                            @foreach ($service->handlings as $handling)
                                <div class="p-3 mb-2" style="background: var(--haramain-light); border-radius: 8px;">
                                    <strong>Handling {{ ucfirst($handling->tipe) }}</strong>
                                    @if ($handling->tipe == 'hotel')
                                        <div class="detail-item"><span class="detail-label">Hotel</span><span
                                                class="detail-value">{{ $handling->nama_hotel }}</span></div>
                                        <div class="detail-item"><span class="detail-label">Tanggal</span><span
                                                class="detail-value">{{ \Carbon\Carbon::parse($handling->tanggal)->format('d M Y') }}</span>
                                        </div>
                                        <div class="detail-item"><span class="detail-label">Pax</span><span
                                                class="detail-value">{{ $handling->pax }}</span></div>
                                    @else
                                        <div class="detail-item"><span class="detail-label">Bandara</span><span
                                                class="detail-value">{{ $handling->nama_bandara }}</span></div>
                                        <div class="detail-item"><span class="detail-label">Kedatangan</span><span
                                                class="detail-value">{{ \Carbon\Carbon::parse($handling->kedatangan_jamaah)->format('d M Y') }}</span>
                                        </div>
                                        <div class="detail-item"><span class="detail-label">Jamaah</span><span
                                                class="detail-value">{{ $handling->jumlah_jamaah }}</span></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- PENDAMPING --}}
                    {{-- Asumsi: $service->guides adalah relasi --}}
                    @if ($service->guides && $service->guides->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-people"></i> Pendamping</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->guides as $guide)
                                    <li class="list-group-item">
                                        <strong>{{ $guide->nama }}</strong> ({{ $guide->pivot?->jumlah }} Orang)
                                        <small class="d-block text-muted">
                                            Periode:
                                            {{ \Carbon\Carbon::parse($guide->pivot?->tanggal_dari)->format('d M Y') }} s/d
                                            {{ \Carbon\Carbon::parse($guide->pivot?->tanggal_sampai)->format('d M Y') }}
                                        </small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- KONTEN --}}
                    {{-- Asumsi: $service->contents adalah relasi --}}
                    @if ($service->contents && $service->contents->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-camera"></i> Konten</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->contents as $content)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $content->name }}
                                        <span class="badge rounded-pill">{{ $content->pivot?->jumlah }} Pax</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- REYAL --}}
                    {{-- Asumsi: $service->reyal adalah relasi (HasOne) --}}
                    @if ($service->reyal)
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-currency-exchange"></i> Penukaran Reyal</h6>
                            <div class="p-3" style="background: var(--haramain-light); border-radius: 8px;">
                                <strong>Tipe: {{ ucfirst($service->reyal->tipe) }}
                                    ({{ $service->reyal->tipe == 'tamis' ? 'Rupiah → Reyal' : 'Reyal → Rupiah' }})</strong>
                                @if ($service->reyal->tipe == 'tamis')
                                    <div class="detail-item"><span class="detail-label">Jumlah (Rp)</span><span
                                            class="detail-value">Rp
                                            {{ number_format($service->reyal->jumlah_rupiah) }}</span></div>
                                    <div class="detail-item"><span class="detail-label">Kurs (Rp)</span><span
                                            class="detail-value">Rp {{ number_format($service->reyal->kurs) }}</span>
                                    </div>
                                    <div class="detail-item"><span class="detail-label">Hasil (SAR)</span><span
                                            class="detail-value">{{ number_format($service->reyal->hasil, 2) }} SAR</span>
                                    </div>
                                @else
                                    <div class="detail-item"><span class="detail-label">Jumlah (SAR)</span><span
                                            class="detail-value">{{ number_format($service->reyal->jumlah_reyal) }}
                                            SAR</span></div>
                                    <div class="detail-item"><span class="detail-label">Kurs (Rp)</span><span
                                            class="detail-value">Rp {{ number_format($service->reyal->kurs) }}</span>
                                    </div>
                                    <div class="detail-item"><span class="detail-label">Hasil (Rp)</span><span
                                            class="detail-value">Rp {{ number_format($service->reyal->hasil, 2) }}</span>
                                    </div>
                                @endif
                                <div class="detail-item"><span class="detail-label">Tgl Penyerahan</span><span
                                        class="detail-value">{{ \Carbon\Carbon::parse($service->reyal->tanggal_penyerahan)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- TOUR --}}
                    {{-- Asumsi: $service->tours adalah relasi --}}
                    @if ($service->tours && $service->tours->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-geo-alt"></i> Tour</h6>
                            @foreach ($service->tours as $tour)
                                <div class="p-3 mb-2" style="background: var(--haramain-light); border-radius: 8px;">
                                    <strong>Tour: {{ $tour->name }}</strong>
                                    <div class="detail-item"><span class="detail-label">Tanggal</span><span
                                            class="detail-value">{{ \Carbon\Carbon::parse($tour->pivot?->tanggal_tour)->format('d M Y') }}</span>
                                    </div>
                                    <div class="detail-item"><span class="detail-label">Transport</span><span
                                            class="detail-value">{{ $tour->pivot?->transportation->nama ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- MEALS --}}
                    {{-- Asumsi: $service->meals adalah relasi --}}
                    @if ($service->meals && $service->meals->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-egg-fried"></i> Meals</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->meals as $meal)
                                    <li class="list-group-item">
                                        <strong>{{ $meal->name }}</strong> ({{ $meal->pivot?->jumlah }} Pax)
                                        <small class="d-block text-muted">
                                            Periode:
                                            {{ \Carbon\Carbon::parse($meal->pivot?->tanggal_dari)->format('d M Y') }} s/d
                                            {{ \Carbon\Carbon::parse($meal->pivot?->tanggal_sampai)->format('d M Y') }}
                                        </small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- DORONGAN --}}
                    {{-- Asumsi: $service->dorongans adalah relasi --}}
                    @if ($service->dorongans && $service->dorongans->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-basket"></i> Dorongan</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->dorongans as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $item->name }}
                                        <span class="badge rounded-pill">{{ $item->pivot?->jumlah }} Pax</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- WAQAF --}}
                    {{-- Asumsi: $service->wakafs adalah relasi --}}
                    @if ($service->wakafs && $service->wakafs->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-gift"></i> Wakaf</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->wakafs as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $item->nama }}
                                        <span class="badge rounded-pill">{{ $item->pivot?->jumlah }} Unit</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- BADAL --}}
                    {{-- Asumsi: $service->badals adalah relasi --}}
                    @if ($service->badals && $service->badals->isNotEmpty())
                        <div class="service-detail-block">
                            <h6 class="service-detail-title"><i class="bi bi-gift"></i> Badal Umrah</h6>
                            <ul class="list-group summary-list">
                                @foreach ($service->badals as $item)
                                    <li class="list-group-item">
                                        <strong>Atas Nama: {{ $item->nama_dibadalkan }}</strong>
                                        <small class="d-block text-muted">Tgl Pelaksanaan:
                                            {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d M Y') }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>

                <div class="form-section p-3" style="background: var(--haramain-light); border-radius: 8px;">
                    <h6 class="form-section-title">
                        <i class="bi bi-cash-coin"></i> Total Biaya
                    </h6>
                    <div class="detail-item" style="border: none;">
                        <span class="detail-label" style="font-size: 1.2rem;">Total Akhir (Deal)</span>
                        <span class="detail-value" style="font-size: 1.5rem; color: var(--haramain-primary);">
                            Rp {{ number_format($service->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
