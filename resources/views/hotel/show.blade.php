@extends('admin.master')

@section('content')
<div class="container-fluid p-3">

    <!-- Detail Customer -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="fw-bold" style="color: var(--haramain-primary);">
                <i class="bi bi-person-badge me-2"></i>Detail Customer
            </h5>
        </div>

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <strong>ID Service:</strong><br> {{ $service->unique_code }}
                </div>
                <div class="col-md-4">
                    <strong>Travel:</strong><br> {{ $service->pelanggan->nama_travel ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Penanggung Jawab:</strong><br> {{ $service->pelanggan->penanggung_jawab ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Alamat:</strong><br> {{ $service->pelanggan->alamat ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Email:</strong><br> {{ $service->pelanggan->email ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Kontak:</strong><br> {{ $service->pelanggan->phone ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Nomor KTP:</strong><br> {{ $service->pelanggan->no_ktp ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Produk/Layanan:</strong><br> {{ $service->services ?? '-' }}
                </div>
                <div class="col-md-4">
                    <strong>Status:</strong><br>
                    <span class="badge bg-success">Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0" style="color: var(--haramain-primary);">
            <i class="bi bi-building me-2"></i>Detail Hotel
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Hotel</th>
                        <th>Type</th>
                        <th>Jumlah Type</th>

                        <th>Harga per Kamar</th>

                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($service->hotels as $index => $hotel)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $hotel->nama_hotel ?? '-' }}</td>
                            <td>{{ $hotel->type ?? '-' }}</td>
                            <td>{{ $hotel->jumlah_type ?? '-' }}</td>
                            <td>Rp {{ number_format($hotel->harga_perkamar ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $hotel->catatan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('hotel.edit', $hotel->id) }}">
                                    <button class="btn btn-warning">Tambah harga</button>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data hotel</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


</div>
@endsection
