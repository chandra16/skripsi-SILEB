@extends('template_backend.home')

@section('heading')
Data Jadwal Ujian
@endsection

@section('page')
<li class="breadcrumb-item active"><a href="{{ route('guru.ujianOnline.jadwal') }}">Jadwal Ujian</a></li>
@endsection

@section('content')
<!-- .col -->
<div class="col-md-12">
    <div class="card">
        <!-- .card-body -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal & Jam</th>
                        <th>Tipe</th>
                        <th>Mata Pelajaran</th>
                        <th>Ruang</th>
                        <th>Nama Kelas</th>
                        <th>Model Soal</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ date('l / d - F - Y', strtotime($data->tanggal)) }} <br>
                            ( <i>{{ date('H:i', strtotime($data->jam_mulai)) }} - {{ date('H:i', strtotime($data->jam_selesai)) }}</i> )
                        </td>
                        <td>{{ $data->tipeUjian->nama }}</td>
                        <td>
                            <h5 class="card-title">{{ $data->mapel->nama_mapel }}</h5>
                            <p class="card-text"><small class="text-muted">{{ $data->guru->nama_guru }}</small></p>
                        </td>
                        <td>{{ $data->ruang->nama_ruang }}</td>
                        <td>{{ $data->nama_kelas }}</td>
                        <td>{{ ($data->question_model_id) ? $data->questionModel->nama_model_soal : '-' }}</td>
                        <td>
                            <a href="{{ route('guru.ujianOnline.viewSetModelSoal', Crypt::encrypt($data->id)) }}" class="btn btn-success btn-sm" style="width: 100%; margin: 2px;">
                                <i class="nav-icon fas fa-pen"></i> &nbsp; Set Model Soal
                            </a>
                            <a href="{{ route('guru.ujianOnline.koreksi', Crypt::encrypt($data->id)) }}" class="btn btn-warning btn-sm" style="width: 100%; margin: 2px;">
                                <i class="nav-icon fas fa-check"></i> &nbsp; Koreksi Jawaban
                            </a>
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
<!-- /.col -->
@endsection

@section('script')
<script>
    $("#UjianOnlineGuru").addClass("active");
    $("#liUjianOnlineGuru").addClass("menu-open");
    $("#JadwalUjianOnlineGuru").addClass("active");
</script>
@endsection