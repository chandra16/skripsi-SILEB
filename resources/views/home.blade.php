@extends('template_backend.home')
@section('heading', 'Dashboard')
@section('page')
  <li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('content')
    <div class="col-md-12" id="load_content">
      <div class="card card-primary">
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
                  <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Jam Pelajaran Hari ini Akan Segera Dimulai!</td>
                </tr>
                @elseif (
                  $hari == '1' && $jam >= '16:15' ||
                  $hari == '2' && $jam >= '16:00' ||
                  $hari == '3' && $jam >= '16:00' ||
                  $hari == '4' && $jam >= '16:00' ||
                  $hari == '5' && $jam >= '15:40'
                )
                  <tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Jam Pelajaran Hari ini Sudah Selesai!</td>
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

    <div class="col-md-12">
      <div class="card card-warning" style="min-height: 385px;">
        <div class="card-header">
          <h3 class="card-title" style="color: white;">
            Pengumuman
          </h3>
        </div>
        <div class="card-body">
          <div class="tab-content p-0">
            {!! $pengumuman->isi !!}
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $bukukerja}}</h3>
                <p>Buku Kerja</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt nav-icon"></i>
            </div>
            <a href="{{ route('admin.bukukerja') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $roster}}</h3>
                <p>Jadwal</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt nav-icon"></i>
            </div>
            <a href="{{ route('jadwal.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner" style="color: #FFFFFF;">
                <h3>{{ $guru }}</h3>
                <p>Guru</p>
            </div>
            <div class="icon">
                <i class="fas fa-id-card nav-icon"></i>
            </div>
            <a href="{{ route('guru.index') }}" style="color: #FFFFFF !important;" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $siswa }}</h3>
                <p>Siswa</p>
            </div>
            <div class="icon">
                <i class="fas fa-id-card nav-icon"></i>
            </div>
            <a href="/daftarkelas/update" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $kelas }}</h3>
                <p>Kelas</p>
            </div>
            <div class="icon">
                <i class="fas fa-home nav-icon"></i>
            </div>
            <a href="/daftarkelas/update" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $mapel }}</h3>
                <p>Mata Pelajaran</p>
            </div>
            <div class="icon">
                <i class="fas fa-book nav-icon"></i>
            </div>
            <a href="{{ route('mapel.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
      
    </div>

     @if (Auth::user()->role == 'Admin')

        <div class="col-lg-4 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $user }}</h3>
                    <p>Registrasi Pengguna</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus nav-icon"></i>
                </div>
                <a href="{{ route('user.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        @else
            <div class="col-lg-4 col-6"> </div>

        @endif


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
                        <div class="col-md-8">
                            <div class="chart-responsive">
                                <canvas id="pieChartGuru" height="200"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                <li><i class="far fa-circle text-primary"></i> Laki-laki</li>
                                <li><i class="far fa-circle text-danger"></i> Perempuan</li>
                            </ul>
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
                        <div class="col-md-8">
                            <div class="chart-responsive">
                                <canvas id="pieChartSiswa" height="200"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                <li><i class="far fa-circle text-primary"></i> Laki-laki</li>
                                <li><i class="far fa-circle text-danger"></i> Perempuan</li>
                            </ul>
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
                        <div class="col-md-8">
                            <div class="chart-responsive">
                                <canvas id="pieChartPaket" height="150"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                <li><i class="far fa-circle" style="color: #d4c148"></i> Ilmu Pengetahuan Alam</li>
                                <li><i class="far fa-circle" style="color: #ba6906"></i> Ilmu Pengetahuan Sosial</li>
                            </ul>
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
                            <div class="chart-responsive" style="width:1100px;">
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
                title: {
                    display: true,
                    text: 'Data Siswa'
                },
                scales: {
                    xAxes: [{
                    barPercentage: 0.3
                 }]
                }
            }
        });
    };
