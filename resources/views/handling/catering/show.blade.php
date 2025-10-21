@extends('admin.master')
@section('title', 'Detail Catering')

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
        --background-light: #f8fafd;
    }
    .service-show-container {
        padding: 2rem;
        background-color: var(--background-light);
    }
    .card {
        border-radius: 12px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    .card-header {
        background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }
    .card-header h5 {
        color: var(--haramain-primary);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>
@endpush

@section('content')
<div class="service-show-container">

    <!-- Detail Service -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="fw-bold">
                <i class="bi bi-gear-wide-connected me-2"></i>Detail Service Catering
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

    <!-- Detail Menu -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h6 class="fw-bold mb-0" style="color: var(--haramain-primary);">
                <i class="bi bi-card-list me-2"></i>Daftar Menu Catering
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($service->meals as $meal)
                          <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $meal->mealItem->name}}</td>
                                <td>Rp {{ $meal->mealItem->price}}</td>
                                <td>{{ $meal->jumlah }}</td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
