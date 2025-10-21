@extends('admin.master')
@section('content')
    <div class="card-body pt-2 d-none d-md-block">

        {{--
        PERBAIKAN 1:
        Kondisi @if diubah dari ($guide->supplier->isEmpty())
        menjadi ($guide->isEmpty()) agar sesuai dengan
        data yang ditampilkan di dalam tabel.
    --}}
        @if ($guide->supplier === null)
            <div class="text-center py-5">
                <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Supplier</h5>
                <p class="text-muted">Mulai dengan menambahkan Supplier pertama Anda</p>
                <a href="{{ route('catering.supplier.create', $guide->id) }}" class="btn btn-primary btn-lg mt-3">
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
                            <td>{{ $guide->id }}</td>
                            <td>{{ $guide->supplier }}</td>
                            <td>{{ number_format($guide->harga_dasar, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>

                </table>
            </div>

        @endif
    </div>
@endsection
