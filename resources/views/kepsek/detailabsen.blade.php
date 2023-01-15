@extends('template_backend.home')
@section('heading')
Data Absensi
@endsection
@section('page')
  <li class="breadcrumb-item active"><a href="">Absensi</a></li>
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
                    <th>Tanggal</th>
                    <th>Jam Absen</th>
                    <th>Status</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$datas->nama_siswa}}</td>
                    <td>{{ $datas->tanggal }}</td>
                    <td>{{$datas->jamkehadiran()}}</td>
                    <td>
                        @if($datas->kehadiran_id=='1')
                            Hadir    
                        @elseif($datas->kehadiran_id=='2')
                            Izin       
                        @elseif($datas->kehadiran_id=='3')
                             Sakit
                        @else($datas->kehadiran_id=='4'){ 
                            Tanpa Keterangan    
                        }
                         @endif
                    </td>
                    <td>
                        @if($datas->kehadiran_id=='3')
                             <a href="/dokumen/absensi/{{$datas->file_name}}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Download</a>
                        @endif
                    </td>
                    
                   
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