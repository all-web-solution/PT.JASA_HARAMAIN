@extends('admin.master')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Customer pendamping list</h2>

        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama customer</th>
                    <th>Nama pendamping</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guides as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->service->pelanggan->nama_travel }}</td>
                        <td>{{ $item->guideItem->nama}}</td>
                        <td>{{ $item->jumlah }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
@endsection
