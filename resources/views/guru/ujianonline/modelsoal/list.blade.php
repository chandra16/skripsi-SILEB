@extends('template_backend.home')

@section('heading')
Soal Ujian Online
@endsection

@section('page')
<li class="breadcrumb-item active"><a href="{{ route('guru.ujianOnline.listModelSoal') }}"> List Model Soal</a></li>
@endsection

@section('content')
<!-- .col -->
<div class="col-md-12">
  <div class="card">
    <!-- .card-header -->
    <div class="card-header">
      <table class="table table-bordered">
        <tr>
          <th width='30%'>Nama Mata Pelajaran</th>
          <td width='70%'>{{ $mapel->nama_mapel }}</td>
        </tr>
        <tr>
          <th width='30%'>Angkatan</th>
          <td width='70%'>{{ $mapel->angkatan }}</td>
        </tr>
      </table>
    </div>
    <!-- /.card-header -->
    <!-- .card-body -->
    <div class="card-body">
      <div class="form-group">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-model-soal">
          <i class="nav-icon fas fa-plus"></i> &nbsp; Tambah Model Soal
        </button>
      </div>

      <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>No.</th>
            <th>Tipe</th>
            <th>Nama Model</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($modelsoal as $data)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $data->tipeUjian->nama }}</td>
            <td>{{ $data->nama_model_soal }}</td>
            <td>
              <a href="{{ route('guru.ujianOnline.detailModelSoal', Crypt::encrypt($data->id)) }}" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-eye"></i> &nbsp; Detail Soal Ujian</a>
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

<!-- Modal -->
<!-- Add Soal Pilihan Berganda -->
<div id="tambah-model-soal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('guru.ujianOnline.addModelSoal') }}" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Model Soal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @csrf
          <input type='hidden' id="mapel_id" name="mapel_id" value="{{ $mapel->id }}">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nama-mapel">Mata Pelajaran</label>
                <input type='text' id="nama-mapel" name='nama-mapel' value={{ $mapel->nama_mapel }} class="form-control @error('nama-mapel') is-invalid @enderror" disabled>
              </div>
            </div>
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
            <div class="col-md-12">
              <div class="form-group">
                <label for="nama_model_soal">Nama Model Soal</label>
                <input type='text' id="nama_model_soal" name='nama_model_soal' class="form-control @error('nama_model_soal') is-invalid @enderror">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
          <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Add Soal Pilihan Berganda -->
<!-- Modal -->
@endsection

@section('script')
<script>
  $("#SoalUjianOnlineGuru").addClass("active");
  $("#UjianOnlineGuru").addClass("active");
  $("#liUjianOnlineGuru").addClass("menu-open");
</script>
@endsection