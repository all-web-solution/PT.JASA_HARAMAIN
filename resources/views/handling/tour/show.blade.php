@extends('admin.master')
@section('title', 'Detail Customer Tour')
@push('styles')
{{-- ... (Seluruh CSS Anda tetap sama) ... --}}
<style>
    :root {
        --haramain-primary: #1a4b8c;
        --haramain-secondary: #2a6fdb;
        --haramain-light: #e6f0fa;
        --haramain-accent: #3d8bfd;
        --text-primary: #2d3748;
        --text-secondary: #4a5568;
        --border-color: #d1e0f5;
        --hover-bg: #f0f7ff;
        --background-light: #f8fafd;
    }

    .tour-detail-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: white;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .tour-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }

    .tour-header h4 {
        color: var(--haramain-primary);
        font-weight: 700;
    }

    .tour-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .info-item {
        background-color: var(--haramain-light);
        padding: 1rem;
        border-radius: 8px;
    }

    .info-item strong {
        color: var(--haramain-primary);
        display: block;
        margin-bottom: 0.5rem;
    }

    .section-title {
        font-weight: 600;
        color: var(--haramain-secondary);
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.5rem;
    }

    table th {
        background-color: var(--haramain-light);
        color: var(--haramain-primary);
        font-weight: 600;
        padding: 0.75rem;
        text-align: left;
    }

    table td {
        background-color: #fff;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
    }

    table tr:hover {
        background-color: var(--hover-bg);
    }

    table td:first-child, table th:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    table td:last-child, table th:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .btn-back {
        background-color: var(--haramain-secondary);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        margin-top: 1.5rem;
        transition: background 0.3s ease;
    }

    .btn-back:hover {
        background-color: var(--haramain-primary);
    }
</style>
@endpush

@section('content')
<div class="tour-detail-container">
    <div class="tour-header">
        <h4><i class="bi bi-geo-alt-fill"></i> Detail Customer Tour</h4>
        <a href="{{ route('handling.tour.customer') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{--
      PERBAIKAN:
      Sekarang $service adalah variabel yang valid dan bisa diakses.
      Nama customer diambil dari relasi $service->pelanggan.
      Tanggal diformat agar lebih rapi.
    --}}
    <div class="tour-info">
        <div class="info-item">
            <strong>Nama Customer</strong>
            <span>{{ $service->pelanggan->nama_travel }}</span>
        </div>
        <div class="info-item">
            <strong>Tanggal Keberangkatan</strong>
            <span>{{ $service->tanggal_keberangkatan ? \Carbon\Carbon::parse($service->tanggal_keberangkatan)->format('d F Y') : '-' }}</span>
        </div>
        <div class="info-item">
            <strong>Tanggal Kepulangan</strong>
            <span>{{ $service->tanggal_kepulangan ? \Carbon\Carbon::parse($service->tanggal_kepulangan)->format('d F Y') : '-' }}</span>
        </div>
        <div class="info-item">
            <strong>Status</strong>
            <span>{{ ucfirst($service->status ?? '-') }}</span>
        </div>
    </div>

    <h5 class="section-title"><i class="bi bi-people-fill"></i> Detail Tour</h5>

    <table>
        <thead>
            <tr>
                {{-- Ganti 'ID' menjadi 'No.' untuk $loop->iteration --}}
                <th style="width: 50px;">No.</th>
                <th>Nama Transportasi</th>
                <th>Nama Tour</th>
                <th>Tanggal Keberangkatan</th>
            </tr>
        </thead>
        <tbody>
            {{--
              PERBAIKAN:
              Gunakan @forelse untuk menangani kasus jika tidak ada data tour.
              Isi <td> yang kosong dengan $loop->iteration.
              Gunakan null-safe operator (?? '-') untuk relasi.
            --}}
            @forelse ($tour as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->transportation->nama ?? 'N/A' }}</td>
                <td>{{ $item->tourItem->name ?? 'N/A' }}</td>
                <td>{{ $item->tanggal_keberangkatan ? \Carbon\Carbon::parse($item->tanggal_keberangkatan)->format('d F Y') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 1rem;">
                    Tidak ada data tour yang ditemukan untuk service ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
