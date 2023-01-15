@extends('template_backend.home')
@section('heading')
Absen Siswa {{ isset($nama_kelas) ? $nama_kelas : '' }}
@endsection
@section('page')
  <li class="breadcrumb-item active"><a href="{{ route('siswa.index') }}">Absen Siswa</a></li>
  <li class="breadcrumb-item active">{{ isset($kelas[0]) ? $kelas[0]->nama_kelas : '' }}</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card"
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>No Induk</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa as $data)
               
                    <tr>
                          <form action="{{ route('guru.absensi.input') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama_siswa }}</td>
                        <td>{{ $data->no_induk }}</td>
                        <td>
                        
                              <select id="kehadiran_id" type="text" class="form-control" name="kehadiran_id" onchange="getValueSelect(this,'{{$data->no_induk}}')">
                                <option value="">Pilih Keterangan Kehadiran</option>
                                @foreach ($kehadiran as $datas)
                                  <option value="{{ $datas->id }}">{{ $datas->ket }}</option>
                                @endforeach
                                <input type="file" name="{{$data->no_induk}}" class="{{$data->no_induk}}" placeholder="Choose file" id="{{$data->no_induk}}" style="display:none;">
                              </select>
                        </td>
                        
                        <td>
                            @if($data->absensiCheck($data->nama_siswa,$jadwal_id)==0)
                            <input type="hidden" id="nama_kelas" name="nama_kelas" value="{{$data->kelas_id }}">
                            <input type="hidden" id="mapel_id" name="mapel_id" value="{{$nama_mapel}}">
                              <input type="hidden" id="no_induk" name="no_induk" value="{{$data->no_induk}}">
                            <input type="hidden" id="nama_siswa" name="nama_siswa" value="{{$data->nama_siswa}}">
                            <input type="hidden" id="tahun_ajaran" name="tahun_ajaran" value="{{$data->tahun_ajaran}}">
                            <input type="hidden" id="jadwal_id" name="jadwal_id" value="{{$jadwal_id}}">
                            <input type="hidden" id="angkatan" name="angkatan" value="{{$data->angkatan}}">
                            <button name="submit" type="submit" class="btn btn-info btn-sm mt-2"><i class="nav-icon fas fa-id-card"></i> &nbsp;Absen</button>

                            @else
                                <a class="btn btn-primary btn-sm"><i class="nav-icon fas fa-pen"></i> &nbsp; Telah Absen</a></td>
                            @endif
                        </td>
                    </form>
                    </tr>
            
                @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
@section('script')
 <script>
    function getValueSelect(selectObject,id){
       var values = selectObject.value;  
          if (values == "2") {
            $('#'+id).show();
          } 
          else if (values == "3") {
            $('#'+id).show();
          } else {
            $('#'+id).hide(); 
          }
    }
</script>
@endsection