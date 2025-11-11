@extends('admin.master')
@section('title', 'Pembayaran Order: ' . $order->invoice)

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

        .btn-action:hover,
        .btn-submit:hover {
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

        .info-card.success-card {
            background-color: var(--success-bg);
            border-color: var(--success-color);
        }

        .info-card.danger-card {
            background-color: var(--danger-bg);
            border-color: var(--danger-color);
        }

        .info-card.warning-card {
            background-color: var(--warning-bg, #fffbe6);
            border-color: var(--warning-color, #ffc107);
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

        /* Grid Info Customer */
        .customer-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

        /* == Form Style == */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .form-control,
        .form-select {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--text-secondary);
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control[type="file"] {
            padding: 0.6rem 1rem;
        }

        .form-control[type="file"]:focus {
            box-shadow: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--haramain-accent);
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(42, 111, 219, 0.25);
        }

        .btn-submit {
            background-color: var(--haramain-secondary);
            color: white;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-submit[disabled] {
            background-color: var(--text-secondary);
            cursor: not-allowed;
            opacity: 0.7;
        }

        .alert-custom {
            border-radius: 8px;
            padding: 1rem;
            border: 1px solid;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert-warning {
            background-color: var(--warning-bg);
            border-color: var(--warning-color);
            color: var(--warning-color);
        }

        .alert-success {
            background-color: var(--success-bg);
            border-color: var(--success-color);
            color: var(--success-color);
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

            .card-header .btn-secondary,
            .card-header .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')

    @php
        // -------------------------------------------------------------------
        // BAGIAN 1: LOGIC PENGECEKAN STATUS (Diletakkan di sini)
        // -------------------------------------------------------------------
        $items = $order->service->getAllItemsFromService();
        $totalItems = $items->count();

        // Hitung item yang BELUM final (statusnya 'nego')
        $itemsBelumFinal = $items->where('status', 'nego')->count();

        // Hitung item yang SUDAH final (status BUKAN 'nego')
        $itemsSudahFinal = $totalItems - $itemsBelumFinal;

        // Tombol aktif JIKA SEMUA item sudah TIDAK 'nego' lagi
        $semuaFinal = $totalItems > 0 && $itemsBelumFinal === 0;

        // --- LOGIKA BARU UNTUK KALKULASI TOTAL ---
        // $orders adalah SEMUA tagihan (termasuk cicilan) untuk service_id ini

        // 1. Total Tagihan Induk (ambil dari order paling LAMA)
        $orderInduk = $orders->last(); // .last() karena controller sort by desc
        $totalTagihanInduk = $orderInduk->total_amount_final ?? ($orderInduk->total_estimasi ?? 0);

        // 2. Total Dibayar Akumulatif (jumlahkan semua pembayaran)
        $totalDibayarAkumulatif = $orders->sum('total_yang_dibayarkan');

        // 3. Sisa Hutang Saat Ini (ambil dari order paling BARU)
        $orderAktif = $orders->first(); // .first() karena controller sort by desc
        $sisaHutangSaatIni = $orderAktif->sisa_hutang ?? 0;
        $statusPembayaranSaatIni = $orderAktif->status_pembayaran ?? 'estimasi';

        // === PERBAIKAN DI SINI ===
        // Cek status harga pada ORDER INDUK (Tagihan Pertama), bukan order saat ini
        $hargaSudahFinal = $orderInduk->status_harga == 'final';
    @endphp

    <div class="service-list-container">

        {{-- Tampilkan Pesan Sukses atau Error --}}
        @if (session('success'))
            <div class="alert alert-success alert-custom"
                style="border-color: var(--success-color); background-color: var(--success-bg); color: var(--success-color);">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-custom"
                style="border-color: var(--danger-color); background-color: var(--danger-bg); color: var(--danger-color);">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-person-badge"></i>
                    <span class="title-text">Detail Customer</span>
                </h5>
                <a href="{{ route('admin.order') }}" class="btn-secondary"> {{-- Arahkan ke index payment --}}
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
                                <span class="value value-large">Rp
                                    {{ number_format($totalTagihanInduk, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Total Estimasi (Awal)</span>
                                <span class="value">Rp
                                    {{ number_format($orderInduk->total_estimasi ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-card success-card">
                        <h6 class="info-card-title"><i class="bi bi-check-circle-fill"></i> Total Dibayar</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Sudah Dibayar</span>
                                <span class="value value-large">Rp
                                    {{ number_format($totalDibayarAkumulatif ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-card danger-card">
                        <h6 class="info-card-title"><i class="bi bi-exclamation-triangle-fill"></i> Sisa Tagihan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Sisa Hutang</span>
                                <span class="value value-large">Rp
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
                    <div class="alert alert-info alert-custom" role="alert"> {{-- Ganti ke alert-info --}}
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
                <form action="{{ route('order.calculateFinal', $order->id) }}" method="POST" style="margin-top: 1.5rem;">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="btn-submit" {{-- Tombol disabled jika BELUM SEMUA FINAL atau JIKA SUDAH FINAL --}}
                        @if (!$semuaFinal || $hargaSudahFinal) disabled @endif>
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
                                <th class="right-align">Total Tagihan</th>
                                <th class="right-align">Total Dibayar</th>
                                <th class="right-align">Sisa Hutang</th>
                                <th>Status</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- $orders adalah SEMUA order terkait service_id ini --}}
                            @forelse ($orders as $item)
                                @php
                                    $status = strtolower($item->status_pembayaran);
                                    $statusClass = '';
                                    if (in_array($status, ['lunas'])) {
                                        $statusClass = 'badge-success';
                                    } elseif (in_array($status, ['belum_bayar', 'belum_lunas'])) {
                                        $statusClass = 'badge-danger';
                                    } else {
                                        $statusClass = 'badge-warning';
                                    } // 'estimasi'
                                @endphp
                                <tr>
                                    <td data-label="No.">{{ $loop->iteration }}</td>
                                    <td data-label="Invoice">{{ $item->invoice }}</td>
                                    <td data-label="Total Tagihan" class="right-align">Rp
                                        {{ number_format($item->total_amount ?? $item->total_amount_final, 0, ',', '.') }}
                                    </td>
                                    <td data-label="Total Dibayar" class="right-align">Rp
                                        {{ number_format($item->total_yang_dibayarkan ?? 0, 0, ',', '.') }}</td>
                                    <td data-label="Sisa Hutang" class="right-align">Rp
                                        {{ number_format($item->sisa_hutang ?? 0, 0, ',', '.') }}</td>
                                    <td data-label="Status"><span
                                            class="badge {{ $statusClass }}">{{ $item->status_pembayaran }}</span></td>
                                    <td data-label="Bukti">
                                        @if ($item->bukti_pembayaran)
                                            <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank"
                                                class="btn-action btn-view" title="Lihat Bukti">
                                                <i class="bi bi-image-fill"></i>
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
