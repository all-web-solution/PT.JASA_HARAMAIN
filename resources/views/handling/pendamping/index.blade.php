@extends('admin.master')
@section('content')
<div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Pendamping List</h2>
            <a href="{{ route('handling.pendamping.create') }}">
                <button class="btn btn-success">Tambah pendamping</button>
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
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guides as $guide)
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$guide->nama}}</td>
                    <td>{{$guide->harga}}</td>
                    <td>{{$guide->keterangan}}</td>
                    <td>
                        <a href="{{ route('handling.pendamping.edit', $guide->id) }}">
                            <button class="btn btn-warning">Edit</button>
                        </a>
                        <form action="{{ route('handling.pendamping.destroy', $guide->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
