@extends('admin.master')
@section('title', 'Tambah Karyawan')
@push('styles')
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--haramain-accent:#3d8bfd;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--checked-color:#2a6fdb;--success-color:#28a745;--warning-color:#ffc107;--danger-color:#dc3545}.service-create-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:#f8fafd}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden;transition:transform 0.3s ease,box-shadow 0.3s ease}.card:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgb(0 0 0 / .1)}.card-header{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem;display:flex;align-items:center;justify-content:space-between}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.card-title i{font-size:1.5rem;color:var(--haramain-secondary)}.card-body{padding:1.5rem}.form-section{margin-bottom:2rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border-color)}.form-section-title{font-size:1.1rem;color:var(--haramain-primary);margin-bottom:1rem;display:flex;align-items:center;gap:8px}.form-section-title i{color:var(--haramain-secondary)}.form-group{margin-bottom:1.25rem}.form-label{display:block;margin-bottom:.5rem;font-weight:600;color:var(--text-primary)}.form-control{width:100%;padding:.75rem 1rem;border:1px solid var(--border-color);border-radius:8px;font-size:1rem;transition:border-color 0.3s ease}.form-control:focus{outline:none;border-color:var(--haramain-secondary);box-shadow:0 0 0 3px rgb(42 111 219 / .1)}.form-text{font-size:.875rem;color:var(--text-secondary);margin-top:.25rem}.form-row{display:flex;gap:1rem;margin-bottom:1rem}.form-col{flex:1}.service-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;margin-bottom:1.5rem}.service-item{border:2px solid var(--border-color);border-radius:8px;padding:1.25rem;text-align:center;cursor:pointer;transition:all 0.3s ease;background-color:#fff}.service-item:hover{border-color:var(--haramain-secondary);transform:translateY(-5px);box-shadow:0 5px 15px rgb(0 0 0 / .1)}.service-item.selected{border-color:var(--haramain-secondary);background-color:var(--haramain-light)}.service-icon{font-size:2rem;color:var(--haramain-secondary);margin-bottom:.75rem}.service-name{font-weight:600;color:var(--text-primary);margin-bottom:.25rem}.service-desc{font-size:.875rem;color:var(--text-secondary)}.detail-form{background-color:var(--haramain-light);border-radius:8px;padding:1.5rem;margin-top:1.5rem}.detail-section{margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border-color)}.detail-section:last-child{margin-bottom:0;padding-bottom:0;border-bottom:none}.detail-title{font-weight:600;color:var(--haramain-primary);margin-bottom:1rem;display:flex;align-items:center;gap:8px}.detail-title i{color:var(--haramain-secondary)}.btn{padding:.75rem 1.5rem;border-radius:8px;font-weight:600;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;border:none;cursor:pointer}.btn-primary{background-color:var(--haramain-secondary);color:#fff}.btn-primary:hover{background-color:var(--haramain-primary);transform:translateY(-2px);box-shadow:0 4px 8px rgb(26 75 140 / .3)}.btn-secondary{background-color:#fff;color:var(--text-secondary);border:1px solid var(--border-color)}.btn-secondary:hover{background-color:#f8f9fa}.btn-submit{background-color:var(--success-color);color:#fff}.btn-submit:hover{background-color:#218838;transform:translateY(-2px);box-shadow:0 4px 8px rgb(40 167 69 / .3)}.form-actions{display:flex;justify-content:flex-end;gap:1rem;margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--border-color)}@media (max-width:576px){.service-create-container{padding:1rem}.card-header{flex-direction:column;align-items:flex-start;gap:.75rem}.form-row{flex-direction:column}.form-col{width:100%}input.form-control,select.form-control{font-size:.9rem}.card-body{padding:1rem}.btn{width:100%;justify-content:center}}
    </style>
@endpush
@section('content')
    <div class="service-create-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-plus-circle"></i>Tambah Karyawan Baru
                </h5>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
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

                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-building"></i> Data Travel
                        </h6>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="name" required
                                        value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Nama Panjang</label>
                                    <input type="text" class="form-control" name="full_name" required
                                        value="{{ old('full_name') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required
                                        value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" required
                                        value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" required
                                        value="{{ old('address') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="hotel" {{ old('role') == 'hotel' ? 'selected' : '' }}>Hotel</option>
                                <option value="handling" {{ old('role') == 'handling' ? 'selected' : '' }}>Handling
                                </option>
                                <option value="transportasi & tiket"
                                    {{ old('role') == 'transportasi & tiket' ? 'selected' : '' }}>Transportasi & Tiket
                                </option>
                                <option value="visa dan acara" {{ old('role') == 'visa dan acara' ? 'selected' : '' }}>Visa
                                    dan Acara</option>
                                <option value="reyal" {{ old('role') == 'reyal' ? 'selected' : '' }}>Reyal</option>
                                <option value="palugada" {{ old('role') == 'palugada' ? 'selected' : '' }}>Palugada
                                </option>
                                <option value="konten dan dokumentasi"
                                    {{ old('role') == 'konten dan dokumentasi' ? 'selected' : '' }}>Konten dan Dokumentasi
                                </option>
                                <option value="keuangan" {{ old('role') == 'keuangan' ? 'selected' : '' }}>Keuangan
                                </option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-check-circle"></i> Simpan Permintaan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
