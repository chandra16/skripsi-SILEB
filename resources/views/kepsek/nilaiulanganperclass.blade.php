@extends('template_backend.home')
@section('heading', 'Nilai Ulangan')
@section('page')
  <li class="breadcrumb-item active"> Nilai Ulangan</li>
@endsection
@section('content')
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"> Nilai Ulangan</h3>
      </div>
      <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <table class="table" style="margin-top: -10px;">
                    <tr>
                        <td>Nama Kelas</td>
                        <td>:</td>
                        <td>{{ $namaKelas }}</td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td>
                        <td>:</td>
                        <td>{{ isset($kelas[0]) ? $kelas[0]->guru->nama_guru : '-'}}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Siswa</td>
                        <td>:</td>
                        <td>{{ isset($siswa) ? $siswa->count() : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $guru->mapel->nama_mapel}}</td>
                    </tr>
                    <tr>
                        <td>Guru Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $guru->nama_guru }}</td>
                    </tr>
                    @php
                        $bulan = date('m');
                        $tahun = date('Y');
                    @endphp
                    <tr>
                        <td>Semester</td>
                        <td>:</td>
                        <td>
                            @if ($bulan > 6)
                                {{ 'Semester Ganjil' }}
                            @else
                                {{ 'Semester Genap' }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Tahun Pelajaran</td>
                        <td>:</td>
                        <td>
                            @if ($bulan > 6)
                                {{ $tahun }}/{{ $tahun+1 }}
                            @else
                                {{ $tahun-1 }}/{{ $tahun }}
                            @endif
                        </td>
                    </tr>
                </table>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="ctr">No.</th>
                            <th>Nama Siswa</th>
                            <th class="ctr">ULHA 1</th>
                            <th class="ctr">ULHA 2</th>
                            <th class="ctr">UTS</th>
                            <th class="ctr">ULHA 3</th>
                            <th class="ctr">UAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="" method="post">
                            @csrf
                            <input type="hidden" name="guru_id" value="{{$guruId}}">
                            <input type="hidden" name="tahun_ajaran" value="{{$tahun_ajaran}}">
                            <input type="hidden" name="kelas_id" value="{{$namaKelas}}">
                            @foreach ($siswa as $data)
                                <input type="hidden" name="siswa_id" value="{{$data->id}}">
                                <tr>
                                    <td class="ctr">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $data->nama_siswa }}
                                        @if ($data->ulanganshow($data->id,$guruId) && $data->ulanganshow($data->id,$guruId)['id'])
                                            <input type="hidden" name="ulangan_id" class="ulangan_id_{{$data->id}}" value="{{ $data->ulanganshow($data->id,$guruId)->id }}">
                                        @else
                                            <input type="hidden" name="ulangan_id" class="ulangan_id_{{$data->id}}" value="">
                                        @endif
                                    </td>
                                    <td class="ctr">
                                        @if ($data->ulanganshow($data->id,$guruId) && $data->ulanganshow($data->id,$guruId)['ulha_1'])
                                            <div class="text-center">{{ $data->ulanganshow($data->id,$guruId)['ulha_1'] }}</div>
                                            <input type="hidden" name="ulha_1" class="ulha_1_{{$data->id}}" value="{{ $data->ulanganshow($data->id,$guruId)['ulha_1'] }}">
                                        @else
                                            <input type="text" name="ulha_1" maxlength="3" onkeypress="return inputAngka(event)" style="margin: auto;" class="form-control text-center ulha_1_{{$data->id}}" autocomplete="off">
                                        @endif
                                    </td>
                                    <td class="ctr">
                                        @if ($data->ulanganshow($data->id,$guruId) && $data->ulanganshow($data->id,$guruId)['ulha_2'])
                                            <div class="text-center">{{ $data->ulanganshow($data->id,$guruId)['ulha_2'] }}</div>
                                            <input type="hidden" name="ulha_2" class="ulha_2_{{$data->id}}" value="{{ $data->ulanganshow($data->id,$guruId)['ulha_2'] }}">
                                        @else
                                            <input type="text" name="ulha_2" maxlength="3" onkeypress="return inputAngka(event)" style="margin: auto;" class="form-control text-center ulha_2_{{$data->id}}" autocomplete="off">
                                        @endif
                                    </td>
                                    <td class="ctr">
                                        @if ($data->ulanganshow($data->id,$guruId) && $data->ulanganshow($data->id,$guruId)['uts'])
                                            <div class="text-center">{{ $data->ulanganshow($data->id,$guruId)['uts'] }}</div>
                                            <input type="hidden" name="uts" class="uts_{{$data->id}}" value="{{ $data->ulanganshow($data->id,$guruId)['uts'] }}">
                                        @else
                                            <input type="text" name="uts" maxlength="3" onkeypress="return inputAngka(event)" style="margin: auto;" class="form-control text-center uts_{{$data->id}}" autocomplete="off">
                                        @endif
                                    </td>
                                    <td class="ctr">
                                        @if ($data->ulanganshow($data->id,$guruId) && $data->ulanganshow($data->id,$guruId)['ulha_3'])
                                            <div class="text-center">{{ $data->ulanganshow($data->id,$guruId)['ulha_3'] }}</div>
                                            <input type="hidden" name="ulha_3" class="ulha_3_{{$data->id}}" value="{{ $data->ulanganshow($data->id,$guruId)['ulha_3'] }}">
                                        @else
                                            <input type="text" name="ulha_3" maxlength="3" onkeypress="return inputAngka(event)" style="margin: auto;" class="form-control text-center ulha_3_{{$data->id}}" autocomplete="off">
                                        @endif
                                    </td>
                                    <td class="ctr">
                                        @if ($data->ulanganshow($data->id,$guruId)&& $data->ulanganshow($data->id,$guruId)['uas'])
                                            <div class="text-center">{{ $data->ulanganshow($data->id,$guruId)['uas'] }}</div>
                                            <input type="hidden" name="uas" class="uas_{{$data->id}}" value="{{ $data->ulanganshow($data->id,$guruId)['uas'] }}">
                                        @else
                                            <input type="text" name="uas" maxlength="3" onkeypress="return inputAngka(event)" style="margin: auto;" class="form-control text-center uas_{{$data->id}}" autocomplete="off">
                                        @endif
                                    </td>
                                
                                </tr>
                            @endforeach
                        </form>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection
@section('script')

@endsection