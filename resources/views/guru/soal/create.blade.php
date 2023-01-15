@extends('template_backend.home')
@section('heading', 'Tambah Soal')
@section('page')
  <li class="breadcrumb-item active">Tambah Soal</li>
@endsection
@section('content')
  
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Soal</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                  
                    <!-- End of Success And Fail/Error Alert -->

                <form role="form" action="/soal/create" method="post" enctype="multipart/form-data">
                    @csrf
                    <input name="mapel" type="hidden" value="{{$guru->mapel->nama_mapel}}" class="form-control" id="input2">
                    <div class="form-group row">
                        <label for="input2" class="col-sm-2 col-form-label">Kelas</label>
                        <div class="col-sm-10">
                            <select name="kelas[]" multiple class="form-control">
                                @foreach($jadwal as $k)
                                    <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('kelas'))
                                <div class="text-danger">
                                    {{ $errors->first('kelas')}}
                                </div>
                            @endif
                        </div>
                    </div>
                     <input name="angkatan" type="hidden" class="form-control" id="angkatan" value="{{$angkatan}}">
                    <div class="form-group row">
                        <label for="input2" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                          <input name="judul" type="text" class="form-control" id="input2" placeholder="Judul Materi">
                            @if($errors->has('judul'))
                                <div class="text-danger">
                                    {{ $errors->first('judul')}}
                                </div>
                            @endif
                        </div>
                    </div>
                    

             <!--    <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input" id="chooseFile">
                    <label class="custom-file-label" for="chooseFile">Select file</label>
                 </div>
 -->
                <div class="col-md-12">
                  <div class="form-group">
                      <input type="file" name="file" placeholder="Choose file" id="chooseFile">
                        @error('file')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                  </div>
                </div>

                    <button name="submit" type="submit" class="btn btn-block bg-gradient-primary">Upload</button>
                </form>

                </div>
                <!-- /.card-body -->
            </div>

            <!-- /.card -->
            <div class="d-none" id="card-refresh-content">
                The body of the card after card refresh
            </div>
        </div>
        <!-- /.col -->
    <!-- /.content -->
    <script>
        var CSRFToken = $('meta[name="csrf-token"]').attr('content');
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token='+CSRFToken,
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='+CSRFToken
        };
    </script>
    <script>
        CKEDITOR.replace('ckeditor', options);
    </script>

@endsection

@section('script')
  <script>
    $("#MateriByClass").addClass("active");
  </script>
@endsection