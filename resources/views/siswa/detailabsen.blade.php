@extends('template_backend.home')
@section('heading')
Data Absensi
@endsection
@section('page')
  <li class="breadcrumb-item active"><a href="{{ route('jadwal.index') }}">Absensi</a></li>
  <li class="breadcrumb-item active">{{ isset($siswa) ? $siswa->kelas_id : ''  }}</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $datas->nama_siswa}}</td>
                    <td>{{ $datas->kehadiran_id }}</td>
                    <td>{{$datas->file_name}}</td>
        
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->
@endsection
@section('script')
    <script>
        $("#MasterData").addClass("active");
        $("#liMasterData").addClass("menu-open");
        $("#DataJadwal").addClass("active");
    </script>
@endsection