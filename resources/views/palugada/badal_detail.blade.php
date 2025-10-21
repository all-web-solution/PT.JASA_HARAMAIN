@extends('admin.master')
@section('content')

<div class="container mt-4">
    <h2 class="mb-4">Detail Customer Terkait</h2>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Informasi Customer</h5>
        </div>
        <div class="card-body">
            {{-- BAGIAN INI: Gunakan variabel $service --}}
            <dl class="row g-3">
                <dt class="col-sm-3">ID Service</dt>
                <dd class="col-sm-9">: {{ $service->unique_code }}</dd>

                <dt class="col-sm-3">Nama Travel</dt>
                <dd class="col-sm-9">: {{ $service->pelanggan->nama_travel }}</dd>

                <dt class="col-sm-3">Penanggung Jawab</dt>
                <dd class="col-sm-9">: {{ $service->pelanggan->penanggung_jawab }}</dd>

                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9">: {{ $service->pelanggan->alamat }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">: {{ $service->pelanggan->email }}</dd>

                <dt class="col-sm-3">Kontak</dt>
                <dd class="col-sm-9">: {{ $service->pelanggan->phone }}</dd>

                <dt class="col-sm-3">Nomor KTP</dt>
                <dd class="col-sm-9">: {{ $service->pelanggan->no_ktp }}</dd>

                <dt class="col-sm-3">Produk/Layanan</dt>
                <dd class="col-sm-9">: {{ $service->services }}</dd>

                <dt class="col-sm-3">Status Customer</dt>
                <dd class="col-sm-9">
                    @php
                        // Ganti 'status' dengan field yang sesuai
                        $status = $service->pelanggan->status ?? 'Aktif';
                        $badgeClass = $status === 'Aktif' ? 'bg-success' : 'bg-secondary';
                    @endphp
                    : <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                </dd>
            </dl>
        </div>
    </div>

    <h2 class="mb-4 mt-5">Daftar Badal untuk Service ini</h2>

    {{--
        BAGIAN INI: Loop menggunakan $semuaItemBadal.
        $item sekarang adalah satu objek Badal (bukan string).
        Anda harus memanggil field/property-nya (misal: $item->nama_dibadalkan, $item->jumlah, dll)
    --}}
    @forelse ($semuaItemBadal as $item)
        <div class="card mb-3">
            <div class="card-body">

                {{-- Ganti 'nama_dibadalkan' dengan field yang sesuai di tabel badal Anda --}}
                <h5 class="card-title">{{ $item->nama_dibadalkan ?? 'Data Badal' }}</h5>

                <dl class="row">

                    {{-- Ganti 'jumlah' dengan field yang sesuai --}}
                    <dt class="col-sm-3">Nama badal</dt>
                    <dd class="col-sm-9">: {{ $item->name ?? "Belum ada nama" }}</dd>
                    <dt class="col-sm-3">Harga badal</dt>
                    <dd class="col-sm-9">: {{ $item->price ?? 0 }}</dd>

                    {{-- Ganti 'tanggal_pelaksanaan' dengan field yang sesuai --}}
                    <dt class="col-sm-3">Tanggal pelaksanaan</dt>
                    <dd class="col-sm-9">: {{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d M Y') : '-' }}</dd>

                    {{-- Ganti 'status' dengan field yang sesuai --}}
                    <dt class="col-sm-3">Status Item</dt>
                    <dd class="col-sm-9">
                        @php
                            $itemStatus = $item->status ?? 'Pending'; // Ambil dari field 'status'
                            $itemBadge = 'bg-secondary';
                            if ($itemStatus === 'Completed' || $itemStatus === 'Selesai') $itemBadge = 'bg-success';
                            if ($itemStatus === 'Pending' || $itemStatus === 'Proses') $itemBadge = 'bg-warning text-dark';
                        @endphp
                        : <span class="badge {{ $itemBadge }}">{{ $itemStatus }}</span>
                    </dd>

                </dl>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada data badal yang dipilih untuk service ini.
        </div>
    @endforelse

</div>
@endsection
