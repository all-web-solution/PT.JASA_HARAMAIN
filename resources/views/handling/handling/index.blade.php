@extends('admin.master')
@section('title', 'Data handling');
@section('content')
<div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Handling List</h2>
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
                    <th>Name Travel</th>
                    <th>Type</th>
                    <th>Nama Hotel</th>
                    <th>tanggal Hotel</th>
                    <th>Harga hotel</th>
                    <th>Pax</th>
                    <th>Nama Bandara</th>
                    <th>Jumlah jamaah</th>
                    <th>Harga bandara</th>
                    <th>kedatangan jammaj</th>
                    <th>
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
@endsection
