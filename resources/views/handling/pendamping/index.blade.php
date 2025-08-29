@extends('admin.master')
@section('content')
<div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Pendamping List</h2>
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
                    <th>Nama Customer</th>
                    <th>Nama Pendamping</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guides as $guide)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$guide->service->pelanggan->nama_travel}}</td>
                    <td>{{$guide->nama}}</td>
                    <td>{{$guide->jumlah}}</td>
                    <td>{{$guide->keterangan}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
