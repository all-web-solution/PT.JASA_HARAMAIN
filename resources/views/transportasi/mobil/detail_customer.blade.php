@extends('admin.master')
@section('title', 'Detail Order Transportasi')

@push('styles')
    <style>
        /* == CSS UTAMA (Disalin dari file referensi) == */
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

        /* Tombol Aksi Kecil di Tabel */
        .btn-action-small {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            border: none;
            background-color: transparent;
        }

        .btn-action-small:hover {
            background-color: var(--haramain-light);
        }

        .btn-action-small i {
            font-size: 1rem;
        }

        .btn-edit {
            color: var(--haramain-secondary);
        }

        .btn-view {
            color: var(--text-secondary);
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

        /* == DESAIN GRID UNTUK DETAIL == */
        .detail-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            font-size: 0.9rem;
            background-color: var(--hover-bg);
            border: 1px solid var(--border-color);
            padding: 1rem;
            border-radius: 8px;
        }

        .info-item .label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 0.35rem;
            display: block;
        }

        .info-item .value {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1rem;
            word-break: break-word;
        }

        .info-item .badge {
            font-size: 1rem;
            padding: 0.5rem 0.75rem;
            align-self: flex-start;
        }

        /* Badge Status */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.8rem;
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
            text-align: center;
            white-space: nowrap;
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

        /* Media Query */
        @media (max-width: 768px) {
            .service-list-container {
                padding: 1rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">

        {{-- KARTU 1: DETAIL CUSTOMER --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-person-badge"></i>
                    <span class="title-text">Detail Customer</span>
                </h5>
                {{-- Tombol Kembali ke index transportasi --}}
                <a href="{{ route('transportation.customer') }}" class="btn-secondary"> {{-- Ganti # dengan route('transportasi.mobil.index') --}}
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
            <div class="card-body">
                {{-- Gunakan $service dari controller baru --}}
                @if ($service && $service->pelanggan)
                    @php $pelanggan = $service->pelanggan; @endphp

                    <div class="detail-info-grid">
                        <div class="info-item">
                            <span class="label">Nama Travel</span>
                            <span class="value">{{ $pelanggan->nama_travel ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Penanggung Jawab</span>
                            <span class="value">{{ $pelanggan->penanggung_jawab ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Kontak (HP)</span>
                            <span class="value">{{ $pelanggan->phone ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Email</span>
                            <span class="value" style="text-transform: none;">{{ $pelanggan->email ?? '-' }}</span>
                        </div>
                    @else
                        <p style="color: var(--text-secondary); text-align: center;">Tidak ada data service atau pelanggan
                            yang
                            terhubung.</p>
                @endif
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="bi bi-truck"></i>
                        <span class="title-text">Detail Order Transportasi</span>
                    </h5>
                </div>
                <div class="card-body table-card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Transportasi</th>
                                    <th>Rute</th>
                                    <th>Dari Tanggal</th>
                                    <th>Sampai Tanggal</th>
                                    <th>Supplier</th>
                                    <th>Harga Dasar</th>
                                    <th>Harga Jual</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop dari relasi $service->transportationItem --}}
                                @forelse ($service->transportationItem as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->transportation?->nama ?? '-' }}</td>
                                        <td>{{ $item->route?->route ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->dari_tanggal)->isoFormat('D MMM Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->sampai_tanggal)->isoFormat('D MMM Y') }}</td>
                                        <td>{{ $item->supplier ?? '-' }}</td>
                                        <td>{{ $item->harga_dasar ?? '-' }}</td>
                                        <td>{{ $item->harga_jual ?? '-' }}</td>
                                        <td>{{ $item->status ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('transportasi.customer.edit', $item->id) }}"
                                                class="btn-action-small btn-edit" title="Edit">
                                                {{-- route('transportasi.mobil.edit', $item->id) --}}
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 2rem;">
                                            Tidak ada data transportasi untuk layanan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
