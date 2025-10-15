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
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        .customer-list-container {
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
            /* Allows wrapping on small screens */
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

        /* Table Styles */
        .table-responsive {
            max-width: 72vw;
            padding: 0 1.5rem 1rem;
            /* Adjusted padding */
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
            vertical-align: middle;
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

        /* Customer/Travel Info */
        .customer-info {
            display: flex;
            align-items: center;
            gap: 1rem;
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
            font-weight: bold;
            flex-shrink: 0;
        }

        .customer-name {
            font-weight: 600;
            color: var(--haramain-primary);
        }

        .customer-type {
            font-size: 0.8rem;
            color: var(--text-secondary);
            display: block;
            /* Ensures it goes to the next line */
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            align-items: center;
            gap: 0.25rem;
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
            font-size: 1rem;
        }

        .btn-edit {
            color: var(--haramain-secondary);
        }

        .btn-delete {
            color: var(--danger-color);
        }

        /* Search and Filter */
        .filter-container {
            display: flex;
            justify-content: left;
            padding: 1.5rem;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            gap: 0.5rem;
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            /* For <a> tag */
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
        /* Tambahan untuk HP kecil (320px - 400px) */
        @media (max-width: 400px) {
            .card-header {
                padding: 1rem;
            }

            .card-title {
                font-size: 1rem;
                text-align: center;
                width: 100%;
                justify-content: center;
            }

            .btn-add-new {
                width: 100%;
                justify-content: center;
            }

            .filter-container {
                flex-direction: column;
                padding: 1rem;
            }

            .search-box {
                width: 100%;
            }

            .filter-group {
                width: 100%;
                flex-direction: column;
            }

            .filter-select {
                width: 100%;
            }

            .table tbody td {
                font-size: 0.85rem;
                padding: 0.6rem 0.8rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .table tbody td:before {
                margin-bottom: 0.25rem;
                font-size: 0.8rem;
            }
        }
    </style>

    <div class="customer-list-container">
        <!-- Stats Cards -->
        <div class="row g-3 mb-4 p-1" id="cards-dashboard">
            <!-- Total Travel -->
            <x-card-component title="Total Travel" :count="\App\Models\Pelanggan::count()" icon="bi bi-building" iconColor="var(--haramain-primary)"
                textColor="var(--text-muted)" desc="Semua travel terdaftar" />

            <!-- Travel Aktif -->
            <x-card-component title="Travel Aktif" :count="$pelangganAktif" icon="bi bi-check-circle"
                iconColor="var(--haramain-primary)" textColor="{{ $totalPelanggan > 0 ? 'text-success' : 'text-muted' }}"
                desc="{{ round(($pelangganAktif / $totalPelanggan) * 100) }}% dari total" />

            <!-- Travel Non-Aktif -->
            <x-card-component title="Travel Non-Aktif" :count="$pelangganNonAktif" icon="bi bi-x-circle"
                iconColor="var(--haramain-primary)" textColor="{{ $totalPelanggan > 0 ? 'text-success' : 'text-muted' }}"
                desc="{{ round(($pelangganNonAktif / $totalPelanggan) * 100) }}% dari total" />

            <!-- Penambahan Bulan Ini -->
            <x-card-component title="Kenaikan Bulan ini" :count="$pelangganBulanIni" icon="bi bi-graph-up"
                iconColor="var(--haramain-primary)" textColor="{{ $totalPelanggan > 0 ? 'text-success' : 'text-muted' }}"
                desc="{{ $pelangganBulanIni }} travel baru" />
        </div>

        <!-- Customers List -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-people-fill"></i>Daftar Pelanggan
                </h5>
                <a href="{{ route('admin.pelanggan.create') }}" class="btn-add-new">
                    <i class="bi bi-plus-circle"></i> Tambah Pelanggan Baru
                </a>
            </div>

            <!-- Services Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Travel</th>
                            <th>Penanggung Jawab</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Terdaftar</th>
                            <th>Total Transaksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @if ($pelanggans->isEmpty())
                            <div class="text-center py-5">
                                <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data"
                                    style="height: 150px;">
                                <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Travel</h5>
                                <p class="text-muted">Mulai dengan menambahkan travel pertama Anda</p>
                            </div>
                        @else
                            @foreach ($pelanggans as $pelanggan)
                                <tr href="{{ route('admin.pelanggan.show', $pelanggan->id) }}">
                                    <td data-label="ID">#ID{{ str_pad($pelanggan->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td data-label="Travel">
                                        <div class="d-flex align-items-center">
                                            @if ($pelanggan->foto)
                                                <img src="{{ url('storage/' . $pelanggan->foto) }}"
                                                    class="rounded-circle me-2" width="32" height="32">
                                            @else
                                                <div class="me-2"
                                                    style="width:32px; height:32px; background:#e3f2fd; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                                    <i class="bi bi-building"
                                                        style="color: var(--haramain-secondary); font-size:.875rem;"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('admin.pelanggan.show', $pelanggan->id) }}"
                                                    class="fw-semibold d-block text-decoration-none text-dark">
                                                    {{ $pelanggan->nama_travel }}
                                                </a>
                                                <div class="text-muted small">{{ $pelanggan->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Penanggung Jawab">
                                        {{ $pelanggan->penanggung_jawab }} <br>
                                        <small class="text-muted">KTP:{{ $pelanggan->no_ktp }}</small>
                                    </td>
                                    <td data-label="Telepon">
                                        {{ $pelanggan->phone ?? '-' }} <br>
                                        <small class="text-muted">{{ Str::limit($pelanggan->alamat, 20) }}</small>
                                    </td>
                                    <td data-label="Status">
                                        <span
                                            class="badge {{ $pelanggan->status == 'active' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">
                                            {{ $pelanggan->status == 'active' ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td data-label="Terdaftar">
                                        {{ $pelanggan->created_at->format('d M Y') }} <br>
                                        <small class="text-muted">{{ $pelanggan->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td data-label="Total Transaksi" class="text-center">
                                        {{ $pelanggan->services->flatMap->orders->count() }}
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}">
                                                <button class="btn-action btn-edit" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </a>
                                            <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}"
                                                method="post"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
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
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
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

            // Note: The delete confirmation is now handled by the 'onsubmit' attribute
            // in the HTML form for simplicity and reliability. No extra JS is needed for that.
        });
    </script>

    {{-- <div class="container-fluid p-4">
        <!-- Stats Cards -->
        <div class="row g-3 mb-4" id="cards-dashboard">
            <!-- Total Travel -->
            <x-card-component title="Total Travel" :count="\App\Models\Pelanggan::count()" icon="bi bi-building"
                iconColor="var(--haramain-primary)" textColor="var(--text-muted)" desc="Semua travel terdaftar" />

            <!-- Travel Aktif -->
            <x-card-component title="Travel Aktif" :count="$pelangganAktif" icon="bi bi-check-circle"
                iconColor="var(--haramain-primary)" textColor="{{ $totalPelanggan > 0 ? 'text-success' : 'text-muted' }}"
                desc="{{ round(($pelangganAktif / $totalPelanggan) * 100) }}% dari total" />

            <!-- Travel Non-Aktif -->
            <x-card-component title="Travel Non-Aktif" :count="$pelangganNonAktif" icon="bi bi-x-circle"
                iconColor="var(--haramain-primary)" textColor="{{ $totalPelanggan > 0 ? 'text-success' : 'text-muted' }}"
                desc="{{ round(($pelangganNonAktif / $totalPelanggan) * 100) }}% dari total" />

            <!-- Penambahan Bulan Ini -->
            <x-card-component title="Kenaikan Bulan ini" :count="$pelangganBulanIni" icon="bi bi-graph-up"
                iconColor="var(--haramain-primary)" textColor="{{ $totalPelanggan > 0 ? 'text-success' : 'text-muted' }}"
                desc="{{ $pelangganBulanIni }} travel baru" />

        </div>
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <select name="bulan" class="form-select">
                        <option value="">-- Pilih Bulan --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="tahun" class="form-select">
                        <option value="">-- Pilih Tahun --</option>
                        @for ($t = date('Y'); $t >= 2020; $t--)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                                {{ $t }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 my-3">
                    <button class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <!-- Travel List -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-2 title-customer" style="color: var(--haramain-primary); ">
                                <i class="bi bi-building me-2"></i>Daftar Travel/Pelanggan
                            </h5>
                            <div>
                                <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-sm me-2"
                                    style="background-color: var(--haramain-secondary); color: white;">
                                    <i class="bi bi-plus"></i> Tambah Baru
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Table Desktop -->
                    <div class="card-body pt-2 d-none d-md-block">
                        @if ($pelanggans->isEmpty())
                            <div class="text-center py-5">
                                <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data"
                                    style="height: 150px;">
                                <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Travel</h5>
                                <p class="text-muted">Mulai dengan menambahkan travel pertama Anda</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-haramain">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Travel</th>
                                            <th>Penanggung Jawab</th>
                                            <th>Kontak</th>
                                            <th>Status</th>
                                            <th>Terdaftar</th>
                                            <th>Total Transaksi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pelanggans as $pelanggan)
                                            <tr>
                                                <td class="fw-bold" style="color: var(--haramain-primary);">
                                                    <a href="{{ route('admin.pelanggan.show', $pelanggan->id) }}"
                                                        class="text-decoration-none">
                                                        #TRV-{{ str_pad($pelanggan->id, 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($pelanggan->foto)
                                                            <img src="{{ url('storage/' . $pelanggan->foto) }}"
                                                                class="rounded-circle me-2" width="32"
                                                                height="32">
                                                        @else
                                                            <div class="me-2"
                                                                style="width:32px; height:32px; background:#e3f2fd; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                                                <i class="bi bi-building"
                                                                    style="color: var(--haramain-secondary); font-size:.875rem;"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <a href="{{ route('admin.pelanggan.show', $pelanggan->id) }}"
                                                                class="fw-semibold d-block text-decoration-none text-dark">
                                                                {{ $pelanggan->nama_travel }}
                                                            </a>
                                                            <div class="text-muted small">{{ $pelanggan->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $pelanggan->penanggung_jawab }} <br> <small class="text-muted">KTP:
                                                        {{ $pelanggan->no_ktp }}</small></td>
                                                <td>{{ $pelanggan->phone ?? '-' }} <br> <small
                                                        class="text-muted">{{ Str::limit($pelanggan->alamat, 20) }}</small>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $pelanggan->status == 'active' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">
                                                        {{ $pelanggan->status == 'active' ? 'Aktif' : 'Non-Aktif' }}
                                                    </span>
                                                </td>
                                                <td>{{ $pelanggan->created_at->format('d M Y') }} <br> <small
                                                        class="text-muted">{{ $pelanggan->created_at->diffForHumans() }}</small>
                                                </td>
                                                <td>{{ $pelanggan->services->flatMap->orders->count() }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}"
                                                            class="btn btn-sm me-1"
                                                            style="background-color: var(--haramain-light); color: var(--haramain-primary);">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm"
                                                                style="background-color: var(--haramain-light); color:#f44336;"
                                                                onclick="return confirm('Hapus travel ini?')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            {{ $pelanggans->links() }}
                        @endif
                    </div>

                    <!-- Card Mobile -->
                    <div class="d-block d-md-none ">
                        @foreach ($pelanggans as $pelanggan)
                            <div class="card mb-2 shadow-sm mt-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="fw-bold">#TRV-{{ str_pad($pelanggan->id, 4, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <span
                                            class="badge {{ $pelanggan->status == 'active' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">
                                            {{ $pelanggan->status == 'active' ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </div>
                                    <div class="mb-1 fw-semibold">{{ $pelanggan->nama_travel }}</div>
                                    <div class="text-muted small mb-1">{{ $pelanggan->email }}</div>
                                    <div class="mb-1">Penanggung Jawab: {{ $pelanggan->penanggung_jawab }}</div>
                                    <div class="text-muted small mb-1">KTP: {{ $pelanggan->no_ktp }}</div>
                                    <div class="mb-1">Kontak: {{ $pelanggan->phone ?? '-' }}</div>
                                    <div class="text-muted small mb-1">Alamat: {{ Str::limit($pelanggan->alamat, 40) }}
                                    </div>
                                    <div class="text-muted small mb-1">Terdaftar:
                                        {{ $pelanggan->created_at->format('d M Y') }}</div>
                                    <div class="d-flex mt-2">
                                        <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}"
                                            class="btn btn-sm me-1 flex-fill"
                                            style="background-color: var(--haramain-light); color: var(--haramain-primary);"><i
                                                class="bi bi-pencil"></i> Edit</a>
                                        <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}"
                                            method="POST" class="flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm w-100"
                                                style="background-color: var(--haramain-light); color:#f44336;"
                                                onclick="return confirm('Hapus travel ini?')"><i class="bi bi-trash"></i>
                                                Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $pelanggans->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div> --}}

@endsection

{{-- @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endpush --}}
