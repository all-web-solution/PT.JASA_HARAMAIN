@extends('admin.master')
@section('title', 'Daftar Travel')
@push('styles')
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--haramain-accent:#3d8bfd;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--success-color:#28a745;--warning-color:#ffc107;--danger-color:#dc3545}.customer-list-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:#f8fafd}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden}.card:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgb(0 0 0 / .1)}.card-header{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.card-title i{font-size:1.5rem;color:var(--haramain-secondary)}.table-responsive{max-width:100vw;padding:0 1.5rem 1rem}.table{width:100%;border-collapse:separate;border-spacing:0 .75rem}.table thead th{background-color:var(--haramain-light);color:var(--haramain-primary);font-weight:600;padding:1rem 1.25rem;border-bottom:2px solid var(--border-color);text-align:center;vertical-align:middle}.table tbody tr{background-color:#fff;transition:all 0.3s ease;border-radius:8px}.table tbody tr:hover{background-color:var(--hover-bg);box-shadow:0 4px 12px rgb(42 111 219 / .1)}.table tbody td{padding:1.25rem;vertical-align:middle;border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color)}.table tbody td:first-child{border-left:1px solid var(--border-color);border-top-left-radius:8px;border-bottom-left-radius:8px}.table tbody td:last-child{border-right:1px solid var(--border-color);border-top-right-radius:8px;border-bottom-right-radius:8px}.customer-info{display:flex;align-items:center;gap:1rem}.customer-avatar{width:40px;height:40px;border-radius:50%;background-color:var(--haramain-light);display:flex;align-items:center;justify-content:center;color:var(--haramain-secondary);font-size:1.25rem;font-weight:700;flex-shrink:0}.customer-name{font-weight:600;color:var(--haramain-primary)}.customer-type{font-size:.8rem;color:var(--text-secondary);display:block}.action-buttons{display:flex;align-items:center;gap:.25rem}.btn-action{width:36px;height:36px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;transition:all 0.3s ease;border:none;background-color:#fff0;cursor:pointer}.btn-action:hover{background-color:var(--haramain-light)}.btn-action i{font-size:1rem}.btn-edit{color:var(--haramain-secondary)}.btn-delete{color:var(--danger-color)}.search-filter-container{display:flex;justify-content:space-between;padding:1.5rem;align-items:center;border-bottom:1px solid var(--border-color)}.search-box{position:relative;width:300px}.search-box input{padding-left:2.5rem;border-radius:8px;border:1px solid var(--border-color);height:40px;width:100%}.search-box i{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:var(--text-secondary)}.filter-group{display:flex;gap:1rem}.filter-select{height:40px;border-radius:8px;border:1px solid var(--border-color);padding:0 1rem;min-width:150px}.btn-add-new{background-color:var(--haramain-secondary);color:#fff;border-radius:8px;padding:.625rem 1.5rem;font-weight:600;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;border:none;text-decoration:none}.btn-add-new:hover{background-color:var(--haramain-primary);transform:translateY(-2px);box-shadow:0 4px 8px rgb(26 75 140 / .3)}.btn-view{color:var(--haramain-primary)}@media (max-width:400px){.card-header{padding:1rem}.card-title{font-size:1rem;text-align:center;width:100%;justify-content:center}.btn-add-new{width:100%;justify-content:center}.filter-container{flex-direction:column;padding:1rem}.search-box{width:100%}.filter-group{width:100%;flex-direction:column}.filter-select{width:100%}.table tbody td{font-size:.85rem;padding:.6rem .8rem;flex-direction:column;align-items:flex-start}.table tbody td:before{margin-bottom:.25rem;font-size:.8rem}}
    </style>
@endpush
@section('content')
    <div class="customer-list-container">
        <div class="row g-3 mb-4 p-1" id="cards-dashboard">
            <x-card-component class="col-xl-3 col-md-6" title="Total Travel" :count="$totalPelanggan" icon="bi bi-building"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Semua travel terdaftar" />
            <x-card-component class="col-xl-3 col-md-6" title="Travel Aktif" :count="$pelangganAktif" icon="bi bi-check-circle"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="{{ $persenAktif }}% dari total" />
            <x-card-component class="col-xl-3 col-md-6" title="Travel Non-Aktif" :count="$pelangganNonAktif" icon="bi bi-x-circle"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="{{ $persenNonAktif }}% dari total" />
            <x-card-component class="col-xl-3 col-md-6" title="Kenaikan Bulan ini" :count="$pelangganBulanIni" icon="bi bi-graph-up"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="{{ $pelangganBulanIni }} travel baru" />
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-people-fill"></i>Daftar Pelanggan
                </h5>
                <a href="{{ route('admin.pelanggan.create') }}" class="btn-add-new">
                    <i class="bi bi-plus-circle"></i> Tambah Pelanggan Baru
                </a>
            </div>

            <div class="search-filter-container">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan nama, email, dll...">
                </div>
                <div class="filter-group">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary d-flex align-items-center" type="button"
                            id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel me-2"></i> Filter
                        </button>

                        <div class="dropdown-menu dropdown-menu-end p-4 shadow" style="width: 320px;">
                            <form action="{{ route('admin.pelanggan') }}" method="GET">
                                <h6 class="fw-bold mb-3">Filters</h6>

                                <div class="mb-3">
                                    <label for="bulan" class="form-label small text-muted">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-select">
                                        <option value="">-- Pilih Bulan --</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}"
                                                {{ request('bulan') == $i ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tahun" class="form-label small text-muted">Tahun</label>
                                    <input type="number" name="tahun" id="tahun" class="form-control"
                                        placeholder="Tahun" value="{{ request('tahun', now()->year) }}">
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{ route('admin.pelanggan') }}"
                                        class="btn btn-sm btn-outline-secondary">Reset</a>
                                    <button type="submit" class="btn btn-sm btn-primary">Apply filters</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

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
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data"
                                        style="height: 150px;">
                                    <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Travel</h5>
                                    <p class="text-muted">Mulai dengan menambahkan travel pertama Anda</p>
                                </td>
                            </tr>
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
                                            <a href="{{ route('admin.pelanggan.show', $pelanggan->id) }}">
                                                <button class="btn-action btn-view" title="view">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}">
                                                <button class="btn-action btn-edit" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </a>
                                            <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}"
                                                method="POST" class="form-delete">
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

            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $pelanggans->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $pelanggans->previousPageUrl() ?? '#' }}"
                                tabindex="-1">&laquo;</a>
                        </li>

                        @foreach ($pelanggans->getUrlRange(1, $pelanggans->lastPage()) as $page => $url)
                            <li class="page-item {{ $pelanggans->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$pelanggans->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $pelanggans->nextPageUrl() ?? '#' }}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('pageshow', function(event) {
            if (!event.persisted) {
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
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Improved Search Functionality
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('userTableBody');
            const rows = tableBody.getElementsByTagName('tr');

            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    for (let i = 0; i < rows.length; i++) {
                        const row = rows[i];
                        const rowText = row.textContent.toLowerCase();
                        row.style.display = rowText.includes(searchTerm) ? '' : 'none';
                    }
                });
            }

            const deleteForms = document.querySelectorAll('.form-delete');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data ini akan dihapus permanen beserta permintaan service!",
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
