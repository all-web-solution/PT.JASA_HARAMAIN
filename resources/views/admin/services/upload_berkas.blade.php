@extends('admin.master')

@section('content')
<div class="container">
    <h3>Upload Berkas Jamaah</h3>
    <form action="{{ route('service.storeBerkas') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="service_id" value="{{ $service_id }}">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pas Foto</th>
                    <th>Paspor</th>
                    <th>KTP</th>
                    <th>Visa</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < $total_jamaah; $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><input type="file" name="pas_foto[{{ $i }}]" class="form-control"></td>
                        <td><input type="file" name="paspor[{{ $i }}]" class="form-control"></td>
                        <td><input type="file" name="ktp[{{ $i }}]" class="form-control"></td>
                        <td><input type="file" name="visa[{{ $i }}]" class="form-control"></td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
