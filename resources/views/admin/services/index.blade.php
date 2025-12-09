@extends('admin.master')
@section('title', 'Daftar Permintaan Service')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/services/index.css') }}">
@endpush
@section('content')
    <div class="service-list-container">
        <div class="row g-3 mb-4 p-1">
            <x-card-component class="col-xl-4 col-md-6" title="Nego" :count="$totalNegoOverall" icon="bi bi-hourglass-split spin"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Menunggu konfirmasi" />
            <x-card-component class="col-xl-4 col-md-6" title="Deal" :count="$totalDealOverall" icon="bi bi-hand-thumbs-up"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Harga sudah deal" />
            <x-card-component class="col-xl-4 col-md-6" title="Persiapan" :count="$totalPersiapanOverall" icon="bi bi-box-seam"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Sedang dipersiapkan" />
            <x-card-component class="col-xl-6 col-md-6" title="Tahap Produksi" :count="$totalProduksiOverall" icon="bi bi-gear-fill spin"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Sedang dikerjakan" />
            <x-card-component class="col-xl-6 col-md-6" title="Selesai (Done)" :count="$totalDoneOverall" icon="bi bi-check2-circle"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Layanan telah selesai" />
        </div>

        <!-- Services List -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title" id="text-title">
                    <i class="bi bi-list-check"></i>Daftar Permintaan Services
                </h5>
                <a href="{{ route('services.create') }}" class="btn-add-new">
                    <i class="bi bi-plus-circle"></i> Tambah Permintaan
                </a>
            </div>

            <!-- Search -->
            <div class="search-filter-container">
                <div class="filter-group">
                    <form method="GET" action="{{ route('admin.services') }}" id="searchFilterForm"
                        class="d-flex flex-grow-1 gap-2">
                        <div class="search-box flex-grow-1 position-relative">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" name="search" id="searchInput" class="form-control ps-5"
                                placeholder="Cari customer/Jenis layanan..." value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Services Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>Tanggal Keberangkatan</th>
                            <th>Tanggal Kepulangan</th>
                            <th>Jumlah Jamaah</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @if ($services->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data"
                                        style="height: 150px;">
                                    <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Services</h5>
                                    <p class="text-muted">Mulai dengan menambahkan permintaan di service</p>
                                </td>
                            </tr>
                        @else
                            @foreach ($services as $service)
                                <tr>
                                    <td data-label="Kode unik">{{ $service->unique_code }}</td>
                                    <td data-label="Customer/Travel">{{ $service->pelanggan->nama_travel }}</td>
                                    <td data-label="Tgl keberangkatan">{{ $service->tanggal_keberangkatan }}</td>
                                    <td data-label="Tgl kepulangan">{{ $service->tanggal_kepulangan }}</td>
                                    <td data-label="Jumlah jamaah">{{ $service->total_jamaah }}</td>
                                    <td data-label="Layanan yang di pilih">
                                        @php
                                            $layanan = $service->services;
                                            if (is_string($layanan)) {
                                                $layanan = json_decode($layanan, true);
                                            }
                                        @endphp

                                        @if (is_array($layanan) && !empty($layanan))
                                            <ul>
                                                @foreach ($layanan as $item)
                                                    <li style="list-style-type: disc; margin-left: 20px;">
                                                        {{ $item }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    @if ($service->status === 'nego')
                                        <td data-label="Status">
                                            <a href="{{ route('services.edit', $service->id) }}">
                                                <button class="btn btn-warning"
                                                    style="width: 100%; white-space: normal;">Lanjutkan pemesanan</button>
                                            </a>
                                        </td>
                                    @else
                                        <td data-label="Status">
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                Deal
                                            </span>
                                        </td>
                                    @endif

                                    <td data-label="Aksi">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.service.file', $service->id) }}">
                                                <button class="btn-action btn-upload"
                                                    title="Upload berkas yang di perlukan">
                                                    <i class="bi bi-cloud-arrow-up"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('admin.services.show', $service->id) }}">
                                                <button class="btn-action btn-view" title="view">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $services->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $services->previousPageUrl() ?? '#' }}"
                                tabindex="-1">&laquo;</a>
                        </li>
                        @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                            <li class="page-item {{ $services->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                        <li class="page-item {{ !$services->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $services->nextPageUrl() ?? '#' }}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchFilterForm');
            let debounceTimer;

            searchInput.addEventListener('keyup', function() {
                clearTimeout(debounceTimer);

                debounceTimer = setTimeout(function() {
                    searchForm.submit();
                }, 500);
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Delete confirmation
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Apakah Anda yakin ingin menghapus permintaan service ini?')) {
                        // Here you would typically send a delete request to your backend
                        const row = this.closest('tr');
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.remove();
                            alert('Permintaan service berhasil dihapus!');
                        }, 300);
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });
    </script>
@endpush
