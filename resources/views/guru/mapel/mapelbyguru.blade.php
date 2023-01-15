@extends('template_backend.home')
@section('heading', 'Mata Pelajaran')
@section('heading')
    Mapel Guru {{ Auth::user()->guru(Auth::user()->id_card)->nama_guru }}
@endsection
@section('page')
  <li class="breadcrumb-item active">Mata Pelajaran</li>
@endsection
@section('content')
<div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Mapel</th>
                    <th>Lihat Guru</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mapel as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama_mapel }}</td>
                        <td>
                            <a href="{{ route('guru.mapel', Crypt::encrypt($data->id)) }}" class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
<!-- /.col -->
@endsection
@section('script')
    <script>
        $("#MapelByGuru").addClass("active");
    </script>
@endsection