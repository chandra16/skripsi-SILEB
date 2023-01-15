@extends('template_backend.home')
@section('heading')
Data Jadwal Ujian {{ isset($kelas[0]) ? $kelas[0]->nama_kelas : ''  }}
@endsection
@section('page')
<li class="breadcrumb-item active"><a href="{{ route('jadwalUjian.index') }}">Jadwal Ujian</a></li>
<li class="breadcrumb-item active">{{ isset($kelas[0]) ? $kelas[0]->nama_kelas : ''  }}</li>
@endsection
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <a href="{{ route('jadwalUjian.index') }}" class="btn btn-default btn-sm"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Jadwal</th>
            <th>Jam Pelajaran</th>
            <th>Ruang Kelas</th>
            @if (Auth::user()->role == 'Admin')
            <th>Aksi</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @foreach ($jadwal as $data)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $data->tanggal }}</td>
            <td>{{ $data->tipeUjian->nama }}</td>
            <td>
              <h5 class="card-title">{{ $data->mapel->nama_mapel }}</h5>
              <p class="card-text"><small class="text-muted">{{ $data->guru->nama_guru }}</small></p>
            </td>
            <td>{{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
            <td>{{ $data->ruang->nama_ruang }}</td>
            @if (Auth::user()->role == 'Admin')
            <td>
              <form action="{{ route('jadwalUjian.destroy', $data->id) }}" method="post">
                @csrf
                @method('delete')
                <a href="{{ route('jadwalUjian.showJadwalEdit', ['id' => Crypt::encrypt($data->id), 'tahunajaran' => $tahunajaran]) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
              </form>
            </td>
            @endif
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
  $("#DataJadwalUjian").addClass("active");
</script>
@endsection