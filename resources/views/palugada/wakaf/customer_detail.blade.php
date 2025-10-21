@extends('admin.master')
@section('content')


<div class="container mt-4">
    <h2 class="mb-4">Detail Customer Terkait</h2>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Informasi Customer</h5>
        </div>
        <div class="card-body">
            {{-- Menggunakan Definition List (dl) untuk tampilan key-value yang rapi --}}
            <dl class="row g-3">
                <dt class="col-sm-3">ID Service</dt>
                <dd class="col-sm-9">: {{ $wakafCustomers->service->unique_code }}</dd>

                <dt class="col-sm-3">Nama Travel</dt>
                <dd class="col-sm-9">: {{ $wakafCustomers->service->pelanggan->nama_travel }}</dd>

                <dt class="col-sm-3">Penanggung Jawab</dt>
                <dd class="col-sm-9">: {{ $wakafCustomers->service->pelanggan->penanggung_jawab }}</dd>

                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9">: {{ $wakafCustomers->service->pelanggan->alamat }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">: {{ $wakafCustomers->service->pelanggan->email }}</dd>

                <dt class="col-sm-3">Kontak</dt>
                <dd class="col-sm-9">: {{ $wakafCustomers->service->pelanggan->phone }}</dd>

                <dt class="col-sm-3">Nomor KTP</dt>
                <dd class="col-sm-9">: {{ $wakafCustomers->service->pelanggan->no_ktp }}</dd>

                <dt class="col-sm-3">Produk/Layanan</dt>
                <dd class="col-sm-9">: {{ $wakafCustomers->service->services }}</dd>

                <dt class="col-sm-3">Status Customer</dt>
                <dd class="col-sm-9">
                    {{-- Ganti 'status' dengan field yang sesuai dari pelanggan Anda --}}
                    @php
                        $status = $wakafCustomers->service->pelanggan->status ?? 'Aktif';
                        $badgeClass = $status === 'Aktif' ? 'bg-success' : 'bg-secondary';
                    @endphp
                    : <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                </dd>
            </dl>
        </div>
    </div>

    <h2 class="mb-4 mt-5">Daftar Wakaf untuk Service ini</h2>

    {{--
      Loop ini akan menampilkan SEMUA item wakaf yang ada di 'service' ini.
      '$wakafCustomers->service->wakafs' mengakses relasi 'wakafs' dari model 'Service'.
    --}}
    @forelse ($wakafCustomers->service->wakafs as $itemWakaf)
        <div class="card mb-3">
            <div class="card-body">
                {{--
                  '$itemWakaf' di sini adalah satu instance dari 'WakafCustomer'.
                  '$itemWakaf->wakaf' mengakses relasi 'wakaf' dari 'WakafCustomer' ke model 'Wakaf' (produknya).
                --}}
                <h5 class="card-title">{{ $itemWakaf->wakaf->nama }}</h5>

                <dl class="row">
                    <dt class="col-sm-3">Jumlah</dt>
                    <dd class="col-sm-9">: {{ $itemWakaf->jumlah }}</dd>

                    {{--
                      Saya berasumsi Anda punya field 'nama_wakaf' (untuk atas nama siapa).
                      Ganti 'nama_wakaf' jika field Anda berbeda (cth: 'atas_nama').
                    --}}

                    {{-- Saya juga berasumsi ada field 'status' di sini --}}
                    <dt class="col-sm-3">Status Item</dt>
                    <dd class="col-sm-9">
                        @php
                            $itemStatus = $itemWakaf->status ?? 'Pending';
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
            Belum ada data wakaf yang dipilih untuk service ini.
        </div>
    @endforelse

</div>
@endsection
