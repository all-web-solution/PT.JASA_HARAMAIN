@extends('admin.master')

@section('content')
<div class="container-fluid py-3">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="mb-3 fw-bold" style="color: var(--haramain-primary);">
                <i class="bi bi-upload me-2"></i> Upload Berkas Jamaah
            </h4>

            <form action="{{ route('service.storeBerkas') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service_id }}">

                <!-- Tabel tampilan laptop -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Pas Foto</th>
                                <th>Paspor</th>
                                <th>KTP</th>
                                <th>Visa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < $total_jamaah; $i++)
                                <tr>
                                    <td class="fw-bold">{{ $i + 1 }}</td>
                                    <td><input type="file" name="pas_foto[{{ $i }}]" class="form-control"></td>
                                    <td><input type="file" name="paspor[{{ $i }}]" class="form-control"></td>
                                    <td><input type="file" name="ktp[{{ $i }}]" class="form-control"></td>
                                    <td><input type="file" name="visa[{{ $i }}]" class="form-control"></td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                <!-- Tampilan mobile -->
                <div class="d-block d-md-none">
                    @for ($i = 0; $i < $total_jamaah; $i++)
                        <div class="card mb-3 border">
                            <div class="card-body">
                                <h6 class="fw-bold mb-2 text-primary">Jamaah {{ $i + 1 }}</h6>
                                <div class="mb-2">
                                    <label class="form-label small mb-1">Pas Foto</label>
                                    <input type="file" name="pas_foto[{{ $i }}]" class="form-control form-control-sm">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small mb-1">Paspor</label>
                                    <input type="file" name="paspor[{{ $i }}]" class="form-control form-control-sm">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small mb-1">KTP</label>
                                    <input type="file" name="ktp[{{ $i }}]" class="form-control form-control-sm">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small mb-1">Visa</label>
                                    <input type="file" name="visa[{{ $i }}]" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-cloud-arrow-up"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        h4 {
            text-align: center;
            font-size: 1.1rem;
        }
        button.btn {
            width: 100%;
        }
    }
</style>
@endsection
