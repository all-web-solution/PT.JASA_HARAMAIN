@extends('admin.master')
@section('title', 'Catering List')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Meal List</h2>
            <a href="{{ route('catering.create') }}">
                <button class="btn btn-success">Tambah menu makanan</button>
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
                    <th>Nama menu</th>
                    <th>Harga</th>
                    <th>Aksi</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($meals as $meal)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$meal->name}}</td>
                        <td>{{$meal->price}}</td>
                        <td>
                            <a href="{{ route('catering.edit', $meal->id) }}">
                                <button class="btn btn-warning">Edit</button>
                            </a>
                            <form action="{{ route('catering.delete', $meal->id) }}" method="post">
                                @csrf
                                @method('delete')

                                <button class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
