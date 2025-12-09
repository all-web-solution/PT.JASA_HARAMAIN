@extends('admin.master')
@section('title', 'Detail Pelanggan')

@push('styles')
    <style>
        :root {
            /* Variabel CSS dari form service */
            --haramain-primary: #1a4b8c;
            --haramain-secondary: #2a6fdb;
            --haramain-light: #e6f0fa;
            --haramain-accent: #3d8bfd;
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --border-color: #d1e0f5;
            --hover-bg: #f0f7ff;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        /* Container (copy dari service, ganti nama class) */
        .customer-detail-container {
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
            /* Hapus transition jika tidak perlu di halaman show */
        }

        .card-header {
            background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            /* Agar tombol tidak turun drastis di layar kecil */
            gap: 1rem;
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

        /* Styling untuk Detail List (menggunakan dl) */
        .detail-list dt {
            /* Label */
            font-weight: 600;
            color: var(--text-secondary);
            padding-bottom: 0.5rem;
            /* Jarak bawah label */
        }

        .detail-list dd {
            /* Value */
            color: var(--text-primary);
            margin-bottom: 1rem;
            /* Jarak antar item detail */
            word-break: break-word;
            /* Agar teks panjang wrap */
        }

        @media (min-width: 768px) {

            /* Layout dl di layar medium ke atas */
            .detail-list.row dt {
                padding-bottom: 1rem;
                /* Samakan jarak bawah dgn dd */
            }
        }


        /* Stat Cards */
        .stat-card .card-body {
            padding: 1.25rem;
            /* Padding lebih kecil */
            text-align: center;
            /* Pusatkan teks */
        }

        .stat-card .stat-title {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--haramain-primary);
            /* Default color */
            margin: 0;
        }

        .stat-card .stat-value.text-danger {
            /* Khusus tagihan */
            color: var(--danger-color);
        }

        .stat-card .stat-value.text-primary {
            /* Khusus request */
            color: var(--haramain-secondary);
        }


        /* Table Styles (copy dari service) */
        .table-responsive {
            padding: 0;
            /* Hapus padding jika card-body sudah punya */
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
            /* Jarak antar baris */
            margin-top: -0.75rem;
            /* Offset agar spacing pas */
        }

        .table thead th {
            background-color: var(--haramain-light);
            color: var(--haramain-primary);
            font-weight: 600;
            padding: 1rem 1.25rem;
            border: none;
            /* Hapus border thead */
            text-align: center;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table thead th:first-child {
            border-top-left-radius: 8px;
        }

        .table thead th:last-child {
            border-top-right-radius: 8px;
        }

        .table tbody tr {
            background-color: white;
            transition: all 0.3s ease;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
            /* Shadow tipis per baris */
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(42, 111, 219, 0.1);
        }

        .table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border: none;
            /* Hapus border default */
            text-align: center;
            color: var(--text-primary);
        }

        .table tbody td:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .table tbody td:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* Badge (copy dari service) */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        /* Tambahkan style spesifik jika perlu (bg-opacity dll) */
        .badge.bg-success {
            background-color: rgba(40, 167, 69, 0.1) !important;
            color: var(--success-color) !important;
        }

        .badge.bg-danger {
            background-color: rgba(220, 53, 69, 0.1) !important;
            color: var(--danger-color) !important;
        }

        .badge.bg-warning {
            background-color: rgba(255, 193, 7, 0.1) !important;
            color: var(--warning-color) !important;
        }

        /* ... (style badge lain jika ada) ... */


        /* Tombol (copy dari service) */
        .btn {
            padding: 0.6rem 1.2rem;
            /* Sedikit lebih kecil */
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.875rem;
            /* Sedikit lebih kecil */
        }

        /* Style btn-sm */
        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
            gap: 4px;
        }

        .btn-primary {
            /* Tombol utama */
            background-color: var(--haramain-secondary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--haramain-primary);
        }

        .btn-secondary {
            /* Tombol netral/kembali */
            background-color: white;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: #f8f9fa;
        }

        .btn-outline-primary {
            /* Tombol aksi sekunder */
            border-color: var(--haramain-secondary);
            color: var(--haramain-secondary);
        }

        .btn-outline-primary:hover {
            background-color: var(--haramain-secondary);
            color: white;
        }

        .btn-success {
            /* Tombol aksi sukses */
            background-color: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        /* Responsive Tabel (copy dari service, sesuaikan data-label) */
        @media (max-width: 992px) {

            /* Ubah breakpoint jika perlu */
            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1.5rem;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                border: 1px solid var(--border-color);
            }

            .table tbody td {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
                padding: 0.75rem 1rem;
                border: none;
                border-bottom: 1px solid var(--border-color);
            }

            .table tbody tr td:last-child {
                border-bottom: none;
            }

            .table tbody td:before {
                content: attr(data-label);
                /* Ambil dari data-label */
                font-weight: 700;
                color: var(--haramain-primary);
                margin-bottom: 0.5rem;
                font-size: 0.8rem;
                text-transform: uppercase;
            }

            .table tbody td:first-child {
                border-radius: 8px 8px 0 0;
            }

            .table tbody td:last-child {
                border-radius: 0 0 8px 8px;
            }

            /* Atur agar tombol aksi tetap inline */
            .table tbody td[data-label="Aksi"]>div {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
                width: 100%;
            }

            .table tbody td[data-label="Aksi"] .btn {
                flex-grow: 1;
                /* Biar tombol membesar */
            }

        }
    </style>
