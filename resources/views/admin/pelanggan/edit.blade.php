@extends('admin.master')
@section('content')

<div class="container-fluid p-3">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 title-responsive-create-travel" style="color: var(--haramain-primary);">
                            <i class="bi bi-plus-circle me-2"></i>Edit Travel/Pelanggan
                        </h5>
                        <a href="{{ route('admin.pelanggan') }}" class="btn btn-sm" style="background-color: var(--haramain-light); color: var(--haramain-primary);">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pelanggan.update', $pelanggan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row g-3">
                            <!-- Informasi Travel -->
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-none" style="background-color: var(--haramain-light);">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3" style="color: var(--haramain-primary);">
                                            <i class="bi bi-building me-2"></i>Informasi Travel 
                                        </h6>
                                        
                                        <div class="mb-3">
                                            <label for="nama_travel" class="form-label">Nama Travel</label>
                                            <input type="text" class="form-control" id="nama_travel" name="nama_travel" value="{{$pelanggan->nama_travel}}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{$pelanggan->email}}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="active" selected>Aktif</option>
                                                <option value="inactive">Non-Aktif</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="foto" class="form-label">Logo/Foto Travel</label>
                                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                            <small class="text-muted">Format: JPEG, PNG, JPG (Max: 2MB)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Informasi Penanggung Jawab -->
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-none" style="background-color: var(--haramain-light);">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3" style="color: var(--haramain-primary);">
                                            <i class="bi bi-person-badge me-2"></i>Informasi Penanggung Jawab
                                        </h6>
                                        
                                        <div class="mb-3">
                                            <label for="penanggung_jawab" class="form-label">Nama Penanggung Jawab</label>
                                            <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" value="{{$pelanggan->penanggung_jawab}}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="no_ktp" class="form-label">Nomor KTP</label>
                                            <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="{{$pelanggan->no_ktp}}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Nomor Telepon/HP</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{$pelanggan->phone}}">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" id="phone" name="alamat" value="{{$pelanggan->alamat}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn" style="background-color: var(--haramain-secondary); color: white;">
                                <i class="bi bi-save me-1"></i> Simpan Travel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection