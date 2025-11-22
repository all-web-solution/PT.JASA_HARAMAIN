@extends('admin.master')
@section('title', 'Daftar Order Hotel')

@push('styles')
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--haramain-accent:#3d8bfd;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--background-light:#f8fafd;--success-color:#28a745;--warning-color:#ffc107;--danger-color:#dc3545;--success-bg:rgba(40, 167, 69, 0.1);--warning-bg:rgba(255, 193, 7, 0.1);--danger-bg:rgba(220, 53, 69, 0.1);--primary-bg:var(--haramain-light)}.service-list-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:var(--background-light)}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden}.card-header{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem;display:flex;align-items:center;justify-content:space-between}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.card-title i{font-size:1.5rem;color:var(--haramain-secondary)}.table-responsive{padding:0 1.5rem 1.5rem}.card-body{padding:0}.table{width:100%;border-collapse:separate;border-spacing:0 .75rem}.table thead th{background-color:var(--haramain-light);color:var(--haramain-primary);font-weight:600;padding:1rem 1.25rem;border-bottom:2px solid var(--border-color);text-align:left;white-space:nowrap}.table tbody tr{background-color:#fff;transition:all 0.3s ease;border-radius:8px}.table tbody tr:hover{background-color:var(--hover-bg);box-shadow:0 4px 12px rgb(42 111 219 / .1);transform:translateY(-2px)}.table tbody td{padding:1.25rem;vertical-align:middle;text-align:left;border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color)}.table tbody tr td:first-child{border-left:1px solid var(--border-color);border-top-left-radius:8px;border-bottom-left-radius:8px}.table tbody tr td:last-child{border-right:1px solid var(--border-color);border-top-right-radius:8px;border-bottom-right-radius:8px}.btn-action{width:32px;height:32px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;margin:0 .25rem;transition:all 0.3s ease;border:none;background-color:#fff0}.btn-action:hover{background-color:var(--haramain-light)}.btn-action i{font-size:1rem}.btn-edit{color:var(--haramain-secondary)}.btn-view{color:var(--text-secondary)}.btn-delete{color:var(--danger-color)}.badge{padding:.5rem .75rem;border-radius:6px;font-weight:700;font-size:.8rem;text-transform:capitalize}.badge-success{background-color:var(--success-bg);color:var(--success-color)}.badge-warning{background-color:var(--warning-bg);color:var(--warning-color)}.badge-danger{background-color:var(--danger-bg);color:var(--danger-color)}.badge-primary{background-color:var(--primary-bg);color:var(--haramain-secondary)}.pagination-container{display:flex;justify-content:flex-end;padding:1.5rem;border-top:1px solid var(--border-color);gap:1rem}.pagination .page-link{border-radius:10px;margin:0 3px;color:var(--haramain-primary);border-color:#d9e3f0}.pagination .page-item.active .page-link{background-color:#2f6fed;border-color:#2f6fed;color:#fff}.pagination .page-item.disabled .page-link{background-color:#f5f7fa;color:#adb5bd;border-color:#e3e7ec}
    </style>
@endpush

@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-building"></i>Daftar Order Hotel per Layanan
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Tgl. Order</th>
                                <th>Nama Travel</th>
                                <th style="text-align: center;">ID Service</th>
                                <th style="text-align: center;">Jml. Item Hotel</th>
                                <th style="text-align: center;">Progres Status</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($hotels->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data"
                                            style="height: 150px;">
                                        <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Permintaan
                                            Hotel</h5>
                                        <p class="text-muted">Tunggu permintaan dari admin</p>
                                    </td>
                                </tr>
                            @else
                                @foreach ($hotels as $service)
                                    @php
                                        $totalItems = $service->hotels->count();
                                        $doneStatuses = ['done', 'deal'];
                                        $doneItems = $service->hotels->whereIn('status', $doneStatuses)->count();
                                        $progressPercentage =
                                            $totalItems > 0 ? round(($doneItems / $totalItems) * 100) : 0;

                                        $progressTextColor = 'text-danger';
                                        if ($progressPercentage >= 100) {
                                            $progressTextColor = 'text-success';
                                        } elseif ($progressPercentage > 0) {
                                            $progressTextColor = 'text-warning';
                                        }

                                        $firstHotelItem = $service->hotels->first();
                                        $detailRoute = $firstHotelItem ? route('hotel.show', $firstHotelItem->id) : '#';
                                    @endphp
                                    <tr>
                                        <td style="text-align: center;">
                                            {{ ($hotels->currentPage() - 1) * $hotels->perPage() + $loop->iteration }}</td>
                                        <td style="text-align: center;">
                                            {{ \Carbon\Carbon::parse($service->created_at)->isoFormat('D MMM Y') }}</td>
                                        <td>{{ $service->pelanggan?->nama_travel ?? 'N/A' }}</td>
                                        <td style="text-align: center;">
                                            <span class="fw-bold">{{ $service->unique_code ?? 'N/A' }}</span>
                                        </td>
                                        <td style="text-align: center;">
                                            <span class="fw-bold">{{ $totalItems }}</span> Item
                                        </td>

                                        <td style="text-align: center;">
                                            <span class="fw-bold {{ $progressTextColor }}">{{ $doneItems }} dari
                                                {{ $totalItems }} Item Selesai</span>
                                            <br>
                                            <small class="text-muted">({{ $progressPercentage }}% Progres)</small>
                                        </td>

                                        <td style="text-align: center;">
                                            <a href="{{ $detailRoute }}" class="btn-action btn-view"
                                                title="Lihat Detail Item Hotel">
                                                <i class="bi bi-list-check"></i>
                                            </a>
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
                            <li class="page-item {{ $hotels->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $hotels->previousPageUrl() ?? '#' }}"
                                    tabindex="-1">&laquo;</a>
                            </li>
                            @foreach ($hotels->getUrlRange(1, $hotels->lastPage()) as $page => $url)
                                <li class="page-item {{ $hotels->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            <li class="page-item {{ !$hotels->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $hotels->nextPageUrl() ?? '#' }}">&raquo;</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
