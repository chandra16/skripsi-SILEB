@extends('template_backend.home')
@section('heading', 'Profile Guru')
@section('page')
  <li class="breadcrumb-item active">Profile Guru</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="row no-gutters ml-2 mb-2 mr-2">
                <div class="col-md-4">
                    <img src="{{ asset($guru->foto) }}" class="card-img img-details" alt="...">
                </div>
                <div class="col-md-1 mb-4"></div>
                <div class="col-md-7">
                    <h5 class="card-title card-text mb-2">Nama : {{ $guru->nama_guru }}</h5>
                    <h5 class="card-title card-text mb-2">NIP : {{ $guru->nip }}</h5>
                    <h5 class="card-title card-text mb-2">No Id Card : {{ $guru->id_card }}</h5>
                    <h5 class="card-title card-text mb-2">Guru Mapel : {{ $guru->mapel->nama_mapel }}</h5>
                    <h5 class="card-title card-text mb-2">Kode Jadwal : {{ $guru->kode }}</h5>
                    @if ($guru->jk == 'L')
                        <h5 class="card-title card-text mb-2">Jenis Kelamin : Laki-laki</h5>
                    @else
                        <h5 class="card-title card-text mb-2">Jenis Kelamin : Perempuan</h5>
                    @endif
                    <h5 class="card-title card-text mb-2">Tempat Lahir : {{ $guru->tmp_lahir }}</h5>
                    <h5 class="card-title card-text mb-2">Tanggal Lahir : {{ date('l, d F Y', strtotime($guru->tgl_lahir)) }}</h5>
                    <h5 class="card-title card-text mb-2">No. Telepon : {{ $guru->telp }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
    
    </script>
@endsection