@extends('template_backend.home')
@section('heading', 'Tahun Ajaran')
@section('page')
  <li class="breadcrumb-item active">Tahun Ajaran</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">
              <button type="button" class="btn btn-primary btn-sm" onclick="getCreateKelas()" data-toggle="modal" data-target="#form-kelas">
                  <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Tahun Ajaran
              </button>
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tahun Ajaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tahunajaran as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>
                         <a href="{{ route('admin.listkelas.angkatan', $data->nama) }}" class="btn btn-info btn-sm"><i class="fas fa-calendar-alt nav-icon"></i> &nbsp; Lihat Data Tahun Ajaran</a>

                      
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

<div class="modal fade bd-example-modal-md" id="form-kelas" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="judul"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('tahunajaran.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" id="id" name="id">
              <div class="form-group" id="form_nama"></div>
              <div class="form-group" id="form_paket"></div>
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
    function getCreateKelas(){
      $("#judul").text('Tambah Tahun Ajaran');
      $('#id').val('');
      $('#form_nama').html(`
        <label for="nama">Tahun Ajaran</label>
        <input type='text' id="nama" onkeyup="this.value = this.value.toUpperCase()" name='nama' class="form-control @error('nama') is-invalid @enderror" placeholder="{{ __('mis: 2021-2022') }}">
      `);
      $('#nama').val('');
  
    }

    $("#TahunAjaran").addClass("active");
    $("#liMasterData").addClass("menu-open");
  </script>
@endsection