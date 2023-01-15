@extends('template_backend.home')

@section('heading')
@endsection

@section('page')
<li class="breadcrumb-item active"> Laporan Ujian Online </li>
@endsection

@section('content')
<!-- .col -->
<div class="col-md-12">
    <div class="card">
        <!-- hidden-input -->
        <input id="id-guru" type="hidden" value="{{ $guru->id }}">
        <input id="id-mapel" type="hidden" value="{{ $mapel->id }}">
        <!-- .hidden-input -->
        <!-- card-header -->
        <div class="card-header">
            <br>
            <h4>
                <b>LAPORAN UJIAN ONLINE</b>
            </h4>
        </div>
        <!-- .card-header -->
        <!-- .card-body -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipe_ujian_id">Tipe Ujian</label>
                        <select id="tipe_ujian_id" name="tipe_ujian_id" class="form-control">
                            <option value="">-- Semua Tipe --</option>
                            @foreach ($tipeujian as $data)
                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="kelas_id">Kelas</label>
                        <select id="kelas_id" name="kelas_id" class="form-control">
                            <option value="">-- Semua Kelas --</option>
                            @foreach ($kelas as $data)
                            <option value="{{ $data->nama_kelas }}">{{ $data->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <button id="btn-search" type="button" class="btn btn-primary" onclick="search()" disabled><i class="nav-icon fas fa-search"></i> &nbsp; Cari</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="info-banner" class="row"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">Siswa Lulus KKM</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span id="lbl-total-siswa" class="text-success"></span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="chart-responsive">
                                            <canvas id="chart-siswa-lulus-kkm" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">Rata-rata Nilai Per-Kelas</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success"></span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="chart-responsive">
                                            <canvas id="chart-avg-nilai-perkelas" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->
@endsection

@section('script')
<script>
    var data = {};

    $(document).ready(function() {
        initButtonSearch();
        search();
    });

    function initButtonSearch() {
        $('#btn-search').prop('disabled', false);
    }

    function search() {
        var tipeUjianId = $("#tipe_ujian_id").val();
        var kelas = $("#kelas_id").val();
        var payload = {
            tipeUjianId: tipeUjianId,
            kelas: kelas
        }

        $.ajax({
            url: `{{ route('guru.ujianOnline.searchLaporanUjianOnlineData') }}`,
            type: "GET",
            data: payload,
            dataType: 'json',
            success: function(result) {
                if (result.success === 'true') {
                    data = JSON.parse(result.data);
                    initInfoBanner();
                    initChart();
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function initInfoBanner() {
        var html = '';

        // KKM
        var valueKKM = (Object.keys(data).length > 0) ? ((data.nilai_kkm) ? data.nilai_kkm : 0) : 0;
        html += initInfo('KKM', valueKKM, 'bg-primary', 'fa fa-file-excel');

        // Nilai
        var valueAvgNilai = (Object.keys(data).length > 0) ? ((data.rata_rata_nilai) ? data.rata_rata_nilai : 0) : 0;
        html += initInfo('Rata - rata nilai', valueAvgNilai, 'bg-danger', 'fa fa-edit');

        // Siswa
        var valueSiswa = (Object.keys(data).length > 0) ? ((data.total_siswa) ? data.total_siswa : 0) : 0;
        var valueSiswaUjian = (Object.keys(data).length > 0) ? ((data.total_siswa_ujian) ? data.total_siswa_ujian : 0) : 0;
        html += initInfo('Siswa Melakukan Ujian', (valueSiswaUjian + ' / ' + valueSiswa), 'bg-warning', 'fa fa-user-circle');

        // Jadwal
        var valueJadwalUjian = (Object.keys(data).length > 0) ? ((data.total_jadwal_ujian) ? data.total_jadwal_ujian : 0) : 0;
        html += initInfo('Jadwal Ujian', valueJadwalUjian, 'bg-info', 'fa fa-tasks');

        $('#info-banner').html(html);
    }

    function initInfo(label, value, bg_color, fa_icon) {
        var html = `
            <div class="col-md-3">
                <div class="small-box ${bg_color}">
                    <div class="inner">
                        <h3>${ value }</h3>
                        <p>${ label }</p>
                    </div>
                    <div class="icon">
                        <i class="${fa_icon} nav-icon"></i>
                    </div>
                </div>
            </div>
        `

        return html;
    }

    function initChart() {
        initChartSiswaLuluKKM();
        initChartAvgNilaiPerKelas();
    }

    function initChartSiswaLuluKKM() {
        var valueSiswaUjian = (Object.keys(data).length > 0) ? ((data.total_siswa_ujian) ? data.total_siswa_ujian : 0) : 0;
        var dataSiswaLulusKKM = (Object.keys(data).length > 0) ? ((data.total_siswa_passed) ? data.total_siswa_passed : 0) : 0;
        var dataSiswaTidakLulusKKM = (Object.keys(data).length > 0) ? ((data.total_siswa_not_passed) ? data.total_siswa_not_passed : 0) : 0;
        var persenSiswaLulus = (valueSiswaUjian > 0) ? (dataSiswaLulusKKM/valueSiswaUjian)*100 : 0;
        var pieChartCanvas = $('#chart-siswa-lulus-kkm').get(0).getContext('2d')
        var pieData = {
            labels: [
                'Lulus', 
                'Tidak Lulus',
            ],
            datasets: [
                {
                    data: [dataSiswaLulusKKM, dataSiswaTidakLulusKKM],
                    backgroundColor: ["#007BFF", "#DC3545"],
                }
            ]
        };

        var pieOptions = {
            legend: { 
                display: true,
                position: 'right',
                labels: {
                    fontSize: 16
                }
            },
        }

        var pieChart = new Chart(
            pieChartCanvas, 
            {
                type: 'doughnut',
                data: pieData,
                options: pieOptions
            }
        )

        $('#lbl-total-siswa').html(`<b>${(persenSiswaLulus).toFixed(0)} %</b>`);
    }

    function initChartAvgNilaiPerKelas() {
        var dataSiswaUjian = (Object.keys(data).length > 0) ? ((data.dataSiswaUjian) ? data.dataSiswaUjian : {}) : {};
        var arrLabels = [];
        var arrValue = [];

        if (Object.keys(dataSiswaUjian).length > 0) {
            var arrayKelasData = [];

            // dataSiswaUjian = [
            //     {"hasil":75,"nama_siswa":"Siswa Sample 1","kelas_id":"X MIPA 1"},
            //     {"hasil":73,"nama_siswa":"Siswa Sample 2","kelas_id":"X MIPA 1"},
            //     {"hasil":72,"nama_siswa":"Siswa Sample 3","kelas_id":"X MIPA 1"},
            //     {"hasil":70,"nama_siswa":"Siswa Sample 4","kelas_id":"X MIPA 1"},
            //     {"hasil":70,"nama_siswa":"Siswa Sample 1","kelas_id":"X MIPA 2"},
            //     {"hasil":85,"nama_siswa":"Siswa Sample 2","kelas_id":"X MIPA 2"},
            //     {"hasil":92,"nama_siswa":"Siswa Sample 3","kelas_id":"X MIPA 2"},
            //     {"hasil":70,"nama_siswa":"Siswa Sample 4","kelas_id":"X MIPA 2"},
            // ]

            for (let index = 0; index < dataSiswaUjian.length; index++) {
                const element = dataSiswaUjian[index];
                var kelasExistData = arrayKelasData.some(item => item.namaKelas === element.kelas_id);

                if (kelasExistData) {
                    var idx = arrayKelasData.findIndex(item => item.namaKelas === element.kelas_id);
                    var exisingObj = arrayKelasData[idx]
                    var obj = {
                        namaKelas: element.kelas_id,
                        totalNilai: (exisingObj.totalNilai + element.hasil),
                        totalSiswa: (exisingObj.totalSiswa + 1),
                    }

                    arrayKelasData[idx] = obj;
                    
                } else {
                    var obj = {
                        namaKelas: element.kelas_id,
                        totalNilai: element.hasil,
                        totalSiswa: 1,
                    }

                    arrayKelasData.push(obj);
                }
            }

            arrayKelasData.forEach(element => {
                arrLabels.push(element.namaKelas);
                arrValue.push((element.totalNilai/element.totalSiswa).toFixed(2));
            });
        }

        var pieChartCanvas = $('#chart-avg-nilai-perkelas').get(0).getContext('2d');
        var pieData = {
            labels: arrLabels,
            datasets: [
                {            
                    label: 'Nilai Rata - Rata',
                    backgroundColor: 'Green',
                    data: arrValue
                }
            ]
        };

        var pieOptions = {
            legend: { 
                display: true,
                position: 'bottom',
                labels: {
                    fontSize: 16
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        max: 100,
                        min: 0
                    }
                }],
                xAxes: [{
                    barPercentage: 0.3
                }]
            }
        }

        var pieChart = new Chart(
            pieChartCanvas, 
            {
                type: 'bar',
                data: pieData,
                options: pieOptions
            }
        )
    }
</script>
@endsection