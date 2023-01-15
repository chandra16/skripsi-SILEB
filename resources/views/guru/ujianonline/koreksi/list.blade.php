@extends('template_backend.home')

@section('heading')
@endsection

@section('page')
<li class="breadcrumb-item active"><a href="{{ route('guru.ujianOnline.jadwal') }}">Jadwal Ujian</a></li>
<li class="breadcrumb-item active">List Siswa Ujian</li>
@endsection

@section('content')
<!-- .col -->
<div class="col-md-12">
    <div class="card">
        <!-- card-header -->
        <div class="card-header">
            <h4>
                <label>DAFTAR SISWA KELAS : {{ $jadwalUjian->nama_kelas }}</label>
                <br>
                <small>Siswa yang melakukan ujian : {{ $jadwalUjian->tipeUjian->nama}}</small>
            </h4>
        </div>
        <!-- .card-header -->
        <!-- .card-body -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Nilai</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ujian as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->siswa->nis }}</td>
                            <td>{{ $data->siswa->nama_siswa }}</td>
                            <td>{{ $data->hasil }}</td>
                            <td>
                                <a href="{{ route('guru.ujianOnline.koreksi.detail', Crypt::encrypt($data->id)) }}" class="btn btn-primary btn-sm" style="width: 100%; margin: 2px;">
                                    <i class="nav-icon fas fa-list"></i> &nbsp; Koreksi Ujian
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <!-- .card-footer -->
        <!-- <div class="card-footer">
            <div class="col-md-12" style="text-align: right;">
                <button type="submit" class="btn btn-success" onclick=""><i class="nav-icon fas fa-save"></i> &nbsp; Selesai Koreksi</button>
            </div>
        </div> -->
        <!-- /.card-footer -->
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