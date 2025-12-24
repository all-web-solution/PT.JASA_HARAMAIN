@extends('admin.master')
@section('title', 'Handling Pesawat')
@push('styles')
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--haramain-accent:#3d8bfd;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--background-light:#f8fafd}.plane-handling-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:var(--background-light)}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden}.card-header{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem;display:flex;align-items:center;justify-content:space-between}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.card-title i{font-size:1.5rem;color:var(--haramain-secondary)}.card-body{padding:2rem}.table-responsive{overflow-x:auto}.table{width:100%;border-collapse:separate;border-spacing:0 .75rem;margin-top:-.75rem}.table thead th{background-color:var(--haramain-light);color:var(--haramain-primary);font-weight:600;padding:1rem 1.25rem;border-bottom:2px solid var(--border-color);text-align:center;white-space:nowrap;text-transform:uppercase;font-size:.8rem;letter-spacing:.5px}.table tbody tr{background-color:#fff;transition:all 0.3s ease;border-radius:8px}.table tbody tr:hover{background-color:var(--hover-bg);box-shadow:0 4px 12px rgb(42 111 219 / .1);transform:translateY(-2px)}.table tbody td{padding:1.25rem;vertical-align:middle;text-align:center;border:1px solid #fff0;border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color)}.table tbody tr td:first-child{border-left:1px solid var(--border-color);border-top-left-radius:8px;border-bottom-left-radius:8px}.table tbody tr td:last-child{border-right:1px solid var(--border-color);border-top-right-radius:8px;border-bottom-right-radius:8px}.actions-container{display:flex;gap:.5rem;align-items:center}.actions-container .btn{padding:.375rem .75rem}
    </style>
@endpush

@section('content')
    <div class="plane-handling-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-airplane-fill"></i>Data Handling Pesawat
                </h5>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Customer</th>
                                <th>Nama Bandara</th>
                                <th>Jumlah Jamaah</th>
                                <th>Harga</th>
                                <th>Kedatangan Jamaah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($planes as $plane)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $plane->handling->service->pelanggan->nama_travel ?? '-' }}</td>
                                    <td>{{ $plane->nama_bandara }}</td>
                                    <td>{{ $plane->jumlah_jamaah }}</td>
                                    <td>{{ $plane->harga }}</td>
                                    <td>{{ \Carbon\Carbon::parse($plane->kedatangan_jamaah)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>
                                        <div class="actions-container justify-content-center">
                                            <a href="{{ route('handling.handling.plane.show', $plane->id) }}"
                                                class="btn btn-info btn-sm" title="Detail">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="{{ route('handling.pesawat.edit', $plane->id) }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center; padding: 2rem;">
                                        Belum ada data handling pesawat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $planes->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $planes->previousPageUrl() ?? '#' }}" tabindex="-1">&laquo;</a>
                        </li>

                        @foreach ($planes->getUrlRange(1, $planes->lastPage()) as $page => $url)
                            <li class="page-item {{ $planes->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$planes->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $planes->nextPageUrl() ?? '#' }}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
