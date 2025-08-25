@extends('admin.master')
@section('content')
<div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Handling List</h2>
            <a href="{{ route('handling.pendamping.create') }}">
                <button class="btn btn-success">Tambah Pendamping</button>
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
                    <th>Type</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guides as $guide)
                    <tr>
                    <th>{{$loop->iteration}}</th>
                    <th>{{$guide->pendamping_type}}</th>
                    <th>{{$guide->harga}}</th>
                    <th>
                        <a href="{{ route('handling.pendamping.edit', $guide->id) }}">
                            <button class="btn btn-warning">Edit</button>
                        </a>
                        <form action="{{ route('handling.pendamping.destroy', $guide->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