</script>
@endsection
@section('script')
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
                    data: [{{ $gurulk }}, {{ $gurupr }}],
                    backgroundColor : ['#007BFF', '#DC3545'],
                    }
                ]
            }
            var pieOptions     = {
                legend: {
                    display: false
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
                    data: [{{ $siswalk }}, {{ $siswapr }}],
                    backgroundColor : ['#007BFF', '#DC3545'],
                    }
                ]
            }
            var pieOptions     = {
                legend: {
                    display: false
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
                    'Bisnis kontruksi dan Properti',
                    'Desain Permodelan dan Informasi Bangunan',
                    'Elektronika Industri',
                    'Otomasi Industri',
                    'Teknik dan Bisnis Sepeda Motor',
                    'Rekayasa Perangkat Lunak',
                    'Teknik Pemesinan',
                    'Teknik Pengelasan',
                ],
                datasets: [
                    {
                    data: [{{ $bkp }}, {{ $dpib }}, {{ $ei }}, {{ $oi }}, {{ $tbsm }}, {{ $rpl }}, {{ $tpm }}, {{ $las }}],
                    backgroundColor : ['#d4c148', '#ba6906', '#ff990a', '#00a352', '#2cabe6', '#999999', '#0b2e75', '#7980f7'],
                    }
                ]
            }
            var pieOptions     = {
                legend: {
                    display: false
                }
            }
            var pieChart = new Chart(pieChartCanvasPaket, {
                type: 'doughnut',
                data: pieDataPaket,
                options: pieOptions      
            })
        setInterval(function() {
          var date = new Date();
          var hari = date.getDay();
          var h = date.getHours();
          var m = date.getMinutes();
          h = (h < 10) ? "0" + h : h;
          m = (m < 10) ? "0" + m : m;
          var jam = h + ":" + m;
          
          if (hari == '0' || hari == '6') {
            $("#data-jadwal").html(
              `<tr>
                <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Sekolah Libur!</td>
              </tr>`
            );
          } else {
            if (jam <= '07:00') {
              $("#data-jadwal").html(
                `<tr>
                  <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Jam Pelajaran Hari ini Akan Segera Dimulai!</td>
                </tr>`
              );
            } else if (
              hari == '1' && jam >= '16:15' ||
              hari == '2' && jam >= '16:00' ||
              hari == '3' && jam >= '16:00' ||
              hari == '4' && jam >= '16:00' ||
              hari == '5' && jam >= '15:40'
            ) {
              $("#data-jadwal").html(
                `<tr>
                  <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Jam Pelajaran Hari ini Sudah Selesai!</td>
                </tr>`
              );
            } else {
              if (
                hari == '1' && jam >= '09:45' && jam <= '10:15' ||
                hari == '1' && jam >= '12:30' && jam <= '13:15' ||
                hari == '2' && jam >= '09:15' && jam <= '09:45' ||
                hari == '2' && jam >= '12:00' && jam <= '13:00' ||
                hari == '3' && jam >= '09:15' && jam <= '09:45' ||
                hari == '3' && jam >= '12:00' && jam <= '13:00' ||
                hari == '4' && jam >= '09:15' && jam <= '09:45' ||
                hari == '4' && jam >= '12:00' && jam <= '13:00' ||
                hari == '5' && jam >= '09:00' && jam <= '09:15' ||
                hari == '5' && jam >= '11:15' && jam <= '13:00'
              ) {
                $("#data-jadwal").html(
                  `<tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Istirahat!</td>
                  </tr>`
                );
              } else if (hari == '1' && jam >= '07:00' && jam <= '07:30') {
                $("#data-jadwal").html(
                  `<tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Waktunya Upacara Bendera!</td>
                  </tr>`
                );
              } else {
                $.ajax({
                  type:"GET",
                  data: {
                    hari : hari,
                    jam : jam
                  },
                  dataType:"JSON",
                  url:"{{ url('/jadwal/sekarang') }}",
                  success:function(data){
                    var html = "";
                    $.each(data, function (index, val) {
                        html += "<tr>";
                          html += "<td>" + val.jam_mulai + ' - ' + val.jam_selesai + "</td>";
                          html += "<td><h5 class='card-title'>" + val.mapel + "</h5><p class='card-text'><small class='text-muted'>" + val.guru + "</small></p></td>";
                          html += "<td>" + val.kelas + "</td>";
                          html += "<td>" + val.ruang + "</td>";
                          if (val.ket != null) {
                            html += "<td><div style='margin-left:20px;width:30px;height:30px;background:#"+val.ket+"'></div></td>";
                          } else {
                            html += "<td></td>";
                          }
                        html += "</tr>";
                    });
                    $("#data-jadwal").html(html);
                  },
                  error:function(){
                  }
                });
              }
            }
          }
        }, 60 * 1000);
      });
      
      $("#Dashboard").addClass("active");
      $("#liDashboard").addClass("menu-open");
      $("#Home").addClass("active");
      $("#AdminHome").addClass("active");
    </script>
@endsection
