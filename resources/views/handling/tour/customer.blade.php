@extends('admin.master')
@section('title', 'Data Tour')
@section('content')
<div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Tour Customer List</h2>
            
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
                    <th>Nama Tour</th>
                    <th>Nama tranasportasi</th>
                    <th>Tanggal keberangatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tours as $tour)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $tour->service->pelanggan->nama_travel }}</td>
                    <td>{{ $tour->tourItem->name }}</td>
                    <td>{{ $tour->transportation->nama }}</td>
                    <td>{{ $tour->tanggal_keberangkatan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
