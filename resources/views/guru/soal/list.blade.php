@extends('template_backend.home')
@section('heading', 'Daftar Soal')
@section('page')
  <li class="breadcrumb-item active">Daftar Soal</li>
@endsection
@section('content')
   
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <form action="#" method="get">
                            @csrf
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button name="submit" type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                        <!-- /.card-header -->

                <div class="card-body table-responsive p-0" style="height: auto;">
                  <table class="table table-head-fixed">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Mapel</th>
                        <th>Kelas</th>
                        <th>Judul</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($materis as $materi )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $materi->mapel }}</td>
                            <td>{{ $materi->kelas }}</td>
                            <td><a href="/materi-data/download/{{$materi->file_name}}">{{$materi->judul}}</a></td>
                            <td>
                                <a type="button" class="btn btn-block bg-gradient-primary btn-xs" href="/soal/edit/{{ $materi->id }}">Edit</a>
                                <a type="button" class="btn btn-block bg-gradient-danger btn-xs" href="/soal/delete/{{ $materi->id }}">Delete</a>
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
          <!-- /.row -->
    <!-- /.content -->
@endsection
