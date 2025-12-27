@extends('admin.master')
@section('title', 'Detail Permintaan Dokumen Layanan')

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

        .card-title i {
            font-size: 1.5rem;
            color: var(--haramain-secondary);
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn-action,
        .btn-secondary {
            /* Style Tombol Anda */
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
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-action-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 .25rem;
            transition: all 0.3s ease;
            border: none;
            background-color: #fff0;
            color: var(--text-secondary);
        }

        .btn-action-icon:hover {
            background-color: var(--haramain-light);
            color: var(--haramain-secondary);
        }


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

        .info-card .label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-card .value {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1rem;
        }

        /* Table Style untuk List Item */
        .item-list-card {
            margin-top: 2rem;
            background-color: var(--haramain-light);
            padding: 1.5rem;
            border-radius: 8px;
        }

        .table-item-list th {
            background-color: var(--haramain-primary);
            color: white;
            padding: 0.75rem;
            text-align: center;
        }

        .table-item-list td {
            text-align: center;
            vertical-align: middle;
            padding: 1rem 0.5rem;
            background-color: white;
        }

        .actions-container-list {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

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

        .badge-danger {
            background-color: var(--danger-bg);
            color: var(--danger-color);
        }

        .badge-primary {
            background-color: var(--primary-bg);
            color: var(--haramain-secondary);
        }

        .text-info {
            color: var(--haramain-secondary);
        }

        .text-warning {
            color: var(--warning-color);
        }

        .text-danger {
            color: var(--danger-color);
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-person-vcard"></i>
                    <div>
                        <span class="title-text">
                            Detail Permintaan Dokumen (Service ID: {{ $service->unique_code ?? 'N/A' }})
                        </span>
                    </div>
                </h5>
                <div>
                    <a href="{{ route('visa.document.customer') }}" class="btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke Daftar Layanan
                    </a>
                </div>
            </div>

            <div class="card-body">

                <div class="stats-grid">
                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-person-badge"></i> Info Pelanggan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Nama Travel</span>
                                <span class="value">{{ $service->pelanggan?->nama_travel ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Penanggung Jawab</span>
                                <span class="value">{{ $service->pelanggan?->penanggung_jawab ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">No. Telepon</span>
                                <span class="value">{{ $service->pelanggan?->phone ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-calendar-event"></i> Info Layanan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Tanggal Keberangkatan</span>
                                <span
                                    class="value">{{ \Carbon\Carbon::parse($service->tanggal_keberangkatan)->format('d M Y') ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Total Jamaah</span>
                                <span class="value">{{ $service->total_jamaah ?? 0 }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Total Item Dokumen</span>
                                <span class="value">{{ $service->documents->count() }} Item</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-bar-chart"></i> Ringkasan Status</h6>
                        <div class="content">
                            @php
                                $statusCounts = $service->documents->groupBy('status')->map->count();
                            @endphp
                            @foreach ($statusCounts as $status => $count)
                                @php
                                    $status = strtolower($status);
                                    $statusClass = '';
                                    if (in_array($status, ['done', 'deal'])) {
                                        $statusClass = 'badge-success';
                                    } elseif (in_array($status, ['nego', 'tahap persiapan', 'tahap produksi'])) {
                                        $statusClass = 'badge-warning';
                                    } elseif (in_array($status, ['cancelled', 'batal'])) {
                                        $statusClass = 'badge-danger';
                                    } else {
                                        $statusClass = 'badge-primary';
                                    }
                                @endphp
                                <div class="info-item">
                                    <span class="label">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                    <span class="value"><span
                                            class="badge {{ $statusClass }}">{{ $count }}</span></span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-file-earmark-ruled"></i>
                    <div>
                        <span class="title-text">
                            Daftar Item Dokumen yang Diminta
                        </span>
                    </div>
                </h5>
            </div>

            <div class="table-responsive">
                <table class="table table-item-list">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dokumen</th>
                            <th>Jumlah</th>
                            <th>Supplier Transaksi</th>
                            <th>Harga Dasar</th>
                            <th>Harga Jual</th>
                            <th>Profit</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($service->documents as $item)
                            @php
                                // Logika Status Dinamis
                                $status = strtolower($item->status);
                                $statusClass = '';
                                if (in_array($status, ['done', 'deal'])) {
                                    $statusClass = 'badge-success';
                                } elseif (in_array($status, ['nego', 'tahap persiapan', 'tahap produksi'])) {
                                    $statusClass = 'badge-warning';
                                } elseif (in_array($status, ['cancelled', 'batal'])) {
                                    $statusClass = 'badge-danger';
                                } else {
                                    $statusClass = 'badge-primary';
                                }

                                // Logika Route Supplier Global (Dipertahankan)
                                $supplierRoute = $item->document_children_id
                                    ? route('visa.document.customer.detail.supplier', $item->document_children_id)
                                    : route('visa.document.supplier.parent', $item->document_id);

                                $hargaDasar = $item->harga_dasar ?? 0;
                                $hargaJual = $item->harga_jual ?? 0;
                                $profit = $hargaJual - $hargaDasar;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-align: left;">
                                    @if ($item->documentChild?->name)
                                        <span class="fw-bold">{{ $item->documentChild->name }}</span>
                                        <br><small class="text-muted">({{ $item->document?->name }})</small>
                                    @else
                                        <span class="fw-bold text-danger">{{ $item->document?->name ?? 'N/A' }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->supplier ?? '-' }}</td>
                                <td>
                                    <span class="text-danger">SAR {{ number_format($hargaDasar, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span class="text-primary">SAR {{ number_format($hargaJual, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span style="color: var(--success-color); font-weight: bold;">SAR
                                        {{ number_format($profit, 0, ',', '.') }}</span>
                                </td>

                                <td>
                                    <span class="badge {{ $statusClass }}">{{ $item->status }}</span>
                                </td>
                                <td>
                                    <div class="actions-container-list">
                                        <a href="{{ route('document.customer.edit', $item->id) }}"
                                            class="btn-action-icon text-warning" title="Edit Transaksi">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Tidak ada item dokumen terkait dengan layanan
                                    ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
