@extends('template_backend.home')
@section('heading')
@section('heading', 'Detail Materi')
@endsection
@section('page')
  <li class="breadcrumb-item active">Materi</li>
@endsection
@section('content')
  
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $singleMateri->judul }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! $singleMateri->isi !!}

                        <h2>Kesimpulan :</h2>
                        <p>{{ $singleMateri->kesimpulan }}</p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Description</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h4><strong>Info :</strong></h4>
                            <p><strong>Mata Pelajaran :</strong>  {{ $singleMateri->mapel }}</p>
                            <p><strong>Untuk Kelas :</strong>  {{ $singleMateri->kelas }}</p>
                            <br>
                            <h4><strong>Keterangan :</strong></h4>
                            <p>{{ $singleMateri->keterangan }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">{{ $singleMateri->file_name }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a href="/materi/download/{{$singleMateri->file_name}}" class="btn btn-block btn-outline-success" target="_blank">Download Materi</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>


@endsection