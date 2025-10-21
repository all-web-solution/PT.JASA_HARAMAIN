@extends('admin.master')
@section('content')
    <div class="card-body pt-2 d-none d-md-block">

        {{--
        PERBAIKAN 1:
        Kondisi @if diubah dari ($documentChildren->supplier->isEmpty())
        menjadi ($documentChildren->isEmpty()) agar sesuai dengan
        data yang ditampilkan di dalam tabel.
    --}}
        @if ($documentChildren->supplier === null)
            <div class="text-center py-5">
                <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Supplier</h5>
                <p class="text-muted">Mulai dengan menambahkan Supplier pertama Anda</p>
                <a href="{{ route('visa.document.customer.detail.supplier.create', $documentChildren->id) }}" class="btn btn-primary btn-lg mt-3">
                    <i class="bi bi-plus-circle"></i> Tambah Supplier
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-haramain">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Supplier</th>
                            <th>Harga Dasar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $documentChildren->id }}</td>
                            <td>{{ $documentChildren->supplier }}</td>
                            <td>{{ number_format($documentChildren->harga_dasar, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>

                </table>
            </div>
           
        @endif
    </div>
@endsection
