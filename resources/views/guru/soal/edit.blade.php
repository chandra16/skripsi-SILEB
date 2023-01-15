@extends('template_backend.home')
@section('heading', 'Edit Soal')
@section('page')
  <li class="breadcrumb-item active">Edit Materi</li>
@endsection
@section('content')


        <div class="col-md-12">
            <div class="card card-primary">
              
                <!-- /.card-header -->

                <div class="card-body">
                     <!-- Success And Fail/Error Alert -->
                    <!-- End of Success And Fail/Error Alert -->

                    <!-- Info Data Materi Lama sesuai id -->
                    <div class="callout callout-info">
                        <h6>Data lama untuk Soal ini :</h6>
                        <ul>
                            <li>Mata Pelajaran : {{ $materi->mapel }}</li>
                            <li>Kelas : {{ $materi->kelas }}</li>
                        </ul>
                    </div>


                <form role="form" action="/soal/Update/{{ $materi->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input name="mapel" type="hidden" value="{{ $materi->mapel }}">
                    <input name="kelas[]" type="hidden" value="{{ $materi->kelas }}">
                    <input name="angkatan" type="hidden" value="{{ $materi->angkatan }}">
                    
                    <div class="form-group row">
                        <label for="input2" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                          <input name="judul" type="text" class="form-control" id="input2" placeholder="Judul Materi" value="{{ $materi->judul }}">
                            @if($errors->has('judul'))
                                <div class="text-danger">
                                    {{ $errors->first('judul')}}
                                </div>
                            @endif
                        </div>
                    </div>
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
