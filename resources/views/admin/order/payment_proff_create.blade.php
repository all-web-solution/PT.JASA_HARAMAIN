@extends('admin.master')
@section('content')

<div class="container-fluid p-3">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 title-responsive-create-travel" style="color: var(--haramain-primary);">
                            <i class="bi bi-plus-circle me-2"></i>Tambah bukti pembayaran Baru
                        </h5>
                        <a href="{{ route('payment.proff', $order->id) }}" class="btn btn-sm" style="background-color: var(--haramain-light); color: var(--haramain-primary);">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment.proff.store', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <!-- Informasi Travel -->
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-none" style="background-color: var(--haramain-light);">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3" style="color: var(--haramain-primary);">
                                            <i class="bi bi-building me-2"></i>Informasi Travel
                                        </h6>
                                        <div class="mb-3">
                                            <label for="foto" class="form-label">Bukti transfer</label>
                                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
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
