@extends('template_backend.home')
@section('heading', 'Data Mapel')
@section('page')
  <li class="breadcrumb-item active">Data Mapel</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
         @if (Auth::user()->role == 'Admin')
        <div class="card-header">
            <h3 class="card-title">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".tambah-mapel">
                    <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Mapel
                </button>
            </h3>
        </div>
        @endif
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Mapel</th>
                    <th>Paket</th>
                    <th>Tingkatan</th>
                     @if (Auth::user()->role == 'Admin'||Auth::user()->role == 'Kepsek')
                    <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($mapel as $result => $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->nama_mapel }}</td>
                    @if ( $data->paket_id == 9 )
                      <td>{{ 'Semua' }}</td>
                    @else
                      <td>{{ $data->paket->ket }}</td>
                    @endif
                    <td>{{ $data->angkatan }}</td>
                    
                         @if (Auth::user()->role == 'Admin')
                         <td>
                            <form action="{{ route('mapel.destroy', $data->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <a href="{{ route('mapel.edit', Crypt::encrypt($data->id)) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                            </form>
                        </td>
                        @elseif(Auth::user()->role == 'Kepsek') 
                        <td>
                            <a href="/guru/List/{{$data->id}}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Lihat Guru</a>
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

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-md tambah-mapel" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Tambah Data Mapel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('mapel.store') }}" method="post">
          @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <input type="hidden" id="tahun_ajaran" name="tahun_ajaran" value="{{isset($tahunajaran) ? $tahunajaran->nama : '0' }}">
                  <label for="nama_mapel">Nama Mapel</label>
                  <input type="text" id="nama_mapel" name="nama_mapel" class="form-control @error('nama_mapel') is-invalid @enderror" placeholder="{{ __('Nama Mata Pelajaran') }}">
                </div>
                <div class="form-group">
                  <label for="paket_id">Paket</label>
                  <select id="paket_id" name="paket_id" class="form-control @error('paket_id') is-invalid @enderror select2bs4">
                    <option value="">-- Pilih Paket Mapel --</option>
                    @foreach ($paket as $data)
                      <option value="{{ $data->id }}">{{ $data->ket }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="angkatan">Kelompok</label>
                    <select id="angkatan" name="angkatan" class="select2bs4 form-control @error('angkatan') is-invalid @enderror">
                      <option value="">-- Pilih Tingkatan --</option>
                      <option value="10">X</option>
                      <option value="11">XI</option>
                      <option value="12">XII</option>
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
    $("#DataMapel").addClass("active");
  </script>
@endsection