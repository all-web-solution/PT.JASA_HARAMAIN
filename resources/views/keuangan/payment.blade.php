@extends('admin.master')
@section('title', 'Order List')
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
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
        }

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

        /* ✅ Responsive Umum (Tablet) */
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
                padding: 0.5rem;
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem 1rem;
                border: none;
            }

            .table tbody td:before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--haramain-primary);
                margin-right: 1rem;
            }
        }

        /* ✅ Responsive untuk layar kecil (≤ 320px) */
        @media (max-width: 320px) {
            #filter{
                display: none;
            }
            .service-list-container {
                padding: 1rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 1rem;
            }

            .card-title {
                font-size: 1rem;
                gap: 6px;
            }

            .search-filter-container {
                padding: 1rem;
                flex-direction: column;
                gap: 0.75rem;
            }

            .search-box input {
                height: 36px;
                font-size: 0.85rem;
            }

            .filter-group {
                flex-direction: column;
                width: 100%;
            }

            .filter-select {
                width: 100%;
                font-size: 0.8rem;
                height: 36px;
            }

            .table-responsive {
                padding: 0.5rem;
                overflow-x: auto;
            }

            .table tbody tr {
                margin-bottom: 0.75rem;
            }

            .table tbody td {
                padding: 0.5rem;
                font-size: 0.8rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .table tbody td:before {
                font-size: 0.75rem;
                margin-bottom: 0.25rem;
            }

            .btn {
                font-size: 0.75rem;
                padding: 0.4rem 0.75rem;
            }

            .pagination-container {
                justify-content: center;
                padding: 0.75rem;
            }

            .pagination .page-link {
                font-size: 0.75rem;
                padding: 0.4rem 0.6rem;
            }
        }
    </style>

    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-list-check"></i> Daftar Pesanan
                </h5>
            </div>



            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Nama Pelanggan</th>

                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td data-label="Invoice">{{ $item->invoice }}</td>
                                <td data-label="Nama Pelanggan">{{ $item->service->pelanggan->nama_travel }}</td>
                                <td data-label="Aksi">
                                    <a href="{{ route('keuangan.payment.detail', $item->id) }}" class="btn btn-primary btn-sm">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection
