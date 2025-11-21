@extends('admin.master')
@section('title', 'Detail Pesanan Pesawat')

@push('styles')
    {{-- Copy style dari referensi (Detail Handling Hotel) --}}
    <style>
        /* ... (Paste CSS 'Haramain' lengkap di sini seperti di chat sebelumnya) ... */
        /* Ringkasan CSS untuk menghemat karakter di chat: */
        :root {
            --haramain-primary: #1a4b8c;
            --haramain-secondary: #2a6fdb;
            --haramain-light: #e6f0fa;
            --border-color: #d1e0f5;
            --hover-bg: #f0f7ff;
            --background-light: #f8fafd;
            --success-color: #28a745;
        }

        .service-list-container {
            padding: 2rem;
            background-color: var(--background-light);
        }

        .card {
            border-radius: 12px;
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--haramain-light) 0%, #fff 100%);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-weight: 700;
            color: var(--haramain-primary);
            gap: 10px;
            display: flex;
            align-items: center;
        }

        .customer-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            padding: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            background: var(--hover-bg);
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .info-item .label {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .info-item .value {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Table Styles */
        .table-responsive {
            padding: 0 1.5rem 1.5rem;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .table thead th {
            background: var(--haramain-light);
            color: var(--haramain-primary);
            padding: 1rem;
            text-align: center;
        }

        .table tbody td {
            background: #fff;
            padding: 1rem;
            text-align: center;
            vertical-align: middle;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr td:first-child {
            border-left: 1px solid var(--border-color);
            border-radius: 8px 0 0 8px;
        }

        .table tbody tr td:last-child {
            border-right: 1px solid var(--border-color);
            border-radius: 0 8px 8px 0;
        }

        .btn-edit {
            color: var(--haramain-secondary);
            cursor: pointer;
        }

        .btn-secondary {
            background: #fff;
            border: 1px solid var(--border-color);
            color: #6c757d;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
        }

        /* Alert Custom */
        .alert-custom {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">

        {{-- Message Alert --}}
        @if (session('success'))
            <div class="alert-custom alert-success">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><i class="bi bi-person-badge"></i> Detail Customer</h5>
                <a href="{{ route('plane.index') }}" class="btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
            <div class="customer-info-grid">
                <div class="info-item">
                    <span class="label">ID </span>
                    <span class="value">#CUST-{{ str_pad($service->pelanggan->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Nama Travel</span>
                    <span class="value">{{ $service->pelanggan->nama_travel }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Penanggung Jawab</span>
                    <span class="value">{{ $service->pelanggan->penanggung_jawab }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Kontak</span>
                    <span class="value">{{ $service->pelanggan->phone }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Email</span>
                    <span class="value">{{ $service->pelanggan->email }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Status</span>
                    <span class="value">{{ $service->pelanggan->status }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><i class="bi bi-airplane"></i> Daftar Penerbangan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Maskapai</th>
                                <th>Rute</th>
                                <th>Tgl Berangkat</th>
                                <th>Tiket</th> {{-- Kolom Tiket Baru --}}
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($planes as $plane)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $plane->maskapai }}</td>
                                    <td>{{ $plane->rute }}</td>
                                    <td>{{ \Carbon\Carbon::parse($plane->tanggal_keberangkatan)->format('d M Y') }}</td>
                                    {{-- Menampilkan Tiket sebagai Teks --}}
                                    <td>
                                        @if ($plane->tiket)
                                            <span class="text-primary fw-bold">{{ $plane->tiket }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><span>{{ $plane->status }}</span></td>
                                    <td>
                                        <a href="{{ route('plane.edit', $plane->id) }}" class="btn-action"
                                            title="Edit Data">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3">Tidak ada data penerbangan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
