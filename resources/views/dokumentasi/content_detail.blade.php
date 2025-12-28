@extends('admin.master')
@Section('title', 'Detail Order Konten')
@push('styles')
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--haramain-accent:#3d8bfd;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--background-light:#f8fafd;--success-color:#28a745;--warning-color:#ffc107;--danger-color:#dc3545;--success-bg:rgba(40, 167, 69, 0.1);--warning-bg:rgba(255, 193, 7, 0.1);--danger-bg:rgba(220, 53, 69, 0.1);--primary-bg:var(--haramain-light)}.service-list-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:var(--background-light);min-height:100vh}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);background-color:#fff;overflow:hidden}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden;transition:transform 0.3s ease,box-shadow 0.3s ease}.card:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgb(0 0 0 / .1)}.card-header{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem;display:flex;align-items:center;justify-content:space-between}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.card-title i{font-size:1.5rem;color:var(--haramain-secondary)}.card-body{padding:1.5rem}.card-footer{background-color:var(--hover-bg);border-top:1px solid var(--border-color);padding:1rem 1.5rem;display:flex;justify-content:flex-end;gap:1rem}.btn-action,.btn-secondary{background-color:var(--haramain-secondary);color:#fff;border-radius:8px;padding:.625rem 1.25rem;font-weight:600;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;border:none;text-decoration:none;font-size:.9rem}.btn-action:hover{background-color:var(--haramain-primary);transform:translateY(-2px);box-shadow:0 4px 8px rgb(26 75 140 / .3)}.btn-secondary{background-color:#fff;color:var(--text-secondary);border:1px solid var(--border-color)}.btn-secondary:hover{background-color:var(--hover-bg);border-color:var(--haramain-secondary);color:var(--haramain-secondary)}.stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin-bottom:1.5rem}.info-card{background-color:#fff;border:1px solid var(--border-color);border-radius:8px;padding:1.25rem}.info-card-title{display:flex;align-items:center;gap:8px;font-size:1rem;font-weight:600;color:var(--haramain-primary);margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border-color)}.info-card-title i{color:var(--haramain-secondary)}.info-card .content{display:flex;flex-direction:column;gap:1rem}.info-item{display:flex;flex-direction:column;font-size:.9rem}.info-item .label{font-size:.8rem;color:var(--text-secondary);font-weight:500;margin-bottom:.25rem}.info-item .value{color:var(--text-primary);font-weight:600;font-size:1rem}.info-item .status-value{margin-top:.25rem}.badge{padding:.5rem .75rem;border-radius:6px;font-weight:700;font-size:.9rem;display:inline-flex;align-items:center;gap:.5rem}.badge-success{background-color:var(--success-bg);color:var(--success-color)}.badge-warning{background-color:var(--warning-bg);color:var(--warning-color)}.badge-danger{background-color:var(--danger-bg);color:var(--danger-color)}.badge-primary{background-color:var(--primary-bg);color:var(--haramain-secondary)}.keterangan-card{border-radius:8px;border:1px solid var(--border-color)}.keterangan-header{padding:1rem 1.25rem;background-color:var(--hover-bg);border-bottom:1px solid var(--border-color);font-weight:600;color:var(--haramain-primary);display:flex;align-items:center;gap:8px}.keterangan-body{font-size:.95rem;color:var(--text-secondary);line-height:1.7}@media (max-width:992px){.stats-grid{grid-template-columns:1fr 1fr}}@media (max-width:768px){.service-list-container{padding:1rem}.stats-grid{grid-template-columns:1fr}.card-header{flex-direction:column;align-items:flex-start;gap:1rem}.card-title{font-size:1.1rem}.card-title .subtitle-text{font-size:.9rem}.card-footer{flex-direction:column}.btn-action,.btn-secondary{width:100%;justify-content:center}}
    </style>
@endpush

@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-file-earmark-text"></i>
                    <div>
                        <span class="title-text">Detail: {{ $contentCustomer->content?->name ?? 'N/A' }}</span>
                    </div>
                </h5>
                <div>
                    <a href="{{ route('content.customer') }}" class="btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                    <a href="{{ route('customer.edit', $contentCustomer->id) }}" class="btn-action">
                        <i class="bi bi-pencil-fill"></i>
                        Edit Order Ini
                    </a>
                </div>
            </div>
            @php
                $status = strtolower($contentCustomer->status);
                $statusClass = '';
                if (in_array($status, ['done', 'selesai', 'deal'])) {
                    $statusClass = 'badge-success';
                } elseif (in_array($status, ['pending', 'in progress', 'nego'])) {
                    $statusClass = 'badge-warning';
                } elseif (in_array($status, ['cancelled', 'batal'])) {
                    $statusClass = 'badge-danger';
                } else {
                    $statusClass = 'badge-primary';
                }
            @endphp

            <div class="card-body">

                <div class="stats-grid">

                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-person-badge"></i> Info Pelanggan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Nama Travel</span>
                                <span
                                    class="value">{{ $contentCustomer->service?->pelanggan?->nama_travel ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Penanggung Jawab</span>
                                <span
                                    class="value">{{ $contentCustomer->service?->pelanggan?->penanggung_jawab ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">No. Telepon</span>
                                <span class="value">{{ $contentCustomer->service?->pelanggan?->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Email</span>
                                <span class="value">{{ $contentCustomer->service?->pelanggan?->email ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-calendar-check"></i> Info Pelaksanaan</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Konten Dipesan</span>
                                <span class="value">{{ $contentCustomer->content?->name ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Jumlah</span>
                                <span class="value">{{ $contentCustomer->jumlah }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Tanggal Pelaksanaan</span>
                                <span
                                    class="value">{{ \Carbon\Carbon::parse($contentCustomer->tanggal_pelaksanaan)->isoFormat('dddd, D MMMM Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Status Permintaan Konten</span>
                                <span class="value status-value">
                                    <span class="badge {{ $statusClass }}">{{ $contentCustomer->status }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h6 class="info-card-title"><i class="bi bi-cash-coin"></i> Info Supplier</h6>
                        <div class="content">
                            <div class="info-item">
                                <span class="label">Supplier</span>
                                <span class="value">{{ $contentCustomer->supplier ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Harga Dasar</span>
                                <span class="value">SAR
                                    {{ number_format($contentCustomer->harga_dasar, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Harga Jual</span>
                                <span class="value">SAR
                                    {{ number_format($contentCustomer->harga_jual, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Profit</span>
                                <span class="value" style="color: var(--success-color);">
                                    SAR
                                    {{ number_format($contentCustomer->harga_jual - $contentCustomer->harga_dasar, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="info-card">
                    <div class="info-card-title">
                        <i class="bi bi-chat-right-text"></i> Keterangan
                    </div>
                    <div class="keterangan-body">
                        {{ $contentCustomer->keterangan ?? 'Tidak ada keterangan.' }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
