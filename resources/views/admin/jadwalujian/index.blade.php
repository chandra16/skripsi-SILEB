@extends('template_backend.home')
@section('heading', 'Data Jadwal Ujian')
@section('page')
<li class="breadcrumb-item active">Data Jadwal Ujian</li>
@endsection
@section('content')
<div class="col-md-12">
  <div class="card">
    @if (Auth::user()->role == 'Admin')
    <!-- .card-header -->
    <div class="card-header">
      <h3 class="card-title">
        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target=".tambah-jadwal-ujian">
          <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Jadwal
        </button>
      </h3>
    </div>
    <!-- /.card-header -->
    <!-- .card-body -->
    <div class="card-body">
      <table id="table-jadwal-ujian" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama Kelas</th>
            <th>Lihat Jadwal Ujian</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($kelas as $data)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $data->nama_kelas }}</td>
            <td>
              <a href="{{ route('jadwalUjian.showJadwal',['id' => $data->nama_kelas, 'tahunajaran' => $data->tahun_ajaran]) }}" class="btn btn-info btn-sm">
                <i class="nav-icon fas fa-search-plus"></i> &nbsp; Details
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
    @endif
  </div>

  <!-- Extra large modal -->
  <div class="modal fade bd-example-modal-lg tambah-jadwal-ujian" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Jadwal Ujian</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('jadwalUjian.store') }}" method="post">
            @csrf
            <input type='hidden' id="tahun_ajaran" name="tahun_ajaran" value="{{isset($tahunajaran) ? $tahunajaran->nama : '0' }}">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="tipe_ujian_id">Tipe Ujian</label>
                  <select id="tipe_ujian_id" name="tipe_ujian_id" class="form-control @error('tipe_ujian_id') is-invalid @enderror select2bs4">
                    <option value="">-- Pilih tipe ujian --</option>
                    @foreach ($tipeujian as $data)
                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input type="date" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nama_kelas">Kelas</label>
                  <select id="nama_kelas" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror select2bs4">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelas as $data)
                    <option value="{{ $data->nama_kelas }}">{{ $data->nama_kelas }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="jam_mulai">Jam Mulai</label>
                  <input type='text' id="jam_mulai" name='jam_mulai' class="form-control @error('jam_mulai') is-invalid @enderror jam_mulai" placeholder="{{ Date('H:i') }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="jam_selesai">Jam Selesai</label>
                  <input type='text' id="jam_selesai" name='jam_selesai' class="form-control @error('jam_selesai') is-invalid @enderror" placeholder="{{ Date('H:i') }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="guru_id">Kode Guru</label>
                  <select id="guru_id" name="guru_id" class="form-control @error('guru_id') is-invalid @enderror select2bs4">
                    <option value="">-- Pilih Kode Guru --</option>
                    @foreach ($guru as $data)
                    <option value="{{ $data->id }}">{{ $data->kode }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="ruang_id">Ruang Kelas</label>
                  <select id="ruang_id" name="ruang_id" class="form-control @error('ruang_id') is-invalid @enderror select2bs4">
                    <option value="">-- Pilih Ruang Kelas --</option>
                    @foreach ($ruang as $data)
                    <option value="{{ $data->id }}">{{ $data->nama_ruang }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
          <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endsection
  @section('script')
  <script>
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataJadwalUjian").addClass("active");
    $("#jam_mulai,#jam_selesai").timepicker({
      timeFormat: 'HH:mm'
    });
  </script>
  @endsection