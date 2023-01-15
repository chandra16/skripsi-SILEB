@extends('template_backend.home')
@section('heading')
@section('heading', 'Materi
')
@endsection
@section('page')
  <li class="breadcrumb-item active">Materi & Soal</li>
@endsection
@section('content')
@foreach ($materis->chunk(4) as $materi)

          <!-- Show List of Mapels -->
          @foreach($materi as $m)
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                <div class="inner">
                    <h4>{{ $m->judul }}</h4>
                    <br>
                    <p style="line-height:0px;">{{ $m->mapel }}</p>
                    <p>{{ $m->kelas }}</P>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="/mapel/materi/{{ $m->id }}" class="small-box-footer">Lihat Materi Ini <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
          @endforeach

        </div>
        @endforeach

        
        @if($jumlahSoal>0)

        
          <p style="color: black;font-size:28px;text-align: left;">Soal</p> 

                @foreach ($soal->chunk(4) as $data)

                  <!-- Show List of Mapels -->
                  @foreach($data as $m)
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                        <div class="inner">
                            <h4>{{ $m->judul }}</h4>
                            <br>
                            <p style="line-height:0px;">{{ $m->mapel }}</p>
                            <p>{{ $m->kelas }}</P>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <a href="/materi/download/{{$m->file_name}}" class="small-box-footer">Download <i class="fas fa-download"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                  @endforeach

                </div>
                @endforeach

            @endif



@endsection