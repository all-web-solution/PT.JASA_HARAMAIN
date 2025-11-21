@extends('admin.master')
@section('title', 'Daftar Kendaraan (Master)')

@push('styles')
    <style>
        /* == STYLE VARIABLE == */
        :root {
            --haramain-primary: #1a4b8c;
            --haramain-secondary: #2a6fdb;
            --haramain-light: #e6f0fa;
            --haramain-accent: #3d8bfd;
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --border-color: #d1e0f5;
            --hover-bg: #f0f7ff;
            --danger-color: #dc3545;
        }

        .service-list-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f8fafd;
            min-height: 100vh;
        }

        /* == CARD & HEADER == */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            overflow: hidden;
            background-color: #fff;
        }

        .card-header {
            background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            /* Responsif: bungkus jika layar kecil */
            gap: 1rem;
        }

        .card-title {
            font-weight: 700;
            color: var(--haramain-primary);
            margin: 0;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            font-size: 1.5rem;
            color: var(--haramain-secondary);
        }

        /* == BUTTONS == */
        .btn-add-new {
            background-color: var(--haramain-secondary);
            color: white;
            border-radius: 8px;
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
        }

        .btn-add-new:hover {
            background-color: var(--haramain-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(26, 75, 140, 0.3);
        }

        /* == TABLE STYLE == */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            padding: 0 1.5rem 1.5rem;
            /* Padding kiri-kanan-bawah */
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            /* Jarak antar baris */
        }

        .table thead th {
            background-color: var(--haramain-light);
            color: var(--haramain-primary);
            font-weight: 600;
            padding: 1rem 1.25rem;
            text-align: center;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
        }

        .table tbody tr {
            background-color: white;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(42, 111, 219, 0.1);
        }

        .table tbody td {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            text-align: center;
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

        /* == ACTION BUTTONS == */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
            background-color: transparent;
            cursor: pointer;
        }

        .btn-action:hover {
            background-color: var(--haramain-light);
        }

        .btn-edit {
            color: var(--haramain-secondary);
        }

        .btn-delete {
            color: var(--danger-color);
        }

        .btn-action i {
            font-size: 1.1rem;
        }


        /* == RESPONSIVE (Mobile) == */
        @media (max-width: 768px) {
            .service-list-container {
                padding: 1rem;
            }

            .card-header {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-add-new {
                justify-content: center;
                width: 100%;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1.5rem;
                border: 1px solid var(--border-color);
                border-radius: 10px;
                padding: 0;
                /* Reset padding */
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                padding: 0.75rem 1rem;
                border: none;
                border-bottom: 1px solid var(--border-color);
            }

            .table tbody td:before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--haramain-primary);
                text-transform: capitalize;
                margin-right: 1rem;
                text-align: left;
            }

            .table tbody tr td:last-child {
                border-bottom: none;
            }

            .table tbody tr td:first-child,
            .table tbody tr td:last-child {
                border-radius: 0;
                /* Reset border radius di mobile */
            }

            .action-buttons {
                justify-content: flex-end;
            }
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">

        {{-- Alert Message (Opsional jika Anda menggunakannya) --}}
        @if (session('success'))
            <div class="alert alert-success mb-4"
                style="padding: 1rem; border-radius: 8px; background: rgba(40, 167, 69, 0.1); color: var(--success-color); border: 1px solid var(--success-color);">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-truck-front-fill"></i> Daftar Master Kendaraan
                </h5>
                <a href="{{ route('transportation.car.create') }}" class="btn-add-new">
                    <i class="bi bi-plus-circle"></i> Tambah Kendaraan
                </a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Nama</th>
                            <th style="width: 15%">Kapasitas</th>
                            <th style="width: 30%">Fasilitas</th>
                            <th style="width: 20%">Harga (Estimasi)</th>
                            <th style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($Transportations as $car)
                            <tr>
                                <td data-label="No">{{ $loop->iteration }}</td>
                                <td data-label="Nama" style="font-weight: 600; color: var(--text-primary);">
                                    {{ $car->nama }}
                                </td>
                                <td data-label="Kapasitas">
                                    <span class="badge bg-light text-dark border">{{ $car->kapasitas }} Penumpang</span>
                                </td>
                                <td data-label="Fasilitas" style="font-size: 0.9rem; color: var(--text-secondary);">
                                    {{ Str::limit($car->fasilitas, 50) }}
                                </td>
                                <td data-label="Harga">Rp {{ number_format($car->harga, 0, ',', '.') }}</td>
                                <td data-label="Aksi">
                                    <div class="action-buttons">
                                        <a href="{{ route('transportation.car.edit', $car->id) }}"
                                            class="btn-action btn-edit" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('transportation.car.delete', $car->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kendaraan ini? Data yang terhapus tidak dapat dikembalikan.')"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    Belum ada data kendaraan. Silakan tambahkan kendaraan baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination jika diperlukan (jika controller mengirimkan paginator) --}}
            @if ($Transportations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div
                    style="padding: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
                    {{ $Transportations->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
