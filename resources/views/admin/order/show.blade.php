@extends('admin.master')
@section('title', 'Detail Pembayaran (Invoice)')

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

        /* Grid Info Customer */
        .customer-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.25rem;
        }

        /* Stat Card (Untuk Ringkasan Invoice) */
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

        .info-card.success-card {
            background-color: var(--success-bg);
            border-color: var(--success-color);
        }

        .info-card.danger-card {
            background-color: var(--danger-bg);
            border-color: var(--danger-color);
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
        }

        /* Ukuran font besar untuk nominal */
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

        /* == STYLE TABEL MODERN == */
        .table-responsive {
            padding: 0;
            overflow-x: auto;
        }

        .table-card-body {
            padding: 0 1.5rem 1.5rem;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
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

        .table thead th.right-align,
        .table tbody td.right-align {
            text-align: right;
        }

        .table tbody tr {
            background-color: white;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
            box-shadow: 0 4px 12px rgba(42, 111, 219, 0.1);
        }

        .table tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            text-align: left;
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

        /* Style untuk total di tabel */
        .table tfoot tr td {
            border-top: 2px solid var(--haramain-primary);
            font-weight: 700;
            color: var(--haramain-primary);
            padding: 1rem 1.25rem;
        }

        .table .service-category-row td {
            background-color: var(--hover-bg);
            color: var(--haramain-primary);
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.75rem 1.25rem;
        }

        /* Media Query */
        @media (max-width: 992px) {

            .stats-grid,
            .customer-info-grid {
                grid-template-columns: 1fr 1fr;
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

        {{-- Asumsi Controller mengirim variabel $order (Model Order) --}}

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-person-badge"></i>
                    <span class="title-text">Detail Customer</span>
                </h5>
                <a href="{{ route('admin.order') }}" class="btn-secondary"> {{-- Ganti # dengan route index payment Anda --}}
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if ($order->service?->pelanggan)
                    @php
                        $service = $order->service;
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
                            <span class="label">Tanggal Keberangakatan</span>
                            <span class="value">{{ $service->tanggal_keberangkatan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Tanggal Kepulangan</span>
                            <span class="value">{{ $service->tanggal_kepulangan ?? '-' }}</span>
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
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span class="title-text">Ringkasan Invoice: {{ $order->invoice }}</span>
                </h5>
                <a href="#" class="btn-action"> {{-- Ganti # dengan route edit order --}}
                    <i class="bi bi-pencil-fill"></i>
                    Edit Invoice
                </a>
            </div>
            <div class="card-body">
                @php
                    $status = strtolower($order->status_pembayaran);
                    $statusClass = '';
                    if (in_array($status, ['lunas', 'deal'])) {
                        $statusClass = 'badge-success';
                    } elseif (in_array($status, ['belum_bayar', 'nego'])) {
                        $statusClass = 'badge-danger';
                    } else {
                        $statusClass = 'badge-warning';
                    }
                @endphp
                <div class="stats-grid">
                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-cash-stack"></i> Total Tagihan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Total Amount (Final)</span>
                                <span class="value value-large">Rp
                                    {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Total Estimasi (Awal)</span>
                                <span class="value">Rp {{ number_format($order->total_estimasi ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-card success-card">
                        <h6 class="info-card-title"><i class="bi bi-check-circle-fill"></i> Total Dibayar</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Sudah Dibayar</span>
                                <span class="value value-large">Rp
                                    {{ number_format($order->total_yang_dibayarkan ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Status Pembayaran</span>
                                <span class="value badge {{ $statusClass }}">{{ $order->status_pembayaran }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-card danger-card">
                        <h6 class="info-card-title"><i class="bi bi-exclamation-triangle-fill"></i> Sisa Tagihan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Sisa Hutang</span>
                                <span class="value value-large">Rp
                                    {{ number_format($order->sisa_hutang ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Status Bukti Bayar</span>
                                <span class="value">{{ $order->status_bukti_pembayaran ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-receipt"></i>
                    <span class="title-text">Rincian Tagihan</span>
                </h5>
            </div>
            <div class="card-body table-card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Layanan</th>
                                <th>Deskripsi Item</th>
                                <th class="right-align">Harga Jual</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- 1. Hotels --}}
                            @if ($order->service->hotels->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Hotel</td>
                                </tr>
                                @foreach ($order->service->hotels as $item)
                                    <tr>
                                        <td>Hotel</td>
                                        <td>{{ $item->nama_hotel }} ({{ $item->jumlah_type ?? $item->jumlah_kamar }}
                                            kamar)</td>
                                        <td class="right-align">Rp
                                            {{ number_format($item->harga_jual ?? $item->harga_perkamar, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- 2. Meals --}}
                            @if ($order->service->meals->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Makanan</td>
                                </tr>
                                @foreach ($order->service->meals as $item)
                                    <tr>
                                        <td>Makanan</td>
                                        <td>{{ $item->mealItem?->name ?? 'N/A' }} ({{ $item->jumlah }} pax)</td>
                                        <td class="right-align">Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- 3. Transportasi (Darat & Udara) --}}
                            @if ($order->service->planes->isNotEmpty() || $order->service->transportationItem->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Transportasi</td>
                                </tr>
                                @foreach ($order->service->planes as $item)
                                    <tr>
                                        <td>Pesawat</td>
                                        <td>{{ $item->maskapai }} [{{ $item->rute }}]</td>
                                        <td class="right-align">Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($order->service->transportationItem as $item)
                                    <tr>
                                        <td>Transportasi Darat</td>
                                        <td>{{ $item->transportation?->nama ?? 'N/A' }}
                                            [{{ $item->route?->route ?? 'N/A' }}]</td>
                                        <td class="right-align">Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- 4. Tours --}}
                            @if ($order->service->tours->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Tour</td>
                                </tr>
                                @foreach ($order->service->tours as $item)
                                    <tr>
                                        <td>Tour</td>
                                        <td>{{ $item->tourItem?->name ?? 'N/A' }}</td>
                                        <td class="right-align">Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- 5. Guides --}}
                            @if ($order->service->guides->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Pendamping (Guide)</td>
                                </tr>
                                @foreach ($order->service->guides as $item)
                                    <tr>
                                        <td>Guide</td>
                                        <td>{{ $item->guideItem?->name ?? 'N/A' }} ({{ $item->jumlah }} org)</td>
                                        <td class="right-align">Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- 6. Documents --}}
                            @if ($order->service->documents->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Dokumen</td>
                                </tr>
                                @foreach ($order->service->documents as $item)
                                    <tr>
                                        <td>Dokumen</td>
                                        <td>{{ $item->document?->name ?? 'N/A' }} -
                                            {{ $item->documentChild?->name ?? '' }} ({{ $item->jumlah }} pcs)</td>
                                        <td class="right-align">Rp
                                            {{ number_format($item->harga_jual ?? ($item->harga ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- 7. Contents --}}
                            @if ($order->service->contents->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Konten</td>
                                </tr>
                                @foreach ($order->service->contents as $item)
                                    <tr>
                                        <td>Konten</td>
                                        <td>{{ $item->content?->name ?? 'N/A' }} ({{ $item->jumlah }} pcs)</td>
                                        <td class="right-align">Rp
                                            {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- 8. Badal --}}
                            @if ($order->service->badals->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Badal</td>
                                </tr>
                                @foreach ($order->service->badals as $item)
                                    <tr>
                                        <td>Badal</td>
                                        <td>{{ $item->name ?? 'N/A' }}</td>
                                        <td class="right-align">Rp
                                            {{ number_format($item->harga_jual ?? ($item->price ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- 9. Wakaf --}}
                            @if ($order->service->wakafs->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Wakaf</td>
                                </tr>
                                @foreach ($order->service->wakafs as $item)
                                    <tr>
                                        <td>Wakaf</td>
                                        <td>{{ $item->wakaf?->name ?? 'N/A' }} ({{ $item->jumlah }} pcs)</td>
                                        <td class="right-align">Rp
                                            {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- 10. Dorongan --}}
                            @if ($order->service->dorongans->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Dorongan</td>
                                </tr>
                                @foreach ($order->service->dorongans as $item)
                                    <tr>
                                        <td>Dorongan</td>
                                        <td>{{ $item->dorongan?->name ?? 'N/A' }} ({{ $item->jumlah }} pcs)</td>
                                        <td class="right-align">Rp
                                            {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- 11. Handling --}}
                            @if ($order->service->handlings->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Handling</td>
                                </tr>
                                @foreach ($order->service->handlings as $item)
                                    <tr>
                                        <td>Handling</td>
                                        <td>{{ $item->name ?? 'N/A' }}</td>
                                        <td class="right-align">Rp
                                            {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- 12. Exchange (Reyal) --}}
                            @if ($order->service->exchanges->isNotEmpty())
                                <tr class="service-category-row">
                                    <td colspan="3">Penukaran (Reyal)</td>
                                </tr>
                                @foreach ($order->service->exchanges as $item)
                                    <tr>
                                        <td>Exchange</td>
                                        <td>{{ $item->tipe }} - {{ $item->jumlah_input }}</td>
                                        <td class="right-align">Rp
                                            {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif

                            {{-- (Tambahkan relasi lain jika ada di sini, misal 'filess') --}}

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="right-align">TOTAL TAGIHAN (DARI ORDER)</td>
                                <td class="right-align">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-hourglass-split"></i>
                    <span class="title-text">Riwayat Pembayaran & Upload</span>
                </h5>
            </div>
            <div class="card-body table-card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Loop dari relasi transactions --}}
                            @foreach ($order->transactions as $tx)
                                <tr>
                                    <td>{{ $tx->created_at->isoFormat('D MMM Y, HH:mm') }}</td>
                                    <td><span class="badge badge-primary">Pembayaran</span></td>
                                    <td class="right-align">Rp {{ number_format($tx->amount ?? 0, 0, ',', '.') }}</td>
                                    <td><span class="badge badge-success">{{ $tx->status }}</span></td>
                                    <td>-</td>
                                </tr>
                            @endforeach

                            {{-- Loop dari relasi uploadPayments --}}
                            @foreach ($order->uploadPayments as $up)
                                <tr>
                                    <td>{{ $up->created_at->isoFormat('D MMM Y, HH:mm') }}</td>
                                    <td><span class="badge badge-warning">Upload Bukti</span></td>
                                    <td class="right-align">-</td>
                                    <td><span class="badge badge-primary">{{ $up->status }}</span></td>
                                    <td>
                                        <a href="{{ url('storage/' . $up->bukti_pembayaran) }}" target="_blank">Lihat
                                            Bukti</a>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($order->transactions->isEmpty() && $order->uploadPayments->isEmpty())
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 2rem;">
                                        Belum ada riwayat pembayaran atau upload bukti.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
