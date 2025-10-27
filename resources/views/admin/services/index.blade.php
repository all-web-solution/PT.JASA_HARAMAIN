@extends('admin.master')
@section('content')
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
            text-align: center;
            align-content: center;
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
            text-align: center;
            align-content: center;
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

        /* Status Badge */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .badge i {
            font-size: 0.8rem;
        }

        .badge-primary {
            background-color: var(--haramain-light);
            color: var(--haramain-secondary);
        }

        .badge-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .badge-warning {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }

        .badge-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }

        /* Customer/Travel Info */
        .customer-info {
            display: flex;
            align-items: center;
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--haramain-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--haramain-secondary);
            font-size: 1.25rem;
        }

        .customer-details {
            line-height: 1.4;
        }

        .customer-name {
            font-weight: 600;
            color: var(--haramain-primary);
        }

        .customer-type {
            font-size: 0.75rem;
            color: var(--text-secondary);
            background-color: var(--haramain-light);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
        }

        /* Date Info */
        .date-info {
            display: flex;
            flex-direction: column;
        }

        .date-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .date-value {
            font-weight: 600;
            color: var(--haramain-primary);
        }

        /* Action Buttons */
        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            border: none;
            background-color: transparent;
            cursor: pointer;
        }

        .btn-action:hover {
            background-color: var(--haramain-light);
        }

        .btn-action i {
            font-size: 1rem;
        }

        .btn-upload {
            color: var(--haramain-secondary);
        }

        .btn-view {
            color: var(--text-primary);
        }

        .btn-view {
            color: var(--text-primary);
        }

        /* Search and Filter */
        .search-filter-container {
            display: flex;
            justify-content: space-between;
            padding: 1.5rem;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            padding-left: 2.5rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            height: 40px;
            width: 100%;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .filter-group {
            display: flex;
            gap: 1rem;
        }

        .filter-select {
            height: 40px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 0 1rem;
            min-width: 150px;
        }

        /* Add New Button */
        .btn-add-new {
            background-color: var(--haramain-secondary);
            color: white;
            border-radius: 8px;
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            display: flex;
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

        /* Pagination */
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .search-filter-container {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .search-box {
                width: 100%;
            }

            .filter-group {
                width: 100%;
                flex-wrap: wrap;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                border: none;
                border-radius: 0;
            }

            .table tbody td:before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--haramain-primary);
                margin-right: 1rem;
            }

            .table tbody td:first-child {
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }

            .table tbody td:last-child {
                border-bottom-left-radius: 8px;
                border-bottom-right-radius: 8px;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .service-list-container {
                padding: 1rem;
            }

            .card-header,
            .search-filter-container {
                flex-direction: column;
                align-items: stretch;
                /* Ubah dari flex-start */
                gap: 1rem;
            }

            .card-title {
                font-size: 1.1rem;
                text-align: center;
                justify-content: center;
            }

            .btn-add-new {
                width: 100%;
                /* Tombol memenuhi lebar */
                justify-content: center;
            }

            .search-box {
                width: 100%;
            }

            .filter-group {
                width: 100%;
                flex-wrap: wrap;
            }

            .filter-select {
                width: 100%;
                /* Filter memenuhi lebar */
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1.5rem;
                /* Beri jarak lebih antar baris/kartu */
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                border: 1px solid var(--border-color);
            }

            .table tbody td {
                display: flex;
                flex-direction: column;
                /* Susun label di atas, nilai di bawah */
                align-items: flex-start;
                /* Rata kiri */
                justify-content: center;
                text-align: left;
                padding: 0.75rem 1rem;
                border: none;
                border-bottom: 1px solid var(--border-color);
                /* Garis pemisah antar field */
            }

            .table tbody tr td:last-child {
                border-bottom: none;
                /* Hilangkan border untuk item terakhir */
            }

            .table tbody td:before {
                content: attr(data-label);
                font-weight: 700;
                /* Dibuat tebal agar jelas */
                color: var(--haramain-primary);
                margin-bottom: 0.5rem;
                /* Jarak antara label dan nilai */
                font-size: 0.8rem;
                text-transform: uppercase;
            }

            .table tbody td:first-child {
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }

            .table tbody td:last-child {
                border-bottom-left-radius: 8px;
                border-bottom-right-radius: 8px;
            }

            /* Styling khusus untuk container tombol aksi */
            .action-buttons-container {
                display: flex;
                flex-wrap: wrap;
                /* Tombol akan turun jika tidak muat */
                gap: 0.5rem;
                /* Jarak antar tombol */
                width: 100%;
            }

            .action-buttons-container .btn {
                flex-grow: 1;
                /* Tombol akan membesar mengisi ruang */
            }

            .pagination-container {
                justify-content: center;
                /* Paginasi di tengah */
            }
        }
    </style>

    <div class="service-list-container">
        <div class="row g-3 mb-4 p-1"> {{-- Assuming you use a Bootstrap row --}}
            <x-card-component class="col-xl-3 col-md-6" title="Total Nego" :count="$totalNegoOverall" {{-- Use variable from controller --}}
                icon="bi bi-hourglass-split" {{-- Example icon --}} iconColor="var(--haramain-primary)" textColor="text-primary"
                desc="Menunggu konfirmasi" />
            <x-card-component class="col-xl-3 col-md-6" title="Persiapan" :count="$totalPersiapanOverall" {{-- Use variable from controller --}}
                icon="bi bi-box-seam" {{-- Example icon --}} iconColor="var(--haramain-primary)" textColor="text-primary"
                desc="Sedang dipersiapkan" />
            <x-card-component class="col-xl-3 col-md-6" title="Tahap Produksi" :count="$totalProduksiOverall" {{-- Use variable from controller --}}
                icon="bi bi-gear-fill" {{-- Example icon --}} iconColor="var(--haramain-primary)" textColor="text-primary"
                desc="Sedang dikerjakan" />
            <x-card-component class="col-xl-3 col-md-6" title="Selesai (Done)" :count="$totalDoneOverall" {{-- Use variable from controller --}}
                icon="bi bi-check2-circle" {{-- Example icon --}} iconColor="var(--haramain-primary)"
                textColor="text-primary" desc="Layanan telah selesai" />
        </div>

        <!-- Services List -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title" id="text-title">
                    <i class="bi bi-list-check"></i>Daftar Permintaan Services
                </h5>
                <a href="{{ route('services.create') }}" class="btn-add-new">
                    <i class="bi bi-plus-circle"></i> Tambah Permintaan
                </a>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter-container">
                {{-- Ganti SELURUH <div class="filter-group"> lama dengan ini --}}
                <div class="filter-group">
                    <form method="GET" action="{{ route('admin.services') }}" id="searchFilterForm"
                        class="d-flex flex-grow-1 gap-2">
                        {{-- Kotak Pencarian --}}
                        <div class="search-box flex-grow-1 position-relative">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" name="search" id="searchInput" class="form-control ps-5"
                                placeholder="Cari customer/Jenis layanan..." value="{{ request('search') }}">
                        </div>
                    </form> {{-- Akhir dari form UTAMA --}}
                </div>
            </div>

            <!-- Services Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>Tanggal Keberangkatan</th>
                            <th>Tanggal Kepulangan</th>
                            <th>Jumlah Jamaah</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @foreach ($services as $service)
                            <tr>
                                <td data-label="Kode unik">{{ $service->unique_code }}</td>
                                <td data-label="Customer/Travel">{{ $service->pelanggan->nama_travel }}</td>
                                <td data-label="Tgl keberangkatan">{{ $service->tanggal_keberangkatan }}</td>
                                <td data-label="Tgl kepulangan">{{ $service->tanggal_kepulangan }}</td>
                                <td data-label="Jumlah jamaah">{{ $service->total_jamaah }}</td>
                                <td data-label="Layanan yang di pilih">{{ implode(', ', (array) $service->services) }}
                                </td>

                                @if ($service->status === 'nego')
                                    <td data-label="Status">
                                        <a href="{{ route('admin.service.nego', $service->id) }}">
                                            <button class="btn btn-warning"
                                                style="width: 100%; white-space: normal;">Lanjutkan pemesanan</button>
                                        </a>
                                    </td>
                                @else
                                    <td data-label="Status">Deal</td>
                                @endif

                                <td data-label="Aksi">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.service.file', $service->id) }}">
                                            <button class="btn-action btn-upload" title="Upload berkas yang di perlukan">
                                                <i class="bi bi-cloud-arrow-up"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('admin.services.show', $service->id) }}">
                                            <button class="btn-action btn-view" title="view">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </a>
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
                        {{-- Previous Page Link --}}
                        <li class="page-item {{ $services->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $services->previousPageUrl() ?? '#' }}"
                                tabindex="-1">&laquo;</a>
                        </li>

                        {{-- Page Number Links --}}
                        @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                            <li class="page-item {{ $services->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        <li class="page-item {{ !$services->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $services->nextPageUrl() ?? '#' }}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Improved Search Functionality
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('userTableBody');
            const rows = tableBody.getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    // Get all text content from the row, not just specific cells
                    const rowText = row.textContent.toLowerCase();

                    if (rowText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Delete confirmation
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Apakah Anda yakin ingin menghapus permintaan service ini?')) {
                        // Here you would typically send a delete request to your backend
                        const row = this.closest('tr');
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.remove();
                            alert('Permintaan service berhasil dihapus!');
                        }, 300);
                    }
                });
            });
        });
    </script>
@endsection
