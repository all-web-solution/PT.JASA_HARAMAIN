@extends('admin.master') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
<style>
    /* Table responsive agar tidak geser ke kanan di HP */
    @media (max-width: 768px) {
        .table thead {
            display: none;
        }

        .table,
        .table tbody,
        .table tr,
        .table td {
            display: block;
            width: 100%;
        }

        .table tr {
            margin-bottom: 1rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 10px;
        }

        .table td {
            text-align: right;
            padding: 10px 15px;
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
        }

        .table td::before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            width: 50%;
            text-align: left;
            font-weight: 600;
            color: #1a4b8c;
        }

        .table td:last-child {
            border-bottom: none;
        }
    }
</style>
<div class="container">
    {{-- Tombol Kembali --}}
    <a href="{{ route('content.customer') }}" class="btn btn-secondary mb-3 mt-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Customer
    </a>

    {{-- KARTU DETAIL CUSTOMER --}}
    <div class="card mb-4">
        <div class="card-header">
            <h4>Detail Customer</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Travel:</strong><br>{{ $customer->nama_travel }}</p>
                    <p><strong>Email:</strong><br>{{ $customer->email }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Penanggung Jawab:</strong><br>{{ $customer->penanggung_jawab }}</p>
                    <p><strong>Telepon:</strong><br>{{ $customer->phone }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- KARTU DAFTAR KONTEN --}}
    <div class="card">
        <div class="card-header">
            <h4>Daftar Konten yang Dipesan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Konten</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($customer->services as $service)
                            @foreach ($service->contents as $contentItem)
                                <tr>
                                    <td data-label="No">{{ $no++ }}</td>
                                    <td data-label="Nama Konten">{{ $contentItem->content->name ?? 'N/A' }}</td>
                                    <td data-label="Jumlah">{{ $contentItem->jumlah }}</td>
                                    <td data-label="Keterangan">{{ $contentItem->keterangan ?? 'Tidak ada' }}</td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Pelanggan ini belum memesan konten apapun.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

     {{-- TOMBOL AKSI UNTUK MENGUBAH STATUS --}}
    <div class="mt-4 d-flex gap-2">
        {{-- Form untuk Pending --}}
        <form action="{{ route('customer.status.pending', $customer) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-warning">Ubah ke Pending</button>
        </form>

        {{-- Form untuk Selesai --}}
        <form action="{{ route('customer.status.selesai', $customer) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Ubah ke Selesai</button>
        </form>

        {{-- Form untuk Batal --}}
        <form action="{{ route('customer.status.batal', $customer) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan semua pesanan konten untuk customer ini?');">
            @csrf
            <button type="submit" class="btn btn-danger">Batalkan Semua</button>
        </form>
    </div>
</div>
@endsection
