@extends('template_backend.home')

@section('heading')
@endsection

@section('page')
<li class="breadcrumb-item active">Jadwal Ujian</li>
@endsection

@section('content')
<div class="col-md-12">
  <div class="card">
    <!-- .card-header -->
    <div class="card-header">
      <h3>
        Data Jadwal Ujian ( <b>{{ $siswa->kelas_id }}</b> )
      </h3>
    </div>
    <!-- /.card-header -->
    <!-- .card-body -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th width="50px">No.</th>
            <th>Tanggal</th>
            <th>Ruang Kelas</th>
            <th>Tipe</th>
            <th>Mata Pelajaran</th>
            <th width="130px">Nilai</th>
            <th width="130px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($jadwalUjian as $data)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              {{ date('l / d - F - Y', strtotime($data->tanggal)) }} <br>
              ( <i>{{ date('H:i', strtotime($data->jam_mulai)) }} - {{ date('H:i', strtotime($data->jam_selesai)) }}</i> )
            </td>
            <td>{{ $data->nama_ruang }}</td>
            <td>{{ $data->nama_tipe_ujian }}</td>
            <td>
              <h5 class="card-title">{{ $data->nama_mapel }}</h5>
              <p class="card-text"><small class="text-muted">{{ $data->nama_guru }}</small></p>
            </td>
            <td>
              {{ $data->nilai }}
            </td>
            <td id="td-action-button-{{ ($loop->iteration) - 1 }}">
              @if ($data->ujian_selesai_diambil === 0)
                @if ($data->ujian_diambil === 1)
                <button type="submit" class="btn btn-success" onclick="checkAction('{{ ($loop->iteration) - 1 }}', '{{Crypt::encrypt($data->id)}}');"><i class="nav-icon fas fa-play"></i> &nbsp; Lanjutkan Ujian</button>
                @else
                <button type="submit" class="btn btn-primary" onclick="checkAction('{{ ($loop->iteration) - 1 }}', '{{Crypt::encrypt($data->id)}}');"><i class="nav-icon fas fa-play"></i> &nbsp; Mulai Ujian</button>
                @endif
              @else
              <small style="color: green;"><i><b>Ujian telah diambil</b></i></small>
              @endif
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

<!-- .modal -->
<!-- .detail-mulai-ujian -->
<div class="modal fade bd-example-modal-md" id="modal-mulai-ujian" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="judul">Detail Ujian</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>INFO UJIAN</label>
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td>Tipe</td>
                  <td><span id="ipt-tipe"></span></td>
                </tr>
                <tr>
                  <td>Mata Pelajaran</td>
                  <td><span id="ipt-mapel"></span></td>
                </tr>
                <tr>
                  <td>Tanggal</td>
                  <td><span id="ipt-tanggal"></span></td>
                </tr>
                <tr>
                  <td>Ruang</td>
                  <td><span id="ipt-ruang"></span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-12">
            <label>INFO SOAL</label>
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td>Jumlah Soal</td>
                  <td><span id="ipt-jumlah-soal"></span></td>
                </tr>
                <tr>
                  <td rowspan="2">Terdiri Dari</td>
                  <td><span id="ipt-terdiri-dari-pilber"></span></td>
                </tr>
                <tr>
                  <td><span id="ipt-terdiri-dari-essay"></span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-12">
            <label>KETENTUAN</label><br>
            <span>Dengan ini saya menyatakan mengerti akan ketentuan yang ada, dan siap menanggung segala konsekuensi jika melakukan pelanggaran.</span><br><br>
            <input type="checkbox" id="chckbox-tnc">&nbsp;&nbsp;<label>Ya, saya setuju</label>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="justify-content: left;">
        <button id="btn-mulai-ujian" type="submit" class="btn btn-success" onclick="mulaiUjian();" disabled="disabled">
          <i class="nav-icon fas fa-save"></i> &nbsp; Mulai
        </button>
      </div>
    </div>
  </div>
</div>
<!-- /.detail-mulai-ujian -->
<!-- /.modal -->
@endsection

