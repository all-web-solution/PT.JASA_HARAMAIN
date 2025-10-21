@extends('admin.master')
@section('title', 'Detail Pesawat')
@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Detail Service Terkait</h2>
        <div class="card">
            <div class="card-body">
                {{--
                  Cek apakah relasi 'service' ada.
                  Gunakan 'optional helper' ($plane->service->pelanggan->nama_travel ?? '-')
                  atau 'nullsafe operator' ($plane->service?->pelanggan?->nama_travel ?? '-')
                  untuk keamanan jika data relasi (pelanggan) kosong.
                --}}
                @if ($plane->service)
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>ID Service:</strong><br>
                            {{ $plane->service->unique_code ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Travel:</strong><br>
                            {{ $plane->service->pelanggan->nama_travel ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Penanggung Jawab:</strong><br>
                            {{ $plane->service->pelanggan->penanggung_jawab ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Alamat:</strong><br>
                            {{ $plane->service->pelanggan->alamat ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Email:</strong><br>
                            {{ $plane->service->pelanggan->email ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Kontak:</strong><br>
                            {{ $plane->service->pelanggan->phone ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Nomor KTP:</strong><br>
                            {{ $plane->service->pelanggan->no_ktp ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Produk/Layanan:</strong><br>
                            {{ $plane->service->services ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Status:</strong><br>
                            {{-- Ganti 'Aktif' dengan status dinamis jika ada --}}
                            <span class="badge bg-success">Aktif</span>
                        </div>
                    </div>
                @else
                    <p>Tidak ada data service yang terhubung dengan pesawat ini.</p>
                @endif
            </div>
        </div>

        <h2 class="mb-4">Detail Pesawat</h2>
        @foreach ($plane->service->planes as $p)
            <div class="card mb-4"> {{-- Tambahkan mb-4 untuk memberi jarak --}}
                <div class="card-body">
                    <h5 class="card-title">Maskapai: {{ $p->maskapai }}</h5>
                    <p class="card-text"><strong>Service ID:</strong> {{ $p->service_id }}</p>
                    <p class="card-text"><strong>Rute:</strong> {{ $p->rute }}</p>
                    <p class="card-text"><strong>Harga tiket:</strong> {{ $p->harga }}</p>
                    <p class="card-text"><strong>Keterangan:</strong> {{ $p->keterangan }}</p>
                    <p class="card-text"><strong>Jumlah jamaah:</strong> {{ $p->jumlah_jamaah }}</p>
                    <p>
                        <a href="{{ route('transportation.plane.edit', $p->id) }}">
                            <button class="btn btn-warning">Tambah Harga tiket</button>
                        </a>
                    </p>
                </div>

            </div>
        @endforeach


        <a href="{{ route('transportation.plane.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection
