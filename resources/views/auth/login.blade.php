
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-core.min.js"></script>
        <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-pie.min.js"></script>
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SILEB</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 70vh;
            }

            .flex-center {
                background-color: #003760;
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .row{
                margin-top: 50px;
                margin-bottom: 50px;
                margin-right: 50px;
                margin-left: 50px;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 100px;
            }

            .links > a {
                color: #fff;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
                color: #fff;
            }

            .ctr {
                text-align: center !important;
            }
            
            thead > tr > th, tbody > tr > td{
                vertical-align: middle !important;
            }

            td> input.form-control{
                width: 60px !important;
                padding: 8px !important;
                box-shadow: none !important;
            }

            input[name=predikat]{
                align-items: center;
                width:60px !important;
                background:#fff !important;
                box-shadow: none !important;
            }

            input[disabled],input[disabled]:hover{
                cursor: default !important;
                border:none !important;
            }
            
            .textarea-rapot{
                font-size:11px !important;
                background: #fff !important;
                border:none !important;
                font-size: 11px !important;
                cursor: default !important;
            }

            @media (min-width: 768px) {
                .img-details {
                    margin-left: 40px;
                }
                .btn-details {
                    margin-top: 28px !important;
                }
                .btn-details-siswa {
                    margin-top: 175px !important;
                }
            }
        </style>
    </head>

    <body>
        <div class="flex-center position-ref full-height" style="background-image:linear-gradient(#005a9d, white) !important;">
            <div class="top-right links">
                <a href="/loginpage">Login</a>
            </div>

            <div class="content">
                <br>
                <br>

                <img src="http://localhost:8000/img/favicon.png" style="height: 200px;width: 200px;border-radius: 25%;">

                <div class="title m-b-md">
                   SILEB
                </div>

                <div class="links col-md-12">
                    <a href="#" style="color:black">
                        <b>Documentation, Coming Soon!</b>
                    </a>
                    <br>
                    <p style="color:black">
                        <b>©Copyright 2022 SILEB. Created By <strong>Binus's Team</strong>.</b>
                    </p>
                    <h2 style="color:black">
                        <b>Sistem Informasi Smart Learning Binus Edutainment</b>
                    </h2>

                    <br>
                    <p style="color:black; margin-bottom: 0cm">Info & Pengumuman</p>
                    <span class="fa fa-sort-down" style="font-size: 25pt;"></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" id="load_content">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <b>Jadwal Pelajaran</b>
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Jam Pelajaran</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Ruang Kelas</th>
                                    <th>Ket.</th>
                                </tr>
                            </thead>
                            <tbody id="data-jadwal">
                                @php
                                $hari = date('w');
                                $jam = date('H:i');
                                @endphp
                                @if ( $jadwal->count() > 0 )
                                @if (
                                    $hari == '1' && $jam >= '09:45' && $jam <= '10:15' ||
                                    $hari == '1' && $jam >= '12:30' && $jam <= '13:15' ||
                                    $hari == '2' && $jam >= '09:15' && $jam <= '09:45' ||
                                    $hari == '2' && $jam >= '12:00' && $jam <= '13:00' ||
                                    $hari == '3' && $jam >= '09:15' && $jam <= '09:45' ||
                                    $hari == '3' && $jam >= '12:00' && $jam <= '13:00' ||
                                    $hari == '4' && $jam >= '09:15' && $jam <= '09:45' ||
                                    $hari == '4' && $jam >= '12:00' && $jam <= '13:00' ||
                                    $hari == '5' && $jam >= '09:00' && $jam <= '09:15' ||
                                    $hari == '5' && $jam >= '11:15' && $jam <= '13:00'
                                )
                                <tr>
                                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Istirahat!</td>
                                </tr>
                                @else
                                @foreach ($jadwal as $data)
                                    <tr>
                                        <td>{{ $data->jam_mulai.' - '.$data->jam_selesai }}</td>
                                        <td>
                                            <h5 class="card-title">{{ $data->mapel->nama_mapel }}</h5>
                                            <p class="card-text"><small class="text-muted">{{ $data->guru->nama_guru }}</small></p>
                                        </td>
                                        <td>{{ $data->kelas->nama_kelas }}</td>
                                        <td>{{ $data->ruang->nama_ruang }}</td>
                                        <td>
                                            @if ($data->absen($data->guru_id))
                                            <div style="margin-left:20px;width:30px;height:30px;background:#{{ $data->absen($data->guru_id) }}"></div>
                                            @elseif (date('H:i:s') >= '09:00:00')
                                            <div style="margin-left:20px;width:30px;height:30px;background:#F00"></div>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                                @elseif ($jam <= '07:00')
                                <tr>
                                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>
                                        Jam Pelajaran Hari ini Akan Segera Dimulai!
                                    </td>
                                </tr>
                                @elseif (
                                $hari == '1' && $jam >= '16:15' ||
                                $hari == '2' && $jam >= '16:00' ||
                                $hari == '3' && $jam >= '16:00' ||
                                $hari == '4' && $jam >= '16:00' ||
                                $hari == '5' && $jam >= '15:40'
                                )
                                <tr>
                                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>
                                        Jam Pelajaran Hari ini Sudah Selesai!
                                    </td>
                                </tr>
                                @elseif ($hari == '0' || $hari == '6')
                                <tr>
                                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Sekolah Libur!</td>
                                </tr>
                                @elseif($hari == '1' && $jam >= '07:00' && $jam <= '07:30')
                                <tr>
                                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Upacara Bendera!</td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Tidak Ada Data Jadwal!</td>
                                </tr>
                                @endif
                            </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-warning" style="min-height: 385px;">
                    <div class="card-header">
                        <h3 class="card-title">
                            <b>Pengumuman</b>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0">
                            {!! $pengumuman->isi !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-6">
              <div class="small-box bg-info">
                  <div class="inner">
                      <h3>{{$bukukerja}}</h3>
                      <p>Buku Kerja</p>
                  </div>
                  <div class="icon">
                      <i class="fas fa-calendar-alt nav-icon"></i>
                  </div>
                  <a href="{{ route('guest.bukukerja') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
          </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$roster}}</h3>
                        <p>Jadwal</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                    </div>
                    <a href="{{ route('guest.jadwal') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner" style="color: #FFFFFF;">
                        <h3>{{$guru}}</h3>
                        <p>Guru</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-id-card nav-icon"></i>
                    </div>
                    <a href="{{ route('guest.showGuru') }}" style="color: #FFFFFF !important;" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$siswa}}</h3>
                        <p>Siswa</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-id-card nav-icon"></i>
                    </div>
                    <a href="/siswa/angkatan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$kelas}}</h3>
                        <p>Kelas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-home nav-icon"></i>
                    </div>
                    <a href="/siswa/angkatan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{$mapel}}</h3>
                        <p>Mapel</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book nav-icon"></i>
                    </div>
                    <a href="{{ route('guest.mapel') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
              
            </div>

             
            <div class="col-lg-4 col-6"> </div>


            <div class="col-lg-4 col-6">
             
            </div>

            <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span class="text-bold text-lg">DataGuru</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-success">
                            <i class="fas fa-arrow-up"></i> {{ $guru }}
                        </span>
                    </p>
                </div>
                <div class="position-relative mb-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="chart-responsive">
                                <canvas id="pieChartGuru" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span class="text-bold text-lg">Data Siswa</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-success">
                            <i class="fas fa-arrow-up"></i> {{ $siswa }}
                        </span>
                    </p>
                </div>
                <div class="position-relative mb-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="chart-responsive">
                                <canvas id="pieChartSiswa" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span class="text-bold text-lg">Kelas / Paket Keahlian </span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-success">
                            <i class="fas fa-arrow-up"></i> {{ $kelas }}
                        </span>
                    </p>
                </div>
                <div class="position-relative mb-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="chart-responsive">
                                <canvas id="pieChartPaket" height="150"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        </div>

        <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span class="text-bold text-lg">Grafik Siswa Per Tahun Ajaran </span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-success">
                            <i class="fas fa-arrow-up"></i> Tahun ajaran ({{ $jumlahtahun }})
                        </span>
                    </p>
                </div>
                <div class="position-relative mb-4">
                    <div class="row">
                        <div class="col-md-8" >
                            <div class="chart-responsive" style="width:1150px;">
                                <canvas id="chartstudentalltime"  height="280" width="800"></canvas>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
            
        </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    var year =  <?php echo $year; ?>;
    var user = <?php echo $countsiswa; ?>;
    var barChartData = {
        labels: year,
        datasets: [{
            label: 'Siswa',
            backgroundColor: '#007BFF',
            data: user
        }]
    };

    window.onload = function() {
        var ctx = document.getElementById("chartstudentalltime").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                scales: {
                    xAxes: [{
                        barPercentage: 0.3
                    }]
                },
                legend: { 
                    display: true,
                    position: 'right',
                    labels: {
                        fontSize: 16
                    }
                }
            }
        });
    };
