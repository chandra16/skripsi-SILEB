@extends('template_backend.home')
@section('heading', 'Data Buku Kerja')
@section('page')
  <li class="breadcrumb-item active">Buku Kerja</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">

       @if (Auth::user()->role == 'Admin')
        <div class="card-header">
          <h3 class="card-title">
              <button type="button" class="btn btn-primary btn-sm" onclick="getCreateKelas()" data-toggle="modal" data-target="#form-kelas">
                  <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Buku kerja
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
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $datas->nama}}</td>
                     @if (Auth::user()->role == 'Admin')
                      <td>
                        <form method="post" action="/{{ route('kelas.destroy', $data->id) }}">
                          
                              @csrf
                              @method('delete')
                    
                              <a href="/bukukerja/download/{{$datas->file_name}}" class="btn btn-info btn-sm"><i class="fnav-icon fas fa-file-export"></i> &nbsp;Download</a>
                
                            
                                <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                              
                          </form>
                      </td>
                      @else
                        <td>
                          <a href="/bukukerja/download/{{$datas->file_name}}" class="btn btn-info btn-sm"><i class="fnav-icon fas fa-file-export"></i> &nbsp;Download</a>
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
        <form action="/bukukerja/create" method="post" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" id="id" name="id">
               <div class="form-group">
                        <label for="id_card">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror">
                        <input type="hidden" id="id_buku" name="id_buku" value="{{$id_buku}}">
                    </div>
              <div class="form-group">
                        <label for="foto">File</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input @error('foto') is-invalid @enderror" id="file">
                                <label class="custom-file-label" for="foto">Choose file</label>
                            </div>
                        </div>
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
  </script>
@endsection