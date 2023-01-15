@extends('template_backend.home')
@section('heading', 'Data Angkatan')
@section('page')
  <li class="breadcrumb-item active">Data Angkatan</li>
@endsection
@section('content')
  
            <div class="col-12">
              <div class="card">
            
                        <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: auto;">
                  <table class="table table-head-fixed">
                    <thead>
                      <tr>
                        <th>Tingkatan</th>
                        <th>Deskripsi</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                   
                        <tr>
                            <td>X</td>
                            <td>Seluruh Kelas 10</td>
                            <td>

                                <a type="button" class="btn btn-block bg-gradient-primary btn-xs" href="{{ route('admin.tahunajaran.listkelas',['id' => $tahunajaran, 'angkatan' => '10']) }}">Lihat</a>
                            </td>
                        </tr>

                        <tr>
                            <td>XI</td>
                            <td>Seluruh Kelas 11</td>
                            <td>
                  
                                <a type="button" class="btn btn-block bg-gradient-primary btn-xs" href="{{ route('admin.tahunajaran.listkelas',['id' => $tahunajaran, 'angkatan' => '11']) }}">Lihat</a>
                            </td>
                        </tr>

                        <tr>
                            <td>XII</td>
                            <td>Seluruh Kelas 12</td>
                            <td>
                                <a type="button" class="btn btn-block bg-gradient-primary btn-xs" href="{{ route('admin.tahunajaran.listkelas',['id' => $tahunajaran, 'angkatan' => '12']) }}">Lihat</a>
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
