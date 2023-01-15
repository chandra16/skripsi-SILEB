@extends('template_backend.home')
@section('heading', 'Buku Kerja')
@section('page')
  <li class="breadcrumb-item active">Buku Kerja</li>
@endsection
@section('content')
  
            <div class="col-12">
              <div class="card">
            
                        <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: auto;">
                  <table class="table table-head-fixed">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                   
                        <tr>
                            <td>1</td>
                            <td>Buku Kerja I</td>
                            <td>

                                <a type="button" class="btn btn-block bg-gradient-primary btn-xs" href="/bukukerja/1">Lihat</a>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Buku Kerja II</td>
                            <td>
                  
                                <a type="button" class="btn btn-block bg-gradient-primary btn-xs" href="/bukukerja/2">Lihat</a>
                            </td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Buku Kerja III</td>
                            <td>
                                <a type="button" class="btn btn-block bg-gradient-primary btn-xs" href="/bukukerja/3">Lihat</a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Buku Kerja IV</td>
                            <td>
                                <a type="button" class="btn btn-block bg-gradient-primary btn-xs" href="/bukukerja/{id}">Lihat</a>
                            </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
      
          <!-- /.row -->
@endsection
