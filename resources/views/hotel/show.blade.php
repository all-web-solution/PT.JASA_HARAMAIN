@extends('admin.master')
@section('title', 'Detail Permintaan Hotel Layanan')

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
            --primary-bg: var(--haramain-light)
        }

        .service-list-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--background-light);
            min-height: 100vh
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / .05);
            border: 1px solid var(--border-color);
            background-color: #fff;
            overflow: hidden;
            margin-bottom: 2rem
        }

        .card-header {
            background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between
        }

        .card-title {
            font-weight: 700;
            color: var(--haramain-primary);
            margin: 0;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 12px
        }

        .card-title .title-text {
            font-weight: 600;
            color: var(--haramain-primary)
        }

        .card-title i {
            font-size: 1.5rem;
            color: var(--haramain-secondary)
        }

        .card-body {
            padding: 1.5rem
        }

        .btn-action,
        .btn-secondary {
            background-color: var(--haramain-secondary);
            color: #fff;
            border-radius: 8px;
            padding: .625rem 1.25rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            font-size: .9rem
        }

        .btn-secondary {
            background-color: #fff;
            color: var(--text-secondary);
            border: 1px solid var(--border-color)
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem
        }

        .info-card {
            background-color: #fff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem
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
            border-bottom: 1px solid var(--border-color)
        }

        .info-card-title i {
            color: var(--haramain-secondary)
        }

        .info-card .content {
            display: flex;
            flex-direction: column;
            gap: 1rem
        }

        .info-item .label {
            font-size: .8rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: .25rem
        }

        .info-item .value {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1rem
        }

        .item-list-table-container {
            padding: 0 1.5rem 1.5rem
        }

        .table-item-list {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 .75rem
        }

        .table-item-list thead th {
            background-color: var(--haramain-light);
            color: var(--haramain-primary);
            font-weight: 600;
            padding: 1rem 1.25rem;
            text-align: center;
            white-space: nowrap
        }

        .table-item-list tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            text-align: center;
            background-color: #fff;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color)
        }

        .table-item-list tbody tr:hover {
            background-color: var(--hover-bg);
            box-shadow: 0 4px 12px rgb(42 111 219 / .1)
        }

        .actions-container-list {
            display: flex;
            justify-content: center;
            gap: .5rem
        }

        .btn-action-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            transition: all 0.3s ease;
            border: none;
            background-color: #fff0;
            color: var(--text-secondary)
        }

        .btn-action-icon:hover {
            background-color: var(--haramain-light);
            color: var(--haramain-secondary)
        }

        .text-info {
            color: var(--haramain-secondary)
        }

        .text-warning {
            color: var(--warning-color)
        }

        .text-danger {
            color: var(--danger-color)
        }

        .badge {
            padding: .5rem .75rem;
            font-weight: 700;
            font-size: .8rem;
            text-transform: capitalize
        }

        .badge-success {
            background-color: var(--success-bg);
            color: var(--success-color)
        }

        .badge-primary {
            background-color: var(--primary-bg);
            color: var(--text-primary);
        }

        .badge-warning {
            background-color: var(--warning-bg);
            color: var(--warning-color)
        }

        .badge-danger {
            background-color: var(--danger-bg);
            color: var(--danger-color)
        }

        @media (max-width:768px) {
            .stats-grid {
                grid-template-columns: 1fr
            }
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
                            Detail Permintaan Hotel (Service ID: {{ $service->unique_code ?? 'N/A' }})
                        </span>
                    </div>
                </h5>
                <div>
                    <a href="{{ route('hotel.index') }}" class="btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali ke Daftar Layanan
                    </a>
                </div>
            </div>

            <div class="card-body">
                @php
                    $pelanggan = $service->pelanggan;
                    $totalItems = $service->hotels->count();
                    $doneStatuses = ['done', 'deal'];
                    $doneItems = $service->hotels->whereIn('status', $doneStatuses)->count();
                    $progressPercentage = $totalItems > 0 ? round(($doneItems / $totalItems) * 100) : 0;

                    $totalCost = $service->hotels->sum('harga_dasar');
                    $totalSale = $service->hotels->sum('harga_jual');
                    $totalProfit = $totalSale - $totalCost;
                @endphp

                <div class="stats-grid">

                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-person-badge"></i> Info Pelanggan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Nama Travel</span>
                                <span class="value">{{ $pelanggan->nama_travel ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Penanggung Jawab</span>
                                <span class="value">{{ $pelanggan->penanggung_jawab ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">No. Telepon</span>
                                <span class="value">{{ $pelanggan->phone ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-calendar-event"></i> Info Layanan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Tanggal Keberangkatan</span>
                                <span
                                    class="value">{{ \Carbon\Carbon::parse($service->tanggal_keberangkatan)->isoFormat('D MMM YYYY') ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Total Jamaah</span>
                                <span class="value">{{ $service->total_jamaah ?? 0 }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Total Item Hotel</span>
                                <span class="value">{{ $totalItems }} Item</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-bar-chart"></i> Ringkasan Progres</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Item Selesai / Total</span>
                                <span class="value text-success fw-bold">{{ $doneItems }} / {{ $totalItems }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Progres Penyelesaian</span>
                                <span class="value text-primary">{{ $progressPercentage }}%</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Total Profit Estimasi</span>
                                <span class="value" style="color: var(--success-color);">Rp
                                    {{ number_format($totalProfit, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-list-nested"></i>
                    <span class="title-text">Daftar Item Hotel ({!! $service->unique_code !!})</span>
                </h5>
            </div>

            <div class="item-list-table-container">
                @if ($service->hotels->isEmpty())
                    <p style="text-align: center; color: var(--text-secondary); padding: 1rem;">
                        Tidak ada item hotel yang terdaftar dalam layanan ini.
                    </p>
                @else
                    <table class="table table-item-list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="text-align: left;">Nama Hotel & Tipe</th>
                                <th>Check-in / Check-out</th>
                                <th>Harga Dasar</th>
                                <th>Harga Jual</th>
                                <th>Profit</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($service->hotels as $item)
                                @php
                                    $status = strtolower($item->status);
                                    $statusClass = '';
                                    if (in_array($status, ['done', 'deal'])) {
                                        $statusClass = 'badge-success';
                                    } elseif (in_array($status, ['tahap persiapan', 'nego'])) {
                                        $statusClass = 'badge-warning';
                                    } elseif (in_array($status, ['cancelled', 'batal'])) {
                                        $statusClass = 'badge-danger';
                                    } elseif (in_array($status, ['tahap produksi', 'prepare'])) {
                                        $statusClass = 'badge-primary';
                                    }

                                    $hargaDasar = $item->harga_dasar ?? 0;
                                    $hargaJual = $item->harga_jual ?? 0;
                                    $profit = $hargaJual - $hargaDasar;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-align: left;">
                                        <span class="fw-bold">{{ $item->nama_hotel ?? '-' }}</span>
                                        <br>
                                        <small class="text-muted">{{ $item->type ?? 'N/A' }}
                                            ({{ $item->jumlah_type ?? $item->jumlah_kamar }} Kamar)
                                        </small>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->tanggal_checkin)->isoFormat('D MMM') }} -
                                        {{ \Carbon\Carbon::parse($item->tanggal_checkout)->isoFormat('D MMM YYYY') }}
                                        <br>
                                        <small
                                            class="text-muted">({{ \Carbon\Carbon::parse($item->tanggal_checkin)->diffInDays($item->tanggal_checkout) }}
                                            Malam)</small>
                                    </td>
                                    <td>
                                        <span class="text-danger">Rp {{ number_format($hargaDasar, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <span class="text-primary">Rp {{ number_format($hargaJual, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <span style="color: var(--success-color); font-weight: bold;">Rp
                                            {{ number_format($profit, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $statusClass }}">{{ $item->status }}</span>
                                    </td>
                                    <td>
                                        <div class="actions-container-list">
                                            <a href="{{ route('hotel.edit', $item->id) }}"
                                                class="btn-action-icon text-warning" title="Edit Supplier/Harga/Status">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false,
                timerProgressBar: true
            });
        @endif
    </script>
@endpush
