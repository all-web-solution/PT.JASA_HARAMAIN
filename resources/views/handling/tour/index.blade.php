@extends('admin.master')
@section('title', 'Data Tour')
@section('content')
<div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Tour List</h2>
            <a href="{{ route('handling.tour.create') }}">
                <button class="btn btn-success">Tambah Tour</button>
            </a>
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
                    <th>Kendaraann yang di pilih</th>
                    <th>Tujuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tours as $tour)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$tour->service->pelanggan->nama_travel}}</td>
                    <td>{{$tour->transportation->nama}}</td>
                    <td>{{$tour->name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
