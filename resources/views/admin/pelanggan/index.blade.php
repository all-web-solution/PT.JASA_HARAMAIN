@extends('admin.master')
@section('content')

<div class="container-fluid p-3">
    <!-- Stats Cards -->
    <div class="row g-3 mb-3">
        <!-- Total Travel -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle mb-1">Total Travel</h6>
                            <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">{{ $totalPelanggan }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-2 rounded">
                            <i class="bi bi-building" style="color: var(--haramain-secondary);"></i>
                        </div>
                    </div>
                    <p class="card-text text-muted mt-1"><small>Semua travel terdaftar</small></p>
                </div>
            </div>
        </div>

        <!-- Travel Aktif -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle mb-1">Travel Aktif</h6>
                            <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">{{ $pelangganAktif }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-2 rounded">
                            <i class="bi bi-check-circle" style="color: #4caf50;"></i>
                        </div>
                    </div>
                    <p class="card-text {{ $totalPelanggan > 0 ? 'text-success' : 'text-muted' }} mt-1">
                        <small>
                            @if($totalPelanggan > 0)
                                {{ round(($pelangganAktif/$totalPelanggan)*100) }}% dari total
                            @else
                                Tidak ada data
                            @endif
                        </small>
                    </p>
                </div>
            </div>
        </div>

        <!-- Travel Non-Aktif -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle mb-1">Travel Non-Aktif</h6>
                            <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">{{ $pelangganNonAktif }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-2 rounded">
                            <i class="bi bi-x-circle" style="color: #f44336;"></i>
                        </div>
                    </div>
                    <p class="card-text {{ $totalPelanggan > 0 ? 'text-danger' : 'text-muted' }} mt-1">
                        <small>
                            @if($totalPelanggan > 0)
                                {{ round(($pelangganNonAktif/$totalPelanggan)*100) }}% dari total
                            @else
                                Tidak ada data
                            @endif
                        </small>
                    </p>
                </div>
            </div>
        </div>

        <!-- Penambahan Bulan Ini -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle mb-1">Penambahan Bulan Ini</h6>
                            <h3 class="card-title fw-bold" style="color: var(--haramain-primary);">{{ $pelangganBulanIni }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-2 rounded">
                            <i class="bi bi-graph-up" style="color: #00acc1;"></i>
                        </div>
                    </div>
                    <p class="card-text text-success mt-1">
                        <small>
                            @if($pelangganBulanIni > 0)
                                {{ $pelangganBulanIni }} travel baru
                            @else
                                Belum ada penambahan
                            @endif
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Travel List Table -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-2" style="color: var(--haramain-primary);">
                            <i class="bi bi-building me-2"></i>Daftar Travel/Pelanggan
                        </h5>
                        <div>
                            <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-sm me-2" style="background-color: var(--haramain-secondary); color: white;">
    <i class="bi bi-plus"></i> Tambah Baru
</a>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" 
                                        style="background-color: var(--haramain-light); color: var(--haramain-primary);">
                                    <i class="bi bi-download"></i> Ekspor
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-file-excel me-2"></i>Excel</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-file-pdf me-2"></i>PDF</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filter Section -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <form action="{{ route('admin.pelanggan') }}" method="GET">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" style="background-color: var(--haramain-light); border-color: rgba(0, 0, 0, 0.08);">
                                        <i class="bi bi-search" style="color: var(--haramain-primary);"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control" placeholder="Cari travel/pelanggan..." 
                                           style="border-color: rgba(0, 0, 0, 0.08);" value="{{ request('search') }}">
                                    <button class="btn" type="submit" style="background-color: var(--haramain-secondary); color: white;">
                                        Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('admin.pelanggan') }}" method="GET">
                                <select class="form-select" name="status" onchange="this.form.submit()" style="border-color: rgba(0, 0, 0, 0.08);">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('admin.pelanggan') }}" method="GET">
                                <select class="form-select" name="sort" onchange="this.form.submit()" style="border-color: rgba(0, 0, 0, 0.08);">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="card-body pt-2">
                    @if($pelanggans->isEmpty())
                        <div class="text-center py-5">
                            <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data" style="height: 150px;">
                            <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Travel</h5>
                            <p class="text-muted">Mulai dengan menambahkan travel pertama Anda</p>
                            <a href="" class="btn mt-2" style="background-color: var(--haramain-secondary); color: white;">
                                <i class="bi bi-plus"></i> Tambah Travel
                            </a>
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
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pelanggans as $pelanggan)
                                    <tr>
                                        <td class="fw-bold" style="color: var(--haramain-primary);">#TRV-{{ str_pad($pelanggan->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($pelanggan->foto)
                                                    <img src="{{ asset('storage/'.$pelanggan->foto) }}" class="rounded-circle me-2" width="32" height="32" alt="{{ $pelanggan->nama_travel }}">
                                                @else
                                                    <div class="me-2" style="width: 32px; height: 32px; background-color: #e3f2fd; border-radius: 50%; 
                                                         display: flex; align-items: center; justify-content: center;">
                                                        <i class="bi bi-building" style="color: var(--haramain-secondary); font-size: 0.875rem;"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $pelanggan->nama_travel }}</div>
                                                    <div class="text-muted small">{{ $pelanggan->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>{{ $pelanggan->penanggung_jawab }}</div>
                                            <div class="text-muted small">KTP: {{ $pelanggan->no_ktp }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $pelanggan->phone ?? '-' }}</div>
                                            <div class="text-muted small">{{ Str::limit($pelanggan->alamat, 20) }}</div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $pelanggan->status == 'active' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">
                                                {{ $pelanggan->status == 'active' ? 'Aktif' : 'Non-Aktif' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>{{ $pelanggan->created_at->format('d M Y') }}</div>
                                            <div class="text-muted small">{{ $pelanggan->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="" class="btn btn-sm me-1" 
                                                   style="background-color: var(--haramain-light); color: var(--haramain-primary); padding: 0.25rem 0.5rem;"
                                                   data-bs-toggle="tooltip" title="Edit">
                                                    <i class="bi bi-pencil" style="font-size: 0.8125rem;"></i>
                                                </a>
                                                <form action="" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm" 
                                                            style="background-color: var(--haramain-light); color: #f44336; padding: 0.25rem 0.5rem;"
                                                            data-bs-toggle="tooltip" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus travel ini?')">
                                                        <i class="bi bi-trash" style="font-size: 0.8125rem;"></i>
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
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted small">
                                Menampilkan {{ $pelanggans->firstItem() }} sampai {{ $pelanggans->lastItem() }} dari {{ $pelanggans->total() }} entri
                            </div>
                            <nav>
                                <ul class="pagination pagination-sm">
                                    {{-- Previous Page Link --}}
                                    @if ($pelanggans->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link" style="color: var(--haramain-primary);">&laquo;</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $pelanggans->previousPageUrl() }}" style="color: var(--haramain-primary);">&laquo;</a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($pelanggans->getUrlRange(1, $pelanggans->lastPage()) as $page => $url)
                                        @if ($page == $pelanggans->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link" style="background-color: var(--haramain-primary); border-color: var(--haramain-primary);">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}" style="color: var(--haramain-primary);">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($pelanggans->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $pelanggans->nextPageUrl() }}" style="color: var(--haramain-primary);">&raquo;</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link" style="color: var(--haramain-primary);">&raquo;</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Inisialisasi tooltip
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush