@extends('admin.master')

@section('content')
<div class="container-fluid py-3">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="mb-3 fw-bold" style="color: var(--haramain-primary);">
                <i class="bi bi-upload me-2"></i> Upload Berkas Jamaah
            </h4>

            <form action="{{ route('service.storeBerkas', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf


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

                                <tr>
                                    <td class="fw-bold"></td>
                                    <td><input type="file" name="pas_foto" class="form-control"></td>
                                    <td><input type="file" name="paspor" class="form-control"></td>
                                    <td><input type="file" name="ktp" class="form-control"></td>
                                    <td><input type="file" name="visa" class="form-control"></td>
                                </tr>

                        </tbody>
                    </table>
                </div>

                <!-- Tampilan mobile -->
                <div class="d-block d-md-none">

                        <div class="card mb-3 border">
                            <div class="card-body">
                                <div class="mb-2">
                                    <label class="form-label small mb-1">Pas Foto</label>
                                    <input type="file" name="pas_foto_mobile" class="form-control form-control-sm">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small mb-1">Paspor</label>
                                    <input type="file" name="paspor_mobile" class="form-control form-control-sm">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small mb-1">KTP</label>
                                    <input type="file" name="ktp_mobile" class="form-control form-control-sm">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small mb-1">Visa</label>
                                    <input type="file" name="visa_mobile" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>

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
