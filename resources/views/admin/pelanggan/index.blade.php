@extends('admin.master')
@section('content')

    <div class="container-fluid p-4">
        <!-- Stats Cards -->
        <div class="row g-3 mb-4" id="cards-dashboard">
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
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endpush
