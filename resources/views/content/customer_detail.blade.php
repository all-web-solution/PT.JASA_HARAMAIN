@extends('admin.master')
@section('title', 'Detail customer')
@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Detail Customer Terkait</h2>
        <div class="card">
            <div class="card-body">
                @if ($customerDocument->service)
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>ID Service:</strong><br>
                            {{ $customerDocument->service->unique_code ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Travel:</strong><br>
                            {{ $customerDocument->service->pelanggan->nama_travel ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Penanggung Jawab:</strong><br>
                            {{ $customerDocument->service->pelanggan->penanggung_jawab ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Alamat:</strong><br>
                            {{ $customerDocument->service->pelanggan->alamat ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Email:</strong><br>
                            {{ $customerDocument->service->pelanggan->email ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Kontak:</strong><br>
                            {{ $customerDocument->service->pelanggan->phone ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Nomor KTP:</strong><br>
                            {{ $customerDocument->service->pelanggan->no_ktp ?? '-' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Produk/Layanan:</strong><br>
                            {{ $customerDocument->service->services ?? '-' }}
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

        <h2 class="mb-4">Dokumen yang di pilih</h2>
        @if ($customerDocument->document)
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>Nama Dokumen:</strong><br>
                            {{ $customerDocument->document->name ?? '-' }} - {{ $customerDocument->documentChild->name }}
                        </div>

                        {{-- Ganti 'type' dan 'document_number' dengan nama kolom yang sesuai di tabel 'documents' Anda --}}
                        <div class="col-md-4">
                            <strong>Jumlah:</strong><br>
                            {{ $customerDocument->jumlah ?? '-' }}

                        </div>
                        <div class="col-md-4">
                            <strong>Harga:</strong><br>
                            {{ $customerDocument->harga ?? '-' }}
                        </div>


                    </div>
                </div>
            </div>
        @else
            <p>Tidak ada data dokumen yang terhubung.</p>
        @endif

    </div>
    </div>
@endsection
