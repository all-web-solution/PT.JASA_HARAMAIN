@extends('admin.master')
@section('title', 'Detail Customer & Pendamping')
@push('styles')
<style>
    :root {
        --haramain-primary: #1a4b8c;
        --haramain-secondary: #2a6fdb;
        --haramain-light: #e6f0fa;
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid #d1e0f5;
        margin-bottom: 2rem;
        overflow: hidden;
    }
    .card-header {
        background: var(--haramain-light);
        padding: 1.25rem 1.5rem;
        font-weight: bold;
        color: var(--haramain-primary);
    }
    table.table {
        width: 100%;
        border-collapse: collapse;
    }
    table.table th, table.table td {
        border: 1px solid #e0e0e0;
        padding: 0.75rem 1rem;
    }
</style>
@endpush

@section('content')
<div class="container my-4">

    {{-- 🧍 Customer Info --}}
    <div class="card">
        <div class="card-header"><i class="bi bi-person-badge"></i> Detail Customer</div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Nama Customer</th>
                    <td>{{ $service->pelanggan->nama_travel ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $service->pelanggan->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nomor Telepon</th>
                    <td>{{ $service->pelanggan->phone}}</td>
                </tr>
                <tr>
                    <th>Tanggal Keberangkatan</th>
                    <td>{{ $service->tanggal_keberangkatan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Kepulangan</th>
                    <td>{{ $service->tanggal_kepulangan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($service->status) ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- 🤝 Guide List --}}
    <div class="card">
        <div class="card-header"><i class="bi bi-people"></i> Daftar Pendamping</div>
        <div class="card-body">
            @if ($service->guides->isEmpty())
                <p class="text-muted text-center py-3">Belum ada pendamping untuk layanan ini.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pendamping</th>
                            <th>Jumlah</th>
                            <th>Dari Tanggal</th>
                            <th>Sampai Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($service->guides as $guide)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $guide->guideItem->nama ?? '-' }}</td>
                                <td>{{ $guide->jumlah ?? '-' }}</td>
                                <td>{{ $guide->muthowif_dari ?? '-' }}</td>
                                <td>{{ $guide->muthowif_sampai ?? '-' }}</td>
                                <td>{{ ucfirst($guide->status ?? '-') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
