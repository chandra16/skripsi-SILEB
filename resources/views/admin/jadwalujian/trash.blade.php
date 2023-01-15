@extends('template_backend.home')

@section('heading', 'Trash Jadwal Ujian')

@section('page')
  <li class="breadcrumb-item active">Trash Jadwal Ujian</li>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title"><b>Trash Data Jadwal Ujian</b></h3>
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
                    <th>Aksi</th>
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
                    <td>
                        <form action="{{ route('jadwalUjian.kill', $data->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <a href="{{ route('jadwalUjian.restore', Crypt::encrypt($data->id)) }}" class="btn btn-success btn-sm mt-2"><i class="nav-icon fas fa-undo"></i> &nbsp; Restore</a>
                            <button class="btn btn-danger btn-sm mt-2"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            initNavbar();
        });
        
        function initNavbar() {
            $("#ViewTrash").addClass("active");
            $("#liViewTrash").addClass("menu-open");
            $("#TrashJadwalUjian").addClass("active");
        }
    </script>
@endsection