@extends('admin.master')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Customer meal list</h2>

        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama customer</th>
                    <th>Nama menu</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customerMeal as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->service->pelanggan->nama_travel }}</td>
                        <td>{{ $item->mealItem->name }}</td>
                        <td>{{ $item->jumlah }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
@endsection
