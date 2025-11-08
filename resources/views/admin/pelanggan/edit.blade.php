@extends('admin.master')
@section('title', 'Edit Travel')
@push('styles')
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--haramain-accent:#3d8bfd;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--checked-color:#2a6fdb;--success-color:#28a745;--warning-color:#ffc107;--danger-color:#dc3545}.travel-create-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:#f8fafd}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden;transition:transform 0.3s ease,box-shadow 0.3s ease}.card:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgb(0 0 0 / .1)}.card-header{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem;display:flex;align-items:center;justify-content:space-between}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.card-title i{font-size:1.5rem;color:var(--haramain-secondary)}.card-body{padding:1.5rem}.form-section{margin-bottom:2rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border-color)}.form-section:last-of-type{border-bottom:none;margin-bottom:0;padding-bottom:0}.form-section-title{font-size:1.1rem;color:var(--haramain-primary);margin-bottom:1.5rem;display:flex;align-items:center;gap:8px;font-weight:600}.form-section-title i{color:var(--haramain-secondary)}.form-group{margin-bottom:1.25rem}.form-label{display:block;margin-bottom:.5rem;font-weight:600;color:var(--text-primary)}.form-control,.form-select{width:100%;padding:.75rem 1rem;border:1px solid var(--border-color);border-radius:8px;font-size:1rem;transition:border-color 0.3s ease}.form-control:focus,.form-select:focus{outline:none;border-color:var(--haramain-secondary);box-shadow:0 0 0 3px rgb(42 111 219 / .1)}.form-text{font-size:.875rem;color:var(--text-secondary);margin-top:.25rem}.form-row{display:flex;gap:1.5rem;margin-bottom:1.25rem}.form-row:last-child{margin-bottom:0}.form-col{flex:1}.btn{padding:.75rem 1.5rem;border-radius:8px;font-weight:600;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;border:none;cursor:pointer;text-decoration:none}.btn-primary{background-color:var(--haramain-secondary);color:#fff}.btn-primary:hover{background-color:var(--haramain-primary);transform:translateY(-2px);box-shadow:0 4px 8px rgb(26 75 140 / .3)}.btn-secondary{background-color:#fff;color:var(--text-secondary);border:1px solid var(--border-color)}.btn-secondary:hover{background-color:#f8f9fa;color:var(--text-secondary)}.form-actions{display:flex;justify-content:flex-end;gap:1rem;margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--border-color)}@media (max-width:768px){.form-row{flex-direction:column;gap:0;margin-bottom:0}.form-row .form-col{margin-bottom:1.25rem}.form-row .form-col:last-child{margin-bottom:0}.form-actions{flex-direction:column}.btn{width:100%;justify-content:center}}
    </style>
@endpush

@section('content')
    <div class="travel-create-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-pencil-square"></i> Edit Travel/Pelanggan
                </h5>
                <a href="{{ route('admin.pelanggan') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger"
                        style="margin-bottom: 1.5rem; padding: 1rem; border-radius: 8px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                        <ul style="margin: 0; padding-left: 1.25rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.pelanggan.update', $pelanggan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="bi bi-building"></i> Informasi Travel
                                </h6>

                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="nama_travel" class="form-label">Nama Travel</label>
                                            <input type="text"
                                                class="form-control @error('nama_travel') is-invalid @enderror"
                                                id="nama_travel" name="nama_travel"
                                                value="{{ old('nama_travel', $pelanggan->nama_travel) }}" required>
                                            @error('nama_travel')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email', $pelanggan->email) }}"
                                                required>
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status"
                                                name="status" required>
                                                <option value="active"
                                                    {{ old('status', $pelanggan->status) == 'active' ? 'selected' : '' }}>
                                                    Aktif
                                                </option>
                                                <option value="inactive"
                                                    {{ old('status', $pelanggan->status) == 'inactive' ? 'selected' : '' }}>
                                                    Non-Aktif</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="foto" class="form-label">Ganti Logo/Foto Travel
                                                (Opsional)</label>

                                            <!-- Pratinjau Foto Saat Ini -->
                                            {{-- <div class="mb-2">
                                                <small>Foto Saat Ini:</small><br>
                                                @if ($pelanggan->foto)
                                                    <img src="{{ Storage::url($pelanggan->foto) }}" alt="Logo/Foto Travel"
                                                        style="max-height: 80px; border-radius: 4px; margin-top: 5px;">
                                                @else
                                                    <span class="text-muted">(Tidak ada foto)</span>
                                                @endif
                                            </div> --}}

                                            <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                                id="foto" name="foto" accept="image/*">
                                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto. (Max:
                                                2MB)</small>
                                            @error('foto')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="bi bi-person-badge"></i> Informasi Penanggung Jawab
                                </h6>

                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="penanggung_jawab" class="form-label">Nama Penanggung Jawab</label>
                                            <input type="text"
                                                class="form-control @error('penanggung_jawab') is-invalid @enderror"
                                                id="penanggung_jawab" name="penanggung_jawab"
                                                value="{{ old('penanggung_jawab', $pelanggan->penanggung_jawab) }}"
                                                required>
                                            @error('penanggung_jawab')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="no_ktp" class="form-label">Nomor KTP</label>
                                            <input type="number" class="form-control @error('no_ktp') is-invalid @enderror"
                                                id="no_ktp" name="no_ktp"
                                                value="{{ old('no_ktp', $pelanggan->no_ktp) }}" required>
                                            @error('no_ktp')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">Nomor Telepon/HP</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" name="phone"
                                                value="{{ old('phone', $pelanggan->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Perbarui Travel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
