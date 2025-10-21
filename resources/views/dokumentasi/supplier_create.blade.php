@extends('admin.master')
@section('content')

<div class="container-fluid p-3">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 title-responsive-create-travel" style="color: var(--haramain-primary);">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Supplier Baru
                        </h5>
                        <a href="{{ route('content.supplier', $content->id) }}" class="btn btn-sm" style="background-color: var(--haramain-light); color: var(--haramain-primary);">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    {{--
                        PERBAIKAN 1: Form Action Route
                        Route diubah dari 'admin.pelanggan.store' ke route yang lebih logis
                        untuk menyimpan supplier yang terkait dengan dokumen/layanan ini.
                        (Anda mungkin perlu membuat route ini di web.php)
                    --}}
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        {{--
                            CATATAN:
                            Anda bisa juga mengirimkan service_id sebagai input tersembunyi
                            jika routenya tidak menerima parameter.
                            <input type="hidden" name="service_id" value="{{ $content->id }}">
                        --}}

                        <div class="row g-3">
                            <div class="col-md-6">
                                {{--
                                    PERBAIKAN 2: Judul Card
                                    Diubah dari "Informasi Travel" menjadi "Informasi Supplier"
                                --}}
                                <div class="card h-100 border-0 shadow-none" style="background-color: var(--haramain-light);">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3" style="color: var(--haramain-primary);">
                                            <i class="bi bi-building me-2"></i>Informasi Supplier
                                        </h6>

                                        {{--
                                            PERBAIKAN 3: Input Nama Supplier
                                            Label: "Nama Supplier" (Sudah Benar)
                                            Input name/id: Diubah dari 'nama_travel' menjadi 'name'
                                            (Sesuai migrasi Supplier yang kita buat sebelumnya)
                                        --}}
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Supplier</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>

                                        {{--
                                            PERBAIKAN 4: Input Harga
                                            Label: "Harga dasar" (Sesuai keinginan Anda)
                                            Input type: Diubah dari 'email' menjadi 'number'
                                            Input name/id: Diubah dari 'email' menjadi 'price'
                                            (Sesuai migrasi pivot table yang kita buat)
                                        --}}
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Harga dasar</label>
                                            <input type="number" class="form-control" id="price" name="price" required>
                                        </div>

                                        {{--
                                            TAMBAHAN OPSIONAL:
                                            Anda mungkin ingin menambahkan field lain untuk Supplier
                                            dari migrasi yang kita buat (phone, contact_person, dll.)
                                        --}}


                                    </div>
                                </div>
                            </div>

                            {{-- Anda bisa menggunakan col-md-6 di sini untuk info lain jika perlu --}}

                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn" style="background-color: var(--haramain-secondary); color: white;">
                                <i class="bi bi-save me-1"></i> Simpan Supplier
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
