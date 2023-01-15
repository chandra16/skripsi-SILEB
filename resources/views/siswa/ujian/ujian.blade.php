<!DOCTYPE html>

<html>
  <head>
    <!-- <meta charset="UTF-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SILEB</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-daygrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-timegrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-bootstrap/main.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="shrotcut icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <style>
      .disabled-border {
        border: 0px !important;
      }

      .pull-left {
        text-align: left;
      }

      .pull-right {
        text-align: right;
      }

      .center {
        text-align: center;
      }

      .margin-bottom {
        margin-bottom: 5px;
      }

      .label-option {
        font-weight: 500 !important;
      }
    </style>
  </head>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #0f4c81; margin-left: 0px">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <span class="brand-link">
          <a href="{{ route('home') }}">
            <img src="{{ asset('img/favicon.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
            <label class="brand-text font-weight-light" style="color: white;">
              SILEB
            </label>
          </a>
        </span>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <div class="btn-group" role="group">
          <a id="btnGroupDrop1" style="color: #fff; margin-right: 40px;" type="button" class="dropdown-toggle text-capitalize" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="nav-icon fas fa-user-circle"></i> &nbsp; {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="{{ route('home') }}"><i class="nav-icon fas fa-home"></i> &nbsp; Kembali ke Home</a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="nav-icon fas fa-sign-out-alt"></i> &nbsp; Log Out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Body -->
  <body oncopy="return false" oncut="return false" onpaste="return false" class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-open">
    <br>
    <div class="col-md-12">
      <div class="col-md-12">
        <div class="col-md-12">
          <div class="card">
            <!-- HIDDEN INPUT -->
            <input type="hidden" id="id-ujian" value="{{ $ujian->id }}">
            <!-- /HIDDEN INPUT -->
            <!-- .card-header -->
            <div class="card-header">
              <div class="row">
                <div class="col-md-6">
                  <h3><b>{{ $jadwalUjian->mapel->nama_mapel }} - <i>{{ $jadwalUjian->tipeUjian->nama }}</i></b></h3>
                </div>
                <div class="col-md-6 pull-right">
                  <span id="sisa-waktu"></span>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <!-- .card-body -->
            <div class="card-body">
              <table class="table table-bordered">

                <tr>
                  <td class="col-md-10">
                    <div class="col-md-12">
                      <h5><b>DETAIL SOAL</b></h5>
                    </div>
                    <div class="col-md-12">
                      <hr>
                    </div>
                    <div class="col-md-12">
                      <div id="div-soal"></div>
                    </div>
                    <div class="col-md-12">
                      <hr>
                    </div>
                    <div class="col-md-12">
                      <div id="div-btn-selanjutnya"></div>
                    </div>
                  </td>
                  <td class="col-md-2">
                    <div class="col-md-12">
                      <h5><b>DAFTAR SOAL</b></h5>
                    </div>
                    <div class="col-md-12">
                      <hr>
                    </div>
                    <div class="col-md-12">
                      <div id="div-daftar-soal"></div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
    </div>
  </body>
  <!-- /.body -->

  <!-- modal -->
  <div class="modal fade bd-example-modal-lg" id="modal-mulai-ujian" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document" style="background-color: #f0f8ff00;">
    <div class="modal-content" style="background-color: #0000;box-shadow: 0px 0px 0px;border: 0px;">
      <div class="modal-body" style="text-align: center;padding-top: 50%;background-color: #0000;">
        <h1 style="color: white;">Click dimana saja untuk mulai</h1>
      </div>
    </div>
  </div>
</div>
  <!-- /.modal -->

  @section('script')
  <script type="text/javascript">
    var jadwalUjian = {!! json_encode($jadwalUjian, JSON_HEX_TAG) !!};
    var listQuestion = {!! json_encode($question, JSON_HEX_TAG) !!};
    var indexData = 0;

    $(document).ready(function() {
      initView(0);
      openModalStart();
      onClickModalStart();

      setInterval(() => {
        initCounterJam();
      }, 1000);
    });

    function initCounterJam() {
      var formatTime = 'HH:mm:ss';
      var jamSekarang = moment();
      var jamSelesai = moment(jadwalUjian.jam_selesai, formatTime);
      var sisa = moment.utc(jamSelesai.diff(jamSekarang));
      var html = `<h3>${sisa.format("HH:mm:ss")}</h3>`;

      $("#sisa-waktu").html(html);

      if (sisa <= 600048) {
        $("#sisa-waktu").css('color', 'red');
        $("#sisa-waktu").css('font-weight', '900');
      }

      if (sisa <= 0) {
        submitSelesai();
      }
    }

    function openModalStart() {
      $("#modal-mulai-ujian").modal("show");
    }

    function onClickModalStart() {
      $("#modal-mulai-ujian").on('click', function(event) {
        toggleFullScreen();
        
        // Prevent New Tab, quiet Etc
        event.preventDefault();
      });
    }

    function toggleFullScreen() {
      if (!document.fullscreenElement &&    // alternative standard method
          !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        }
      }
    }

    function initView(index) {
      indexData = parseInt(index);

      initDaftarSoal();
      initTombolSelanjutnya();
      changeBackgroundDaftarSoal();
      setSoal();
      setJawaban();
    }

    function initViewNext() {
      var length = (listQuestion.length) - 1;
      var index = indexData;
      
      if (index > (length - 1)) {
        alert("INI SOAL TERAKHIR !");
        return;
      }

      initView(index + 1);
    }

    function initTombolSelanjutnya() {
      var length = (listQuestion.length) - 1;
      var html = '';

      if (indexData === length) {
        html = `
          <div class="row">
            <div class="col-md-12 pull-right">
              <button id="btn-next-question" onclick="saveJawaban(); selesaiUjian();" class="btn btn-warning" type="button">Selesai Ujian</button>
            </div>
          </div>
        `;
      } else {
        html = `
          <div class="row">
            <div class="col-md-12 pull-right">
              <button id="btn-next-question" onclick="saveJawaban(); initViewNext();" class="btn btn-primary" type="button">Selanjutnya</button>
            </div>
          </div>
        `;
      }

      $("#div-btn-selanjutnya").html(html);
    }

    function initDaftarSoal() {
      let html = '';

      listQuestion.forEach(function (value, index) {
        html += `
          <button id="btn-answered-${value.id}" onclick="saveJawaban(); initView('${index}');" class="col-md-2 btn btn-default margin-bottom btn-daftar-soal">
            ${index + 1}
          </button>
        `;  
      });

      $("#div-daftar-soal").html(html);
    }

    function changeBackgroundDaftarSoal() {
      let dataSoal = listQuestion[indexData];

      $(`.btn-daftar-soal`).css("background-color", "#f8f9fa");
      
      listQuestion.forEach(element => {
        if (element.jawaban) {
          $(`#btn-answered-${element.id}`).css("background-color", "#50df00");
        }
      });

      $(`#btn-answered-${dataSoal.id}`).css("background-color", "#b5dcff");
    }

    function setSoal() {
      var dataSoal = listQuestion[indexData];
      var html = `
        <table style="width: 100%">
          <tr>
            <td rowspan=2 class="disabled-border" style="width: 0px;">${parseInt(indexData) + 1}.</td>
            <td class="disabled-border">
              ${dataSoal.question_text}
            </td>
          </tr>
      `;

      if (dataSoal.type == 'Pilihan Berganda') {
        var option = dataSoal.question_option;

        html += `<tr><td class="disabled-border">`;

        option.forEach(element => {
          html += `
            <input type="radio" id="opsi1" name="jawaban" value="${element.id}">
            <label for="opsi1" class="label-option">${element.option}</label><br>
          `;
        });

        html += `</td></tr>`;
      } else {
        html += `
          <tr>
            <td class="disabled-border"><textarea id="jawaban" name="jawaban" class="textarea @error('jawaban') is-invalid @enderror"></textarea></td>
          </tr>
        `;
      }

      html += `
        </table>
      `;
    
      $("#div-soal").html(html);

      if (dataSoal.type == 'Essay') {
        $('#jawaban').summernote({ 
          focus: true,
          height: 300
        });
      }
    };

    function setJawaban() {
      var dataSoal = listQuestion[indexData];

      if (dataSoal.jawaban) {
        if (dataSoal.type === 'Essay') {
          $("#jawaban").summernote("code", `${dataSoal.jawaban}`);
        } else {
          $('input:radio[name="jawaban"]').filter(`[value="${dataSoal.jawaban}"]`).attr('checked', true);
        }
      }
    };

    function saveJawaban() {
      var dataSoal = listQuestion[indexData];
      var jawaban = (dataSoal.type == 'Pilihan Berganda') ? $('input[name="jawaban"]:checked').val() : $('#jawaban').val();
      
      if (jawaban !== '' || typeof jawaban !== 'undefined' || jawaban !== null) {
        listQuestion[indexData].jawaban = jawaban;

        var data = {
          _token: '{{ csrf_token() }}',
          ujian_id: $('#id-ujian').val(),
          question_id: dataSoal.id,
          jawaban: jawaban
        };
        
        $.ajax({
          url: "{{ route('siswa.ujian.submit') }}",
          type: "POST",
          data: data,
          dataType: 'json',
          success: function(result) {
            // toastr.success("Jawaban tersimpan !");
          },
          error: function (result) {}
        });
      }
    }

    function selesaiUjian() {
      Swal
        .fire({
          title: "Perhatian !",
          html: "Anda yakin untuk menyelesaikan ujian? <br>Anda tidak akan dapat mengambil ujian ini lagi.",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Ya, selesaikan ujian",
          cancelButtonText: "Tidak"
        })
        .then((result) => {
          if (result.value) {
            submitSelesai();
          } else {
            Swal.fire("Dibatalkan", "Anda dapat melanjutkan ujian !", "error");
          }
        });
    }

    function submitSelesai() {
      var idUjian = $('#id-ujian').val();
      
      $.ajax({
        url: `{{ route('siswa.ujian.finish') }}`,
        type: "POST",
        data: {
          _token: '{{ csrf_token() }}',
          idUjian: idUjian
        },
        dataType: 'json',
        success: function(result) {
          Swal.fire("Success", "Terimakasih telah melakukan ujian !", "success");

          setTimeout(() => {
            window.location.href = `{{ route('siswa.jadwal.ujian') }}`;
          }, 2000);
        },
        error: function (result) {}
      });
    }
  </script>
  @endsection

  @include('template_backend.footer')
</html>
