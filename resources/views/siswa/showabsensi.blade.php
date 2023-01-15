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
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->tanggal }}</td>
                    <td>
                        @if($data->kehadiran_id=='1')
                            Hadir    
                        @elseif($data->kehadiran_id=='2')
                            Izin       
                        @elseif($data->kehadiran_id=='3')
                             Sakit
                        @else($data->kehadiran_id=='4'){ 
                            Tanpa Keterangan    
                        }
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