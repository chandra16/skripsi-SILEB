@extends('template_backend.home')
@section('heading')
@section('heading', 'List Mata Pelajaran')
@endsection
@section('page')
  <li class="breadcrumb-item active">Mata Pelajaran</li>
@endsection
@section('content')

        <!-- Small boxes (Stat box) -->

        @foreach ($mapel->chunk(4) as $mapel)
     
          <!-- Show List of Mapels -->
           @foreach ($mapel as $val => $data)
            <?php $data = $data[0]; ?>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h4>{{ $data->mapel->nama_mapel }}</h4>
                    <br>
                  
                </div>
                <div class="icon">
                    <i class="fas fa-address-book"></i>
                </div>
                <a href="/absensi/{{$kelas->nama_kelas}}/{{$data->mapel->id}}/{{$kelas->angkatan}}" class="small-box-footer">Lihat Absensi <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
          @endforeach

        @endforeach

@endsection