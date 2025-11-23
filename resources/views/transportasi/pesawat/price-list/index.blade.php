@extends('admin.master')
@section('title', 'Daftar Harga Tiket')

@push('styles')
    {{-- SweetAlert2 CSS (Jika belum ada di master layout) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
            min-height: 100vh;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #fff;
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
            flex-wrap: wrap;
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

        /* Button Add New */
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
            color: white;
        }

        /* Table Styles */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            padding: 0 1.5rem 1.5rem;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
            margin-bottom: 0;
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
            transform: translateY(-2px);
        }

        .table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
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

        /* Badge */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        /* Action Buttons */
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

        .btn-action i {
            font-size: 1.1rem;
        }

        .btn-edit {
            color: var(--haramain-secondary);
        }

        .btn-delete {
            color: var(--danger-color);
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: flex-end;
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .service-list-container {
                padding: 1rem;
            }

            .card-header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .btn-add-new {
                width: 100%;
                justify-content: center;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 8px;
                border: 1px solid var(--border-color);
                padding: 0;
                overflow: hidden;
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                border: none;
                border-bottom: 1px solid var(--border-color);
                text-align: right;
            }

            .table tbody tr td:last-child {
                border-bottom: none;
            }

            .table tbody td:before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--haramain-primary);
                margin-right: 1rem;
                text-align: left;
            }

            .table tbody tr td:first-child,
            .table tbody tr td:last-child {
                border-radius: 0;
            }

            .action-buttons {
                justify-content: flex-end;
            }

            .pagination-container {
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">

        {{-- Alert Message (Optional) --}}
        @if (session('success'))
            <div class="alert alert-success mb-4"
                style="border-radius: 8px; background-color: rgba(40, 167, 69, 0.1); color: var(--success-color); border: 1px solid var(--success-color);">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-tags-fill"></i> Daftar Harga Tiket
                </h5>
                <a href="{{ route('price.list.ticket.create') }}" class="btn-add-new">
                    <i class="bi bi-plus-lg"></i> Tambah Price List
                </a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Berangkat</th>
                            <th>Jam Berangkat</th>
                            <th>Kelas</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($tickets->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data"
                                        style="height: 150px; opacity: 0.6;">
                                    <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Tiket</h5>
                                    <p class="text-muted">Silakan tambahkan data harga tiket baru.</p>
                                </td>
                            </tr>
                        @else
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td data-label="No">
                                        {{ $loop->iteration + ($tickets->currentPage() - 1) * $tickets->perPage() }}</td>
                                    <td data-label="Tanggal Berangkat">
                                        {{ \Carbon\Carbon::parse($ticket->tanggal)->isoFormat('D MMMM Y') }}</td>
                                    <td data-label="Jam Berangkat">
                                        {{ \Carbon\Carbon::parse($ticket->jam_berangkat)->format('H:i') }}</td>
                                    <td data-label="Kelas">
                                        <span class="badge bg-info text-dark">{{ $ticket->kelas }}</span>
                                    </td>
                                    <td data-label="Harga" style="font-weight: 600; color: var(--haramain-primary);">
                                        Rp {{ number_format($ticket->harga, 0, ',', '.') }}
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="action-buttons">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('price.list.ticket.edit', $ticket->id) }}"
                                                class="btn-action btn-edit" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- Form Delete dengan SweetAlert --}}
                                            <form action="{{ route('price.list.ticket.delete', $ticket->id) }}"
                                                method="POST" class="d-inline form-delete" data-id="{{ $ticket->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-action btn-delete btn-delete-trigger"
                                                    title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event Delegation untuk tombol delete
            const deleteButtons = document.querySelectorAll('.btn-delete-trigger');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah submit langsung

                    const form = this.closest('.form-delete'); // Ambil form terdekat

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data tiket ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545', // Merah untuk hapus
                        cancelButtonColor: '#6c757d', // Abu-abu untuk batal
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true // Tombol hapus di kanan (opsional)
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit form jika user klik 'Ya'
                        }
                    });
                });
            });
        });
    </script>
@endpush
