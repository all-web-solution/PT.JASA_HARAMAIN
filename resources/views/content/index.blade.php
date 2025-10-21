@extends('admin.master')
@section('title', 'Daftar Dokumen')
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
        }

        .service-list-container {
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

        .btn-add-new {
            background-color: var(--haramain-primary);
            color: #fff;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-add-new:hover {
            background-color: var(--haramain-secondary);
            box-shadow: 0 4px 12px rgba(42, 111, 219, 0.2);
        }

        /* Table Styles */
        .table-responsive {
            padding: 0 1rem 1rem 1rem;
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

        /* Actions Button Styling */
        .actions-container {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
    </style>
@endpush
@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-file-earmark-text-fill"></i>Daftar Dokumen
                </h5>
                <a href="{{ route('visa.document.create') }}" class="btn-add-new">
                    <i class="bi bi-plus-circle"></i> Tambah Dokumen
                </a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $doc)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $doc->name }}</td>
                                <td>
                                    <div class="actions-container">
                                        <a href="{{ route('visa.document.show', $doc->id) }}" class="btn btn-info btn-sm"
                                            title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('visa.document.edit', $doc->id) }}" class="btn btn-warning btn-sm"
                                            title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                       
                                        <form id="delete-form-{{ $doc->id }}"
                                            action="{{ route('visa.document.delete', $doc->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger btn-sm delete-confirm"
                                                data-id="{{ $doc->id }}" data-nama="{{ $doc->name }}"
                                                title="Hapus">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align:center; padding: 2rem;">
                                    Belum ada data dokumen yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent default form submission

                    const docId = this.getAttribute('data-id');
                    const docName = this.getAttribute('data-nama');
                    const formId = 'delete-form-' + docId;

                    Swal.fire({
                        title: 'Anda Yakin?',
                        html: `Anda akan menghapus dokumen: <strong>${docName}</strong>. Aksi ini tidak bisa dibatalkan!`,
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
