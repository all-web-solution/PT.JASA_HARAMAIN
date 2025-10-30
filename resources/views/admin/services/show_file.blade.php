@extends('admin.master')
@section('title', 'Daftar Berkas Customer')
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
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            border: none;
            background-color: transparent;
        }

        .btn-action:hover {
            background-color: var(--haramain-light);
        }

        .btn-action i {
            font-size: 1rem;
        }

        .btn-edit {
            color: var(--haramain-secondary);
        }

        .btn-delete {
            color: var(--danger-color);
        }

        .btn-view {
            color: var(--text-secondary);
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
@endpush
@section('content')
    <div class="service-list-container">
        <!-- Services List -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title" id="text-title">
                    <i class="bi bi-list-check"></i>Daftar berkas {{ $service->pelanggan->nama_travel }}
                </h5>
                <a href="{{ route('service.uploadBerkas', $service->id) }}" class="btn-add-new ">
                    <i class="bi bi-plus-circle"></i> Tambah berkas
                </a>
            </div>

            <!-- Services Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>Nama penganggung jawab</th>
                            <th>Nomor telepon</th>
                            <th>Pas foto</th>
                            <th>Paspor</th>
                            <th>KTP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($files as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->service->pelanggan->nama_travel }}</td>
                                <td>{{ $item->service->pelanggan->penanggung_jawab }}</td>
                                <td>{{ $item->service->pelanggan->phone }}</td>
                                <td>
                                    <a href="{{ url('storage/' . $item->pas_foto) }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ url('storage/' . $item->pas_foto) }}" alt="Pas Foto" width="50px"
                                            height="50px">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('storage/' . $item->paspor) }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ url('storage/' . $item->paspor) }}" alt="Paspor" width="50px"
                                            height="50px">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('storage/' . $item->ktp) }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ url('storage/' . $item->ktp) }}" alt="KTP" width="50px"
                                            height="50px">
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data berkas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
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

                        /*
                        fetch('/services/' + serviceId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                row.remove();
                                alert('Permintaan service berhasil dihapus!');
                            }
                        });
                        */
                    }
                });
            });

            // Search functionality
            const searchInput = document.querySelector('.search-box input');
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const customerName = row.querySelector('td:first-child .customer-name')
                            .textContent.toLowerCase();
                        const serviceCode = row.querySelector('td:nth-child(2)').textContent
                            .toLowerCase();

                        if (customerName.includes(searchTerm) || serviceCode.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
            });
        });
    </script>
@endsection
