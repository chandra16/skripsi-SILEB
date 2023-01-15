@extends('template_backend.home')
@section('heading', 'Edit Jadwal Ujian')
@section('page')
<li class="breadcrumb-item active"><a href="{{ route('jadwal.index') }}"> Jadwal</a></li>
<li class="breadcrumb-item active">Edit Jadwal Ujian</li>
@endsection
@section('content')
<div class="col-md-12">
  <!-- general form elements -->
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Edit Data Jadwal Ujian</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('jadwalUjian.store') }}" method="post">
      @csrf
      <div class="card-body">
        <div class="row">
          <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
          <input type='hidden' id="tahun_ajaran" name="tahun_ajaran" value="{{ $tahunajaran ?? '' }}">
          <div class="col-md-12">
            <div class="form-group">
              <label for="tipe_ujian_id">Tipe Ujian</label>
              <select id="tipe_ujian_id" name="tipe_ujian_id" class="form-control @error('tipe_ujian_id') is-invalid @enderror select2bs4">
                <option value="">-- Pilih tipe ujian --</option>
                @foreach ($tipeujian as $data)
                <option value="{{ $data->id }}" @if ($jadwal->tipe_ujian_id == $data->id) selected @endif >{{ $data->nama }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <!-- <div class="col-md-6">
            <div class="form-group">
              <label for="hari_id">Hari</label>
              <select id="hari_id" name="hari_id" class="form-control @error('hari_id') is-invalid @enderror select2bs4">
                <option value="">-- Pilih Hari --</option>
                @foreach ($hari as $data)
                <option value="{{ $data->id }}" @if ($jadwal->hari_id == $data->id) selected @endif >{{ $data->nama_hari }}</option>
                @endforeach
              </select>
            </div>
          </div> -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" id="tanggal" name="tanggal" value="{{ $jadwal->tanggal }}" class="form-control @error('tanggal') is-invalid @enderror">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="nama_kelas">Kelas</label>
              <select id="nama_kelas" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror select2bs4">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $data)
                <option value="{{ $data->nama_kelas }}" @if ($jadwal->nama_kelas == $data->nama_kelas) selected @endif >{{ $data->nama_kelas }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="jam_mulai">Jam Mulai</label>
              <input type='time' value="{{ $jadwal->jam_mulai }}" id="jam_mulai" name='jam_mulai' class="form-control @error('jam_mulai') is-invalid @enderror" placeholder='JJ:mm:dd'>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="jam_selesai">Jam Selesai</label>
              <input type='time' value="{{ $jadwal->jam_selesai }}" name='jam_selesai' class="form-control @error('jam_selesai') is-invalid @enderror" placeholder='JJ:mm:dd'>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="guru_id">Kode Mapel</label>
              <select id="guru_id" name="guru_id" class="form-control @error('guru_id') is-invalid @enderror select2bs4">
                <option value="" @if ($jadwal->guru_id) selected @endif>-- Pilih Kode Mapel --</option>
                @foreach ($guru as $data)
                <option value="{{ $data->id }}" @if ($jadwal->guru_id == $data->id) selected @endif >{{ $data->kode }}</option>
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
                <option value="{{ $data->id }}" @if ($jadwal->ruang_id == $data->id) selected @endif >{{ $data->nama_ruang }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="#" name="kembali" class="btn btn-default" id="back"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp;
        <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Update</button>
      </div>
    </form>
  </div>
  <!-- /.card -->
</div>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    $('#back').click(function() {
      window.location = "{{ route('jadwalUjian.showJadwal', ['id' => $jadwal->nama_kelas, 'tahunajaran' => $tahunajaran]) }}";
    });
  });


  $("#MasterData").addClass("active");
  $("#liMasterData").addClass("menu-open");
  $("#DataJadwalUjian").addClass("active");
</script>
@endsection