@section('script')
<script type="text/javascript">
  var listJadwalUjian = {!! json_encode($jadwalUjian, JSON_HEX_TAG) !!};
  var idData = '';

  $(document).ready(function() {
    initNavBarPosition();
    initOnChangeTnc();
    initCheckTimeUjian();
  });

  function initNavBarPosition() {
    $("#JadwalUjianSiswa").addClass("active");
  }

  function initOnChangeTnc() {
    $('#chckbox-tnc').change(function() {
      if ($(this).is(':checked')) {
        $('#btn-mulai-ujian').attr('disabled', false);
      } else {
        $('#btn-mulai-ujian').attr('disabled', true);
      }
    });
  }

  function initCheckTimeUjian() {
    listJadwalUjian.forEach((element, index) => {
      var formatDate = 'YYYY-MM-DD';
      var formatTime = 'HH:mm:ss';
      var dateNow = moment();
      var dateUjian = moment(element.tanggal, formatDate);
      var timeStart = moment(element.jam_mulai, formatTime); 
      var timeEnd = moment(element.jam_selesai, formatTime);
      var isSameDate = (dateUjian.format(formatDate) == dateNow.format(formatDate));
      var isOnTime = dateNow.isBetween(timeStart, timeEnd);
      var html = '';

      // console.log('-------------------------')
      // console.log('dateNow: ' + dateNow.format(formatDate))
      // console.log('dateUjian: ' + dateUjian.format(formatDate))
      // console.log('COMPARE: ' + (dateUjian.format(formatDate) == dateNow.format(formatDate)))
      // console.log('timeStart: ' + timeStart.format(formatTime))
      // console.log('timeEnd: ' + timeEnd.format(formatTime))
      // console.log('COMPARE: ' + dateNow.isBetween(timeStart, timeEnd))
      
      if (isSameDate && isOnTime) {
      } else {
        if (element.ujian_diambil === 0 && element.ujian_selesai_diambil === 0) {
          $(`#td-action-button-${index}`).html('<small><i><b>Ujian tidak tersedia</b></i></small>');
        }
      }
    });
  }

  function checkAction(index, id) {
    var dataUjian = listJadwalUjian[index];
    idData = id;
  
    $('#chckbox-tnc').prop('checked', false);

    if (dataUjian.ujian_diambil === 1) {
      lanjutkanUjian();
    } else {
      openModalMulaiUjian(index);
    }
  }

  function openModalMulaiUjian(index) {
    var dataUjian = listJadwalUjian[index];

    if (Object.keys(dataUjian).length === 0) {
      alert('Something wrong! please refresh page.');
      return;
    }

    var tanggalUjian = new Date(dataUjian.tanggal);
    var mapel = `${dataUjian.nama_mapel} <br>( <i>${dataUjian.nama_guru}</i> )`;
    var tanggal = `${ tanggalUjian.toDateString() } <br>( <i>${ dataUjian.jam_mulai } - ${ dataUjian.jam_selesai }</i> )`;

    $("#ipt-tipe").html(dataUjian.nama_tipe_ujian);
    $("#ipt-mapel").html(mapel);
    $("#ipt-tanggal").html(tanggal);
    $("#ipt-ruang").html(dataUjian.nama_ruang);
    $("#ipt-jumlah-soal").html(dataUjian.count_question);
    $("#ipt-terdiri-dari-pilber").html(`${(dataUjian.count_pilber_question > 0) ? dataUjian.count_pilber_question : '-'} Pilihan Berganda`);
    $("#ipt-terdiri-dari-essay").html(`${((dataUjian.count_essay_question > 0) ? dataUjian.count_essay_question : '-')} Essay`);

    $("#modal-mulai-ujian").modal("show");
  }

  function mulaiUjian() {
    if (!$('#chckbox-tnc').is(':checked')) {
      alert('You must thick TnC approval !');
      return;
    }

    if (String(idData).trim() == '' || String(idData).trim() == 'NULL') {
      alert('Something wrong! please refresh page.');
      return;
    }

    window.location.href = `{{ url('/siswa/ujian/${idData}') }}`;
  }
  
  function lanjutkanUjian() {
    if (String(idData).trim() == '' || String(idData).trim() == 'NULL') {
      alert('Something wrong! please refresh page.');
      return;
    }

    window.location.href = `{{ url('/siswa/ujian/${idData}') }}`;
  }
</script>
@endsection