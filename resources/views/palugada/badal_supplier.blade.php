@extends('admin.master')
@section('content')
    <div class="card-body pt-2 d-none d-md-block">
        @if ($badal->supplier === null)
            <div class="text-center py-5">
                <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Supplier</h5>
                <p class="text-muted">Mulai dengan menambahkan Supplier pertama Anda</p>
                <a href="{{ route('palugada.badal.supplier.create', $badal->id) }}" class="btn btn-primary btn-lg mt-3">
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
                            <td>{{ $badal->id }}</td>
                            <td>{{ $badal->supplier }}</td>
                            <td>{{ number_format($badal->harga_dasar, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>

                </table>
            </div>

        @endif

    </div>
@endsection
