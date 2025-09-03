@extends('admin.master')
@section('content')
  <!-- Services Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama customer</th>
                            <th>Pas Foto</th>
                            <th>Paspor</th>
                            <th>Ktp</th>
                            <th>Visa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                         <tr>
                            <td>{{$file->service->pelanggan->nama_travel}}</td>
                            <td><img src="{{ url('storage/' . $file->pas_foto) }}" alt="pas_foto" width="100" height="100"></td>
                            <td><img src="{{ url('storage/' . $file->paspor) }}" alt="pas_foto" width="100" height="100"></td>
                            <td><img src="{{ url('storage/' . $file->ktp) }}" alt="pas_foto" width="100" height="100"></td>
                            <td><img src="{{ url('storage/' . $file->visa) }}" alt="pas_foto" width="100" height="100"></td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
@endsection
