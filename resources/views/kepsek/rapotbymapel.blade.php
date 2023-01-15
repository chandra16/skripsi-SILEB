@extends('template_backend.home')
@section('heading', 'Nilai Rapot')
@section('page')
  <li class="breadcrumb-item active">Nilai Rapot</li>
@endsection
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Nilai Rapot</h3>
      </div>
      <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <table class="table" style="margin-top: -10px;">
                    <tr>
                        <td>Nama Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas[0]->nama_kelas }}</td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas[0]->guru->nama_guru }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Siswa</td>
                        <td>:</td>
                        <td>{{ $siswa->count() }}</td>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $guru->mapel->nama_mapel }}</td>
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
                            <th class="ctr" rowspan="2">No.</th>
                            <th rowspan="2">Nama Siswa</th>
                            <th class="ctr" colspan="3">Pengetahuan</th>
                        </tr>
                        <tr>
                            <th class="ctr">Nilai</th>
                            <th class="ctr">Predikat</th>
                            <th class="ctr">Deskripsi</th>
                
                        </tr>
                    </thead>
                    <tbody>
                        <form action="" method="post" id="formRapot">
                            @csrf
                            <input type="hidden" name="guru_id" value="{{$guru->id_card}}">
                            <input type="hidden" name="kelas_id" value="{{$kelas[0]->nama_kelas}}">
                            @foreach ($siswa as $data)
                                <input type="hidden" name="siswa_id" value="{{$data->id}}">
                                <tr>
                                    <td class="ctr">{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama_siswa }}</td>
                                    @if ($data->rapot($data->id,$guru->id_card))
                                        <td class="ctr">
                                            <input type="hidden" class="rapot_{{$data->id}}" value="{{ $data->rapot($data->id,$guru->id_card)->id }}">
                                            <div class="text-center">{{ $data->rapot($data->id,$guru->id_card)->p_nilai }}</div>
                                        </td>
                                        <td class="ctr">
                                            <div class="text-center">{{ $data->rapot($data->id,$guru->id_card)->p_predikat }}</div>
                                        </td>
                                        <td class="ctr">
                                            <textarea class="form-control swal2-textarea textarea-rapot" cols="50" rows="5" disabled>{{ $data->rapot($data->id,$guru->id_card)->p_deskripsi }}</textarea>
                                        </td>
                                       
                                    @else
                                        <td class="ctr">
                                            <div class="text-center"></div>
                                        </td>
                                        <td class="ctr">
                                            <div class="text-center"></div>
                                        </td>
                                        <td class="ctr">
                                            <textarea class="form-control swal2-textarea textarea-rapot" cols="50" rows="5" disabled></textarea>
                                        </td>
                                    
                                    @endif
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
    <script>
        $("input[name=nilai]").keyup(function(){
            var id = $(this).attr('data-ids');
		    var guru_id = $("input[name=guru_id]").val();
            var angka = $(".nilai_"+id).val();
            if (angka.length == 2){
                $.ajax({
                    type:"GET",
                    data: {
                        id : guru_id,
                        nilai : angka
                    },
                    dataType:"JSON",
                    url:"{{ url('/rapot/predikat') }}",
                    success:function(data){
                        $(".predikat_"+id).val(data[0]['predikat']);
                        $(".deskripsi_"+id).val(data[0]['deskripsi']);
                    },
                    error:function(){
                        toastr.warning("Tolong masukkan nilai kkm & predikat!");
                    }
                });
            } else {
                $(".predikat_"+id).val("");
                $(".deskripsi_"+id).val("");
            }
        });

        $(".btn_click").click(function(){
            var id = $(this).attr('data-id');
            var rapot = $(".rapot_"+id).val();
            var nilai = $(".nilai_"+id).val();
            var predikat = $(".predikat_"+id).val();
            var deskripsi = $(".deskripsi_"+id).val();
            var guru_id = $("input[name=guru_id]").val();
            var kelas_id = $("input[name=kelas_id]").val();
            var ok = ('<i class="fas fa-check" style="font-weight:bold;"></i>')

            if (nilai == "") {
                toastr.error("Form tidak boleh ada yang kosong!");
            } else {
                $.ajax({
                    url: "{{ route('rapot.store') }}",
                    type: "POST",
                    dataType: 'json',
                    data 	: {
                        _token: '{{ csrf_token() }}',
                        id : rapot,
                        siswa_id : id,
                        kelas_id : kelas_id,
                        guru_id : guru_id,
                        nilai : nilai,
                        predikat : predikat,
                        deskripsi : deskripsi,
                    },
                    success: function(data){
                        $(".nilai_"+id).remove();
                        $(".predikat_"+id).remove();
                        $("#submit-"+id).remove();
                        $(".knilai_"+id).append(nilai);
                        $(".kpredikat_"+id).append(predikat);
                        $(".sub_"+id).append(ok);
                        toastr.success("Nilai rapot siswa berhasil ditambahkan!");
                    },
                    error: function (data) {
                        toastr.warning("Errors 404!");
                    }
                });
            }
        });

        $("#NilaiGuru").addClass("active");
        $("#liNilaiGuru").addClass("menu-open");
        $("#RapotGuru").addClass("active");
    </script>
@endsection