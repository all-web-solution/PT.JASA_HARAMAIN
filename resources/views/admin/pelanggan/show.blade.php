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
                <div class="col-md-4"><strong>ID:</strong> #CUST-{{ str_pad($pelanggan->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="col-md-4"><strong>Travel:</strong> {{ $pelanggan->nama_travel }}</div>
                <div class="col-md-4"><strong>Penanggung Jawab:</strong> {{ $pelanggan->penanggung_jawab }}</div>
                <div class="col-md-4"><strong>Kontak:</strong> {{ $pelanggan->phone }}</div>
                <div class="col-md-4"><strong>Status:</strong> 
                    <span class="badge {{ $pelanggan->status=='active'?'bg-success bg-opacity-10 text-success':'bg-danger bg-opacity-10 text-danger' }}">
                        {{ $pelanggan->status=='active'?'Aktif':'Non-Aktif' }}
                    </span>
                </div>
                <div class="col-md-4"><strong>Terdaftar:</strong> {{ $pelanggan->created_at->format('d M Y') }}</div>
                <div class="col-md-4"><strong>Total Transaksi:</strong> Rp {{ number_format($pelanggan->services->flatMap->orders->sum('total'),0,',','.') }}</div>
            </div>
        </div>
    </div>

    <!-- Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body">
    <h6 class="card-subtitle mb-1">Total Tagihan</h6>
    <h3 class="fw-bold text-danger">
        Rp {{ number_format(optional($pelanggan->services->flatMap->orders->last())->sisa_hutang, 0, ',', '.') }}
    </h3>
</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-1">Total Request</h6>
                    <h3 class="fw-bold text-primary">
                        {{ $pelanggan->services->count() }} Request
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Request -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h6 class="fw-bold mb-0" style="color: var(--haramain-primary);">
                <i class="bi bi-receipt me-2"></i>Daftar Request
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-haramain">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Total Tagihan</th>
                            <th>Sisa Tagihan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggan->services->flatMap->orders as $index => $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>  Rp {{ number_format(optional($pelanggan->services->flatMap->orders->last())->total_amount, 0, ',', '.') }}</td>
                            <td>  Rp {{ number_format(optional($pelanggan->services->flatMap->orders->last())->sisa_hutang, 0, ',', '.') }}</td>
                            <td>
                                <a href="" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-printer"></i> Cetak Invoice
                                </a>
                                <a href="" class="btn btn-sm btn-success">
                                    <i class="bi bi-credit-card"></i> Pembayaran
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada request</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
