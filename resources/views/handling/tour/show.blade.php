@extends('admin.master')
@section('title', 'Detail Pesanan Tour')

@push('styles')
    {{-- Copy style Haramain dari file-file sebelumnya (singkat untuk contoh ini) --}}
    <style>
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
            min-height: 100vh;
        }

        .card {
            border-radius: 12px;
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: linear-gradient(135deg, var(--haramain-light) 0%, #fff 100%);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-weight: 700;
            color: var(--haramain-primary);
            gap: 10px;
            display: flex;
            align-items: center;
            margin: 0;
            font-size: 1.2rem;
        }

        /* Customer Grid */
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
            margin-bottom: 0.25rem;
        }

        .info-item .value {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Table */
        .table-responsive {
            padding: 0 1.5rem 1.5rem;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            margin-top: 1rem;
        }

        .table th {
            background: var(--haramain-light);
            color: var(--haramain-primary);
            padding: 1rem;
            text-align: center;
        }

        .table td {
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
        }

        .btn-secondary {
            background: #fff;
            border: 1px solid var(--border-color);
            color: #6c757d;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            border: 1px solid var(--success-color);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">

        @if (session('success'))
            <div class="alert-success">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><i class="bi bi-person-badge"></i> Detail Customer</h5>
                <a href="{{ route('handling.tour.customer') }}" class="btn-secondary"><i class="bi bi-arrow-left"></i>
                    Kembali</a>
            </div>
            <div class="customer-info-grid">
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
                    <span class="label">Tanggal Permintaan</span>
                    <span class="value">{{ $service->created_at->format('d M Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Jumlah Jamaah</span>
                    <span class="value">{{ $service->total_jamaah }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><i class="bi bi-map"></i> Daftar Item Tour</h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tour</th>
                            <th>Transportasi</th>
                            <th>Tgl Pelaksanaan</th>
                            <th>Supplier</th>
                            <th>Harga Jual</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tourList as $tour)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tour->tourItem->name ?? '-' }}</td>
                                <td>{{ $tour->transportation->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($tour->tanggal_keberangkatan)->format('d M Y') }}</td>
                                <td>{{ $tour->supplier ?? '-' }}</td>
                                <td class="fw-bold text-primary">SAR {{ number_format($tour->harga_jual, 0, ',', '.') }}
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $tour->status }}</span></td>
                                <td>
                                    <a href="{{ route('tour.customer.edit', $tour->id) }}" class="btn-edit" title="Edit">
                                        <i class="bi bi-pencil-square fs-5"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-3 text-muted">Tidak ada data tour.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
