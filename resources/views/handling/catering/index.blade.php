@extends('admin.master')
@section('title', 'Catering List')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Catering List</h2>

        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama customer</th>
                    <th>Nama makanan</th>
                    <th>Jumlah</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach ($meals as $meal)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$meal->service->pelanggan->nama_travel}}</td>
                        <td>{{$meal->nama}}</td>
                        <td>{{$meal->jumlah}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