@endpush

@section('content')

    @php
        // --- Kalkulasi tetap di sini ---
        $allOrders = $pelanggan->services->flatMap(fn($service) => $service->orders);
        $totalTransaksi = $allOrders->sum('total_amount'); // Gunakan total_amount
        $lastOrder = $allOrders->sortByDesc('created_at')->first(); // Ambil yg terbaru
        $totalRequest = $pelanggan->services->count(); // Lebih simpel: hitung jumlah service
    @endphp

    {{--
    CATATAN: Pastikan Eager Loading di Controller:
    $pelanggan = Pelanggan::with(['services.orders'])->findOrFail($id);
--}}

    <div class="customer-detail-container"> {{-- Ganti class container --}}

        {{-- CARD UTAMA: DETAIL CUSTOMER --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-person-badge"></i>Detail Customer
                </h5>
                {{-- Tombol Kembali --}}
                <a href="{{ route('admin.pelanggan') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                {{-- Gunakan Definition List (dl) untuk struktur lebih baik --}}
                <dl class="row detail-list">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">#CUST-{{ str_pad($pelanggan->id, 4, '0', STR_PAD_LEFT) }}</dd>

                    <dt class="col-sm-3">Nama Travel</dt>
                    <dd class="col-sm-9">{{ $pelanggan->nama_travel }}</dd>

                    <dt class="col-sm-3">Penanggung Jawab</dt>
                    <dd class="col-sm-9">{{ $pelanggan->penanggung_jawab }}</dd>

                    <dt class="col-sm-3">Kontak</dt>
                    <dd class="col-sm-9">{{ $pelanggan->phone ?? '-' }}</dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $pelanggan->email }}</dd>

                    <dt class="col-sm-3">Alamat</dt> {{-- Tambahkan Alamat --}}
                    <dd class="col-sm-9">{{ $pelanggan->alamat ?? '-' }}</dd>

                    <dt class="col-sm-3">No KTP</dt> {{-- Tambahkan KTP --}}
                    <dd class="col-sm-9">{{ $pelanggan->no_ktp ?? '-' }}</dd>

                    {{-- Tanggal dari service pertama (jika ada) --}}
                    <dt class="col-sm-3">Keberangkatan Awal</dt>
                    <dd class="col-sm-9">
                        {{ optional($pelanggan->services->sortBy('tanggal_keberangkatan')->first())->tanggal_keberangkatan ?? '-' }}
                    </dd>

                    <dt class="col-sm-3">Kepulangan Terakhir</dt>
                    <dd class="col-sm-9">
                        {{ optional($pelanggan->services->sortByDesc('tanggal_kepulangan')->first())->tanggal_kepulangan ?? '-' }}
                    </dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">
                        <span class="badge {{ $pelanggan->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                            {{ $pelanggan->status == 'active' ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </dd>

                    <dt class="col-sm-3">Terdaftar</dt>
                    <dd class="col-sm-9">{{ $pelanggan->created_at->format('d M Y') }}</dd>

                    <dt class="col-sm-3">Total Nilai Transaksi</dt>
                    <dd class="col-sm-9 fw-bold" style="color: var(--haramain-primary);">Rp
                        {{ number_format($totalTransaksi, 0, ',', '.') }}</dd>
                </dl>
            </div>
        </div>

        {{-- STAT CARDS (ROW BARU) --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card stat-card h-100"> {{-- Class untuk styling stat --}}
                    <div class="card-body">
                        <h6 class="stat-title mb-1">Total Tagihan (Sisa Terakhir)</h6>
                        <h3 class="stat-value text-danger">
                            Rp {{ number_format(optional($lastOrder)->sisa_hutang ?? 0, 0, ',', '.') }}
                        </h3>
                        <small class="text-muted">Dari Invoice: {{ optional($lastOrder)->invoice ?? '-' }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <h6 class="stat-title mb-1">Total Permintaan Service</h6>
                        <h3 class="stat-value text-primary">
                            {{ $totalRequest }} Permintaan
                        </h3>
                        <small class="text-muted">Jumlah service yang pernah dibuat</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD DAFTAR REQUEST (ORDER) --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"> {{-- Gunakan card-title --}}
                    <i class="bi bi-receipt"></i>Daftar Request / Order
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table"> {{-- Hapus table-hover table-haramain jika sudah dicover global --}}
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Invoice</th> {{-- Tambah kolom Invoice --}}
                                <th>Total Tagihan</th>
                                <th>Sisa Tagihan</th>
                                <th>Status Bayar</th> {{-- Tambah kolom Status --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allOrders->sortByDesc('created_at') as $order)
                                {{-- Urutkan terbaru dulu --}}
                                <tr>
                                    <td data-label="No">{{ $loop->iteration }}</td>
                                    <td data-label="Invoice">{{ $order->invoice }}</td> {{-- Tampilkan Invoice --}}
                                    <td data-label="Total Tagihan">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td data-label="Sisa Tagihan">Rp {{ number_format($order->sisa_hutang, 0, ',', '.') }}
                                    </td>
                                    <td data-label="Status Bayar">
                                        @if ($order->status_pembayaran === 'belum_bayar')
                                            <span class="badge bg-warning">Belum Bayar</span>
                                        @elseif ($order->status_pembayaran === 'sudah_bayar')
                                            <span class="badge bg-info text-dark">Sudah Bayar</span> {{-- Contoh status lain --}}
                                        @else
                                            <span class="badge bg-success">Lunas</span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="d-flex justify-content-center gap-2 flex-wrap"> {{-- Bungkus tombol --}}
                                            {{-- Sesuaikan nama route Anda --}}
                                            <a href="{{ route('invoice.cetak', $order->id) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary" title="Cetak Invoice">
                                                <i class="bi bi-printer"></i> Cetak
                                            </a>
                                            @if ($order->status_pembayaran !== 'lunas')
                                                {{-- Tombol bayar jika belum lunas --}}
                                                <a href="{{ route('orders.bayar', $order->id) }}"
                                                    class="btn btn-sm btn-success" title="Input Pembayaran">
                                                    <i class="bi bi-credit-card"></i> Bayar
                                                </a>
                                            @endif
                                            {{-- Tombol lihat detail service? --}}
                                            <a href="{{ route('admin.services.show', $order->service_id) }}"
                                                class="btn btn-sm btn-outline-secondary" title="Lihat Detail Service">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada request/order untuk
                                        pelanggan ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
