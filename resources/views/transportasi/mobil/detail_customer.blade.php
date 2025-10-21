@extends('admin.master')

@section('title', 'Detail Customer Transportasi Mobil')
@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Detail Customer Terkait</h2>
        <div class="card">
            <div class="card-body">
                {{--
                  Cek apakah relasi 'service' ada.
                  Gunakan 'optional helper' ($transportationItem->service->pelanggan->nama_travel ?? '-')
                  atau 'nullsafe operator' ($transportationItem->service?->pelanggan?->nama_travel ?? '-')
                  untuk keamanan jika data relasi (pelanggan) kosong.
                --}}
                @if ($transportationItem->service)
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>ID Service:</strong><br>
                            {{ $transportationItem->service->unique_code ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Travel:</strong><br>
                            {{ $transportationItem->service->pelanggan->nama_travel ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Penanggung Jawab:</strong><br>
                            {{ $transportationItem->service->pelanggan->penanggung_jawab ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Alamat:</strong><br>
                            {{ $transportationItem->service->pelanggan->alamat ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Email:</strong><br>
                            {{ $transportationItem->service->pelanggan->email ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Kontak:</strong><br>
                            {{ $transportationItem->service->pelanggan->phone ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Nomor KTP:</strong><br>
                            {{ $transportationItem->service->pelanggan->no_ktp ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Produk/Layanan:</strong><br>
                            {{ $transportationItem->service->services ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Status:</strong><br>
                            {{-- Ganti 'Aktif' dengan status dinamis jika ada --}}
                            <span class="badge bg-success">Aktif</span>
                        </div>
                    </div>
                @else
                    <p>Tidak ada data service yang terhubung dengan customer ini.</p>
                @endif
            </div>
        </div>

        @foreach ($transportationItem->service->transportationItem as $t)
            <h2 class="mb-4">Detail Transportasi Mobil</h2>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>Nama Transportasi:</strong><br>
                            {{ $t->transportation->nama }}
                        </div>
                        <div class="col-md-4">
                            <strong>Rute:</strong><br>
                            {{ $t->route->route }}
                        </div>
                        <div class="col-md-4">
                            <strong>Dari tanggal:</strong><br>
                            {{ $t->dari_tanggal }}
                        </div>
                        <div class="col-md-4">
                            <strong>Sampai tanggal</strong><br>
                            {{ $t->sampai_tanggal }}
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

