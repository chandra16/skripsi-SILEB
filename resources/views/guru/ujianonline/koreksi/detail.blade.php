@extends('template_backend.home')

@section('heading')
@endsection

@section('page')
<li class="breadcrumb-item active"><a href="{{ route('guru.ujianOnline.jadwal') }}">Jadwal Ujian</a></li>
<li class="breadcrumb-item active"><a href="{{ route('guru.ujianOnline.koreksi', Crypt::encrypt($ujian->jadwalUjian->id)) }}">List Siswa Ujian</a></li>
<li class="breadcrumb-item active"> {{ $ujian->siswa->nama_siswa }} </li>
@endsection

@section('content')
<!-- .col -->
<div class="col-md-12">
    <div class="card">
        <!-- hidden-input -->
        <input id="id-ujian" type="hidden" value="{{ $ujian->id }}">
        <!-- .hidden-input -->
        <!-- card-header -->
        <div class="card-header">
            <h4>
                <label>DETAIL JAWABAN</label>
            </h4>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <table id="tbl-siswa" class="table table-bordered">
                        <tr><td colspan="2"><label>SISWA</label></td></tr>
                        <tr>
                            <td>NIS</td>
                            <td>{{ $ujian->siswa->nis }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>{{ $ujian->siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td>{{ $ujian->siswa->kelas_id }}</td>
                        </tr>
                        <tr>
                            <td>Tahun Ajaran</td>
                            <td>{{ $ujian->siswa->tahun_ajaran }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table id="tbl-siswa" class="table table-bordered">
                        <tr><td colspan="2"><label>JADWAL UJIAN</label></td></tr>
                        <tr>
                            <td>Tangal</td>
                            <td>{{ date('l / d - F - Y', strtotime($ujian->jadwalUjian->tanggal)) }}</td>
                        </tr>
                        <tr>
                            <td>Waktu</td>
                            <td><i>{{ date('H:i', strtotime($ujian->jadwalUjian->jam_mulai)) }} - {{ date('H:i', strtotime($ujian->jadwalUjian->jam_selesai)) }}</i></td>
                        </tr>
                        <tr>
                            <td>Ruang</td>
                            <td>{{ $ujian->jadwalUjian->ruang->nama_ruang }}</td>
                        </tr>
                        <tr>
                            <td>Guru</td>
                            <td>{{ $ujian->jadwalUjian->guru->nama_guru }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- .card-header -->
        <!-- .card-body -->
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="50px">No.</th>
                                <th>Detail</th>
                                <th width="150px">Score</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-jawaban"></tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
                <div class="col-md-12" style="text-align: right;">
                    <a href="{{ route('guru.ujianOnline.koreksi', Crypt::encrypt($ujian->jadwalUjian->id)) }}" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-primary" onclick="simpanScore();"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan</button>
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
    var jawaban = {!! json_encode($ujianJawaban, JSON_HEX_TAG) !!};

    console.log(jawaban);

    $(document).ready(function() {
        initNavLocation();
        initTableJawaban();

        setTimeout(() => {
            initJawabanPilBer();
            countTotalNilai();
            initOnChangeScore();
            $('.textarea').summernote({ focus: true, height: 100 });
        }, 1000);
    });

    function initNavLocation() {
        $("#UjianOnlineGuru").addClass("active");
        $("#liUjianOnlineGuru").addClass("menu-open");
        $("#JadwalUjianOnlineGuru").addClass("active");
    }

    function initOnChangeScore() {
        $('.grade').change(function() {
            countTotalNilai();
        });
    }
    
    function initTableJawaban() {
        var html = '';

        jawaban.forEach((data, index) => {
            var question = data.question;
            var questionAnswer = data.essay;
            var grade = (data.mark) ? data.mark : 0;
            var alasan = `<textarea id="alasan-${question.id}" name="alasan" class="textarea"></textarea>`;
            
            
            if (question.type === 'Pilihan Berganda') {
                questionAnswer = "";
                alasan = question.answer_explanation;

                var questionOption = data.question_option;
                var questionCorrectAnswer = questionOption.filter(v => v.correct === 1)[0];
                var questionAnswerId = data.question_option_id;

                if (grade === 0) {
                    if (questionCorrectAnswer.id === questionAnswerId) {
                        grade = question.grade;
                    }
                }
                
                questionOption.forEach(element => {
                    var style = 'padding: .5rem .5rem .0rem .5rem;';

                    if ((element.id === questionAnswerId) && (element.correct === 1)) {
                        style += 'background-color: #96ff96;';
                    } else {
                        if (element.correct === 1) {
                            style += 'background-color: #96ff96;';
                        } else if (element.id === questionAnswerId) {
                            style += 'background-color: #ffa0a0;';
                        }
                    }

                    questionAnswer += `
                        <div id="opt-${element.id}" style="${style}">
                            <input type="radio" id="opsi-jawaban" name="opsi-soal-${question.id}" value="${element.id}" disabled>
                            <label for="opsi-jawaban" class="label-option">${element.option}</label><br>
                        </div>
                    `;
                });
            }

            var detailPertanyaan = `
                <table id="tbl-detail-pertanyaan" class="table table-striped">
                    <tr>
                        <td width="120px">
                            <b>Pertanyaan</b>
                        </td>
                        <td>
                            ${question.question_text}
                        </td>
                    </tr>
                    <tr>
                        <td width="120px">
                            <b>Jawaban</b>
                        </td>
                        <td>
                            ${questionAnswer}
                        </td>
                    </tr>
                </table>
            `;
                    
            // ALASAN
            // detailPertanyaan += `
            //     <tr>
            //         <td width="120px">
            //             <b>Alasan</b>
            //         </td>
            //         <td>
            //             ${alasan}
            //         </td>
            //     </tr>
            // `;

            html += `
                <tr id="tr-answer-${index + 1}">
                    <td>${index + 1}</td>
                    <td>
                        ${detailPertanyaan}
                    </td>
                    <td>
                        <div class="form-group">
                            Score Siswa
                            <input id="grade-${data.id}" type="number" class="grade form-control" data-question="${data.id}" value="${grade}"><br>
                            Score Maksimum
                            <input id="grade-full-${data.id}" class="grade-full form-control" type="text" value="${question.grade}" disabled> 
                        </div>
                    </td>
                </tr>
            `;
        });

        html += `
            <tr>
                <td colspan=2 style="text-align: right;vertical-align: middle !important;">
                    <span><b>Total Score</b></span>
                </td>
                <td>
                    <input id="total-grade" class="form-control" type="number" value="" style="width: 100% !important;">
                </td>
            </tr>
        `;

        $('#tbody-jawaban').html(html);
    }

    function initJawabanPilBer() {
        jawaban.forEach(element => {
            var question = element.question;

            if (question.type === 'Pilihan Berganda') {
                $(`input:radio[name="opsi-soal-${question.id}"]`).filter(`[value="${element.question_option_id}"]`).attr('checked', true);
            }
        });
    }

    function countTotalNilai() {
        var totalHasil = 0;

        $('.grade').each(function(index, element) {
            totalHasil += parseInt(element.value);
        });

        $('#total-grade').val(totalHasil);
    }

    function simpanScore() {
        var idUjian = $('#id-ujian').val();
        var totalScore = $('#total-grade').val();
        var arrUjian = [];

        $('.grade').each(function(index, element) {
            arrUjian.push({
                id: $(this).data('question'),
                score: $(this).val()
            })
        });

        var data = {
            _token: '{{ csrf_token() }}',
            jawaban: JSON.stringify(arrUjian),
            totalScore: totalScore,
            idUjian: idUjian
        };

        Swal
            .fire({
                title: "Perhatian !",
                html: "Anda yakin untuk menyimpan nilai ujian?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Ya, selesaikan ujian",
                cancelButtonText: "Tidak"
            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        url: `{{ route('guru.ujianOnline.koreksi.simpanNilai') }}`,
                        type: "POST",
                        data: data,
                        dataType: 'json',
                        success: function(result) {
                            Swal.fire("Success", "Berhasil menyimpan nilai !", "success");
                        },
                        error: function (result) {
                            
                        }
                    });
                }
            });
    }
</script>
@endsection