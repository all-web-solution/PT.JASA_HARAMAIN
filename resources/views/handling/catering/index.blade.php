@extends('admin.master')
@section('title', 'Daftar Makanan')
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
            --checked-color: #2a6fdb;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        .service-list-container {
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

        .card-body {
            padding: 2rem;
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

        /* Table Styles */
        .table-responsive {
            padding: 0 1.5rem;
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
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody td:first-child {
            border-left: 1px solid var(--border-color);
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .table tbody td:last-child {
            border-right: 1px solid var(--border-color);
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* Actions Button Styling */
        .actions-container {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .actions-container .btn {
            padding: 0.375rem 0.75rem;
        }

        .pagination-container {
            display: flex;
            justify-content: flex-end;
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--haramain-secondary);
            border-color: var(--haramain-secondary);
        }

        .pagination .page-link {
            color: var(--haramain-primary);
            border-radius: 8px;
            margin: 0 0.25rem;
            border: 1px solid var(--border-color);
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-list-check"></i>Daftar Menu Makanan
                </h5>
                <a href="{{ route('catering.create') }}">
                    <button class="btn btn-success">Tambah Menu Makanan</button>
                </a>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Menu</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($meals as $meal)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $meal->name }}</td>
                                    <td>{{ $meal->price }}</td>

                                    <td>
                                        <div class="actions-container">
                                            <a href="{{ route('catering.edit', $meal->id) }}" class="btn btn-warning btn-sm"
                                                title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form id="delete-form-{{ $meal->id }}"
                                                action="{{ route('catering.delete', $meal->id) }}" method="post"
                                                style="display:inline-block">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-danger btn-sm delete-confirm"
                                                    data-id="{{ $meal->id }}"
                                                    data-nama-menu="{{ $meal->mealItem->name ?? 'Menu Ini' }}"
                                                    title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-confirm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const mealId = this.getAttribute('data-id');
                    const mealName = this.getAttribute('data-nama-menu');
                    const formId = 'delete-form-' + mealId;

                    Swal.fire({
                        title: 'Yakin Ingin Menghapus?',
                        html: `Anda akan menghapus menu: <strong>${mealName}</strong>. Aksi ini tidak bisa dibatalkan!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(formId).submit();
                        }
                    });
                });
            });

            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });
    </script>
@endpush
