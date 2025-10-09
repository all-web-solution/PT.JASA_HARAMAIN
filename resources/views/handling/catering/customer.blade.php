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
            --background-light: #f8fafd;
            --success-bg: #e9f7ec;
            --success-text: #28a745;
            --warning-bg: #fff8e1;
            --warning-text: #ffc107;
            --danger-bg: #fbe9e9;
            --danger-text: #dc3545;
        }

        .customer-meal-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--background-light);
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
            padding: 2rem;
        }

        .filter-container {
            margin-bottom: 1.5rem;
        }

        .filter-container .form-control {
            border-radius: 8px;
            border-color: var(--border-color);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .filter-container .form-control:focus {
            border-color: var(--haramain-accent);
            box-shadow: 0 0 0 3px rgba(61, 139, 253, 0.2);
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
            margin-top: -0.75rem;
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

        .table tbody tr {
            background-color: white;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
            box-shadow: 0 4px 12px rgba(42, 111, 219, 0.1);
            transform: translateY(-2px);
        }

        .table tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            border: 1px solid transparent;
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

        /* Status Badge */
        .status-badge {
            padding: 0.3em 0.8em;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.8rem;
            white-space: nowrap;
        }

        .status-selesai {
            background-color: var(--success-bg);
            color: var(--success-text);
        }

        .status-proses {
            background-color: var(--warning-bg);
            color: #b98900;
        }

        .status-cancel {
            background-color: var(--danger-bg);
            color: var(--danger-text);
        }
    </style>
@endpush

@section('content')
    <div class="customer-meal-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-people-fill"></i> Daftar Pesanan Customer
                </h5>
                <a href="{{ route('catering.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <div class="filter-container">
                    <form method="GET" action="{{ route('catering.customer') }}">
                        <div class="d-flex">
                            <select name="status" class="form-control" style="max-width: 250px;"
                                onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="proses" {{ request()->get('status') == 'proses' ? 'selected' : '' }}>Proses
                                </option>
                                <option value="cancel" {{ request()->get('status') == 'cancel' ? 'selected' : '' }}>Cancel
                                </option>
                                <option value="selesai" {{ request()->get('status') == 'selesai' ? 'selected' : '' }}>
                                    Selesai</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Customer</th>
                                <th>Nama Menu</th>
                                {{-- <th>Harga</th> --}}
                                <th>Jumlah</th>
                                {{-- <th>Total Harga</th> --}}
                                <th>PJ</th>
                                <th>Status</th>
                                <th>Tanggal Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customerMeal as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->service->pelanggan->nama_travel }}</td>
                                    <td>{{ $item->mealItem->name }}</td>
                                    {{-- <td>Rp {{ number_format($item->mealItem->price, 0, ',', '.') }}</td> --}}
                                    <td>{{ $item->jumlah }}</td>
                                    {{-- <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td> --}}
                                    <td>{{ $item->pj }}</td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($item->status) }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('catering.show', $item->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" style="text-align:center; padding: 2rem;">
                                        Tidak ada data pesanan yang ditemukan.
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