</script>
<script>
    $(document).ready(function () {
        'use strict'

        var pieChartCanvasGuru = $('#pieChartGuru').get(0).getContext('2d')
        var pieDataGuru        = {
            labels: [
                'Laki-laki', 
                'Perempuan',
            ],
            datasets: [
                {
                data: [`{{ $gurulk }}`, `{{ $gurupr }}`],
                backgroundColor : ['#007BFF', '#DC3545'],
                }
            ]
        }
        var pieOptions     = {
            legend: {
                display: true,
                position: 'right',
                labels: {
                    fontSize: 16
                }
            }
        }
        var pieChart = new Chart(pieChartCanvasGuru, {
            type: 'doughnut',
            data: pieDataGuru,
            options: pieOptions      
        })

        var pieChartCanvasSiswa = $('#pieChartSiswa').get(0).getContext('2d')
        var pieDataSiswa        = {
            labels: [
                'Laki-laki', 
                'Perempuan',
            ],
            datasets: [
                {
                data: [`{{ $siswalk }}`, `{{ $siswapr }}`],
                backgroundColor : ['#007BFF', '#DC3545'],
                }
            ]
        }
        var pieOptions     = {
            legend: {
                display: true,
                position: 'right',
                labels: {
                    fontSize: 16
                }
            }
        }
        var pieChart = new Chart(pieChartCanvasSiswa, {
            type: 'doughnut',
            data: pieDataSiswa,
            options: pieOptions      
        })

        var pieChartCanvasPaket = $('#pieChartPaket').get(0).getContext('2d')
        var pieDataPaket        = {
            labels: [
                'Ilmu Pengetahuan Alam',
                'Ilmu Pengetahuan Sosial',

            ],
            datasets: [
                {
                    data: [`{{ $bkp }}`, `{{ $dpib }}`, `{{ $ei }}`, `{{ $oi }}`, `{{ $tbsm }}`, `{{ $rpl }}`, `{{ $tpm }}`, `{{ $las }}`],
                    backgroundColor : ['#d4c148', '#ba6906', '#ff990a', '#00a352', '#2cabe6', '#999999', '#0b2e75', '#7980f7'],
                }
            ]
        }
        var pieOptions     = {
            legend: {
                display: true,
                position: 'right',
                labels: {
                    fontSize: 16
                }
            }
        }
        var pieChart = new Chart(pieChartCanvasPaket, {
            type: 'doughnut',
            data: pieDataPaket,
            options: pieOptions      
        })
    });
</script>

</body>

</html>

