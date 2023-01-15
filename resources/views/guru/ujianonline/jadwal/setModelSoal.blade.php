@extends('template_backend.home')

@section('heading')
Set Model Soal
@endsection

@section('page')
<li class="breadcrumb-item active"><a href="{{ route('guru.ujianOnline.jadwal') }}">Jadwal Ujian</a></li>
@endsection

@section('content')
<!-- .col -->
<div class="col-md-12">
    <form action="{{ route('guru.ujianOnline.setModelSoal') }}" method="post">
        @csrf
        <input type='hidden' id="jadwal_ujian_id" name='jadwal_ujian_id' value={{ $jadwalUjian->id }}>

        <div class="card">
            <!-- .card-header -->
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <br>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <th width='30%'>Mata Pelajaran</th>
                                <td width='70%'>{{ $jadwalUjian->mapel->nama_mapel }}</td>
                            </tr>
                            <tr>
                                <th width='30%'>Guru</th>
                                <td width='70%'>{{ $jadwalUjian->guru->nama_guru }}</td>
                            </tr>
                            <tr>
                                <th width='30%'>Tipe</th>
                                <td width='70%'>{{ $jadwalUjian->tipeUjian->nama }}</td>
                            </tr>
                            <tr>
                                <th width='30%'>Tanggal</th>
                                <td width='70%'>{{ $jadwalUjian->tanggal }}</td>
                            </tr>
                            <tr>
                                <th width='30%'>Jam & Ruangan</th>
                                <td width='70%'>
                                    {{ $jadwalUjian->jam_mulai }} - {{ $jadwalUjian->jam_selesai }} <br>
                                    <p class="card-text"><small class="text-muted">{{ $jadwalUjian->ruang->nama_ruang }}</small></p>
                                </td>
                            </tr>
                            <tr>
                                <th width='30%'>Kelas</th>
                                <td width='70%'>{{ $jadwalUjian->nama_kelas }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <!-- .card-body -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="question_model_id">Model Soal</label>
                            <select id="question_model_id" name="question_model_id" class="form-control @error('question_model_id') is-invalid @enderror select2bs4">
                                <option value="">-- Pilih --</option>
                                @foreach ($modelsoal as $data)
                                <option value="{{ $data->id }}" @if ($jadwalUjian->question_model_id == $data->id) selected @endif >{{ $data->nama_model_soal }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <!-- .card-footer -->
            <div class="card-footer" style="text-align: right;">
                <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Set Model</button>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </form>
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