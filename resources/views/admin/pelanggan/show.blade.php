@extends('admin.master')
@section('content')

@php
    // --- Optimasi Blade ---
    // 1. Mengambil semua order dari semua service sekaligus
    $allOrders = $pelanggan->services->flatMap(fn($service) => $service->orders);

    // 2. Menghitung total transaksi
    $totalTransaksi = $allOrders->sum('total');

    // 3. Mengambil order terakhir (jika ada) untuk kartu tagihan
    $lastOrder = $allOrders->last();

    // 4. Menghitung total request dari semua service
    $totalRequest = 0;
    foreach ($pelanggan->services as $service) {
        $decodedServices = json_decode($service->services, true);
        if (is_array($decodedServices)) {
            $totalRequest += count($decodedServices);
        }
    }
@endphp

{{--
    CATATAN PENTING UNTUK PERFORMA:
    Pastikan di Controller Anda, Anda telah melakukan Eager Loading untuk relasi ini
    agar tidak terjadi N+1 Query.

    Contoh di Controller:
    $pelanggan = Pelanggan::with('services.orders')->findOrFail($id);
--}}

<div class="container-fluid p-3">

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
                <div class="col-md-4"><strong>Email:</strong> {{ $pelanggan->email }}</div>

                {{-- FIX: Ambil dari service pertama, atau gunakan optional() untuk menghindari error --}}
                <div class="col-md-4"><strong>Tanggal Keberangkatan:</strong> {{ optional($pelanggan->services->first())->tanggal_keberangkatan ?? 'Belum ada tanggal' }}</div>
                <div class="col-md-4"><strong>Tanggal Kepulangan:</strong> {{ optional($pelanggan->services->first())->tanggal_kepulangan ?? 'Belum ada tanggal' }}</div>

                <div class="col-md-4"><strong>Status:</strong>
                    <span class="badge {{ $pelanggan->status == 'active' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">
                        {{ $pelanggan->status == 'active' ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </div>
                <div class="col-md-4"><strong>Terdaftar:</strong> {{ $pelanggan->created_at->format('d M Y') }}</div>

                {{-- FIX: Gunakan variabel $totalTransaksi yang sudah dihitung --}}
                <div class="col-md-4"><strong>Total Transaksi:</strong> Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-1">Total Tagihan</h6>
                    <h3 class="fw-bold text-danger">
                        {{-- FIX: Gunakan variabel $lastOrder yang sudah dihitung --}}
                        Rp {{ number_format(optional($lastOrder)->sisa_hutang, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-1">Total Request</h6>
                    <h3 class="fw-bold text-primary">
                        {{-- FIX: Tampilkan total $totalRequest, hapus loop --}}
                        {{ $totalRequest }} Request
                    </h3>
                </div>
            </div>
        </div>
    </div>

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
                        {{-- FIX: Gunakan $allOrders untuk loop --}}
                        @forelse($allOrders as $index => $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            {{-- FIX: Gunakan $order->total_amount dari item loop saat ini --}}
                            <td> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>

                            {{-- FIX: Gunakan $order->sisa_hutang dari item loop saat ini --}}
                            <td> Rp {{ number_format($order->sisa_hutang, 0, ',', '.') }}</td>

                            <td>
                                {{-- PERBAIKAN: Tambahkan route (ganti '...' dengan nama route Anda) --}}
                                <a href="{{-- route('admin.invoice.print', $order->id) --}}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-printer"></i> Cetak Invoice
                                </a>
                                <a href="{{-- route('admin.pembayaran.create', $order->id) --}}" class="btn btn-sm btn-success">
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
