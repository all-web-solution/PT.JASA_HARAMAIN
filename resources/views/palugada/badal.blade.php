@extends('admin.master')
@section('title', 'Daftar Badal')
@push('styles')
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--haramain-accent:#3d8bfd;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--background-light:#f8fafd}.service-list-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:var(--background-light)}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden}.card-header{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem;display:flex;align-items:center;justify-content:space-between}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.card-title i{font-size:1.5rem;color:var(--haramain-secondary)}.table-responsive{padding:0 1.5rem 1.5rem 1.5rem}.table{width:100%;border-collapse:separate;border-spacing:0 .75rem;margin-top:-.75rem}.table thead th{background-color:var(--haramain-light);color:var(--haramain-primary);font-weight:600;padding:1rem 1.25rem;border-bottom:2px solid var(--border-color);text-align:left;white-space:nowrap}.table tbody tr{background-color:#fff;transition:all 0.3s ease;border-radius:8px}.table tbody tr:hover{background-color:var(--hover-bg);box-shadow:0 4px 12px rgb(42 111 219 / .1);transform:translateY(-2px)}.table tbody td{padding:1.25rem;vertical-align:middle;border:1px solid #fff0;border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color)}.table tbody tr td:first-child{border-left:1px solid var(--border-color);border-top-left-radius:8px;border-bottom-left-radius:8px}.table tbody tr td:last-child{border-right:1px solid var(--border-color);border-top-right-radius:8px;border-bottom-right-radius:8px}
    </style>
@endpush
@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-person-check-fill"></i>Daftar Badal
                </h5>
            </div>
            <div class="table-responsive" style="margin-top: 12px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer/Travel</th>
                            <th>Nama yang di badalkan</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($wakaf as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->service->pelanggan->nama_travel }}</td>
                                <td>{{ $item->name }}</td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center; padding: 2rem;">
                                    Belum ada data badal yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection