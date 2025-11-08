@extends('admin.master')
@section('title', 'Daftar Karyawan')
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
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545
        }

        .service-list-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f8fafd
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / .05);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            overflow: hidden
        }

        .card-header {
            background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem
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

        .card-title i {
            font-size: 1.5rem;
            color: var(--haramain-secondary)
        }

        .table-responsive {
            padding: 0 1.5rem 1rem
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 .75rem
        }

        .table thead th {
            background-color: var(--haramain-light);
            color: var(--haramain-primary);
            font-weight: 600;
            padding: 1rem 1.25rem;
            border-bottom: 2px solid var(--border-color);
            text-align: center;
            vertical-align: middle
        }

        .table tbody tr {
            background-color: #fff;
            transition: all 0.3s ease;
            border-radius: 8px
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
            box-shadow: 0 4px 12px rgb(42 111 219 / .1)
        }

        .table tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color)
        }

        .table tbody td:first-child {
            border-left: 1px solid var(--border-color);
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px
        }

        .table tbody td:last-child {
            border-right: 1px solid var(--border-color);
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px
        }

        .customer-info {
            display: flex;
            align-items: center;
            gap: 1rem
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--haramain-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--haramain-secondary);
            font-size: 1.25rem;
            font-weight: 700;
            flex-shrink: 0
        }

        .customer-name {
            font-weight: 600;
            color: var(--haramain-primary)
        }

        .customer-type {
            font-size: .8rem;
            color: var(--text-secondary);
            display: block
        }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: .25rem
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
            background-color: #fff0;
            cursor: pointer
        }

        .btn-action:hover {
            background-color: var(--haramain-light)
        }

        .btn-action i {
            font-size: 1rem
        }

        .btn-edit {
            color: var(--haramain-secondary)
        }

        .btn-delete {
            color: var(--danger-color)
        }

        .search-filter-container {
            display: flex;
            justify-content: space-between;
            padding: 1.5rem;
            align-items: center;
            border-bottom: 1px solid var(--border-color)
        }

        .search-box {
            position: relative;
            width: 300px
        }

        .search-box input {
            padding-left: 2.5rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            height: 40px;
            width: 100%
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary)
        }

        .filter-select {
            height: 40px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 0 1rem;
            min-width: 150px
        }

        .btn-add-new {
            background-color: var(--haramain-secondary);
            color: #fff;
            border-radius: 8px;
            padding: .625rem 1.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none
        }

        .btn-add-new:hover {
            background-color: var(--haramain-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgb(26 75 140 / .3)
        }

        .pagination-container {
            display: flex;
            justify-content: flex-end;
            padding: 1.5rem;
            border-top: 1px solid var(--border-color)
        }

        .pagination .page-item.active .page-link {
            background-color: var(--haramain-secondary);
            border-color: var(--haramain-secondary)
        }

        .pagination .page-link {
            color: var(--haramain-primary);
            border-radius: 8px;
            margin: 0 .25rem;
            border: 1px solid var(--border-color)
        }

        @media (max-width:400px) {
            .card-header {
                padding: 1rem
            }

            .card-title {
                font-size: 1rem;
                text-align: center;
                width: 100%;
                justify-content: center
            }

            .btn-add-new {
                width: 100%;
                justify-content: center
            }

            .search-filter-container {
                flex-direction: column;
                padding: 1rem
            }

            .search-box {
                width: 100%
            }

            .filter-select {
                width: 100%
            }

            .table tbody td {
                font-size: .85rem;
                padding: .6rem .8rem;
                flex-direction: column;
                align-items: flex-start
            }

            .table tbody td:before {
                margin-bottom: .25rem;
                font-size: .8rem
            }
        }
    </style>
@endpush
@section('content')
    <div class="service-list-container">
        <!-- users List -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-people-fill"></i>Daftar Karyawan
                </h5>
                <a href="{{ route('user.create') }}" class="btn-add-new">
                    <i class="bi bi-plus-circle"></i> Tambah Karyawan
                </a>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter-container">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan nama, email, dll...">
                </div>
            </div>

            <!-- Users Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Karyawan</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @foreach ($users as $user)
                            <tr>
                                <td data-label="Karyawan">
                                    <div class="customer-info">
                                        <div class="customer-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                        <div class="customer-details">
                                            <span class="customer-name">{{ $user->name }}</span>
                                            <span class="customer-type">{{ $user->role }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Nama Lengkap">{{ $user->full_name }}</td>
                                <td data-label="Email">{{ $user->email }}</td>
                                <td data-label="Telepon">{{ $user->phone }}</td>
                                <td data-label="Alamat">{{ $user->address }}</td>
                                <td data-label="Aksi">
                                    <div class="action-buttons">
                                        <a href="/user/{{ $user->id }}/edit">
                                            <button class="btn-action btn-edit" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="post"
                                            class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Hapus">
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

            <!-- Pagination -->
            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $users->previousPageUrl() ?? '#' }}" tabindex="-1">&laquo;</a>
                        </li>

                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $users->nextPageUrl() ?? '#' }}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true
                });
            @endif
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('userTableBody');
            const rows = tableBody.getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    const rowText = row.textContent.toLowerCase();
                    row.style.display = rowText.includes(searchTerm) ? '' : 'none';
                }
            });

            const deleteForms = document.querySelectorAll('.form-delete');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data karyawan ini akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
