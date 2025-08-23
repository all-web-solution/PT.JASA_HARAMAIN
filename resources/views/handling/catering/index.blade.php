@extends('admin.master')
@section('title', 'Catering List')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Catering List</h2>
            <a href="{{ route('catering.create') }}" class="btn btn-primary">Add New Catering</a>
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
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cateringItems as $catering)
                    <tr>
                        <td>{{ $catering->id }}</td>
                        <td>{{ $catering->name }}</td>
                        <td>{{ $catering->description }}</td>
                        <td>{{ $catering->price }}</td>
                        <td>
                            <a href="{{ route('catering.edit', $catering->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('catering.delete', $catering->id) }}" method="POST"
                                onsubmit="return confirm('Yakin mau hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
