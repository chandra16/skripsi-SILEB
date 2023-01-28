<?php

namespace App\Http\Controllers;

use Auth;
use App\Guru;
use App\Siswa;
use App\Kelas;
use App\Jadwal;
use App\Mapel;
use App\Nilai;
use App\Ulangan;
use App\Rapot;
use App\TahunAjaran;
use App\JadwalUjian;
use App\TipeUjian;
use App\Question;
use App\QuestionModels;
use App\QuestionOptions;
use App\Ujian;
use App\UjianJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class UlanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $jadwal = Jadwal::where('guru_id', $guru->id)->orderBy('nama_kelas')->get();
        $kelas = $jadwal->groupBy('nama_kelas');
        return view('guru.ulangan.kelas', compact('kelas', 'guru'));
    }

    public function datakelas()
    {
        $tahun = TahunAjaran::latest()->first();
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $jadwal = Jadwal::where('guru_id', $guru->id)->where('tahun_ajaran', isset($tahun) ? $tahun->nama : '0')->orderBy('nama_kelas')->get();
        $kelas = $jadwal->groupBy('nama_kelas');
        return view('guru.ulangan.kelas', compact('kelas', 'guru', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tahun = TahunAjaran::latest()->first();
        $kelas = Kelas::where('tahun_ajaran', $tahun->nama)->orderBy('nama_kelas')->get();
        return view('admin.ulangan.home', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guru = Guru::findorfail($request->guru_id);
        $cekJadwal = Jadwal::where('guru_id', $guru->id)->where('nama_kelas', $request->kelas_id)->where('tahun_ajaran', $request->tahunajaran)->count();

        if ($cekJadwal >= 1) {
            if ($request->ulha_1 && $request->ulha_2 && $request->uts && $request->ulha_3 && $request->uas) {
                $nilai = ($request->ulha_1 + $request->ulha_2 + $request->uts + $request->ulha_3 + (2 * $request->uas)) / 6;
                $nilai = (int) $nilai;
                $deskripsi = Nilai::where('guru_id', $request->guru_id)->first();
                $isi = Nilai::where('guru_id', $request->guru_id)->count();
                if ($isi >= 1) {
                    if ($nilai > 90) {
                        Rapot::create([
                            'siswa_id' => $request->siswa_id,
                            'kelas_id' => $request->kelas_id,
                            'guru_id' => $request->guru_id,
                            'mapel_id' => $guru->mapel_id,
                            'p_nilai' => $nilai,
                            'p_predikat' => 'A',
                            'p_deskripsi' => $deskripsi->deskripsi_a,
                            'k_nilai' => $nilai,
                            'k_predikat' => 'A',
                            'k_deskripsi' => $deskripsi->deskripsi_d,
                        ]);
                    } else if ($nilai > 80) {
                        Rapot::create([
                            'siswa_id' => $request->siswa_id,
                            'kelas_id' => $request->kelas_id,
                            'guru_id' => $request->guru_id,
                            'mapel_id' => $guru->mapel_id,
                            'p_nilai' => $nilai,
                            'p_predikat' => 'B',
                            'p_deskripsi' => $deskripsi->deskripsi_b,
                            'k_nilai' => $nilai,
                            'k_predikat' => 'B',
                            'k_deskripsi' => $deskripsi->deskripsi_d,
                        ]);
                    } else if ($nilai > 70) {
                        Rapot::create([
                            'siswa_id' => $request->siswa_id,
                            'kelas_id' => $request->kelas_id,
                            'guru_id' => $request->guru_id,
                            'mapel_id' => $guru->mapel_id,
                            'p_nilai' => $nilai,
                            'p_predikat' => 'C',
                            'p_deskripsi' => $deskripsi->deskripsi_c,
                            'k_nilai' => $nilai,
                            'k_predikat' => 'C',
                            'k_deskripsi' => $deskripsi->deskripsi_d,
                        ]);
                    } else {
                        Rapot::create([
                            'siswa_id' => $request->siswa_id,
                            'kelas_id' => $request->kelas_id,
                            'guru_id' => $request->guru_id,
                            'mapel_id' => $guru->mapel_id,
                            'p_nilai' => $nilai,
                            'p_predikat' => 'D',
                            'p_deskripsi' => $deskripsi->deskripsi_d,
                            'k_nilai' => $nilai,
                            'k_predikat' => 'D',
                            'k_deskripsi' => $deskripsi->deskripsi_d,
                        ]);
                    }
                } else {
                    return response()->json(['error' => 'Tolong masukkan deskripsi predikat anda terlebih dahulu!']);
                }
            }
            Ulangan::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'siswa_id' => $request->siswa_id,
                    'kelas_id' => $request->kelas_id,
                    'guru_id' => $request->guru_id,
                    'mapel_id' => $guru->mapel_id,
                    'ulha_1' => $request->ulha_1,
                    'ulha_2' => $request->ulha_2,
                    'uts' => $request->uts,
                    'ulha_3' => $request->ulha_3,
                    'uas' => $request->uas,
                ]
            );
            return response()->json(['success' => 'Nilai ulangan siswa berhasil ditambahkan!']);
        } else {
            return response()->json(['error' => 'Maaf guru ini tidak mengajar kelas ini!']);
        }
    }

    public function postNilai(Request $request)
    {

        $guru = Guru::findorfail($request->guru_id);
        $cekJadwal = Jadwal::where('guru_id', $guru->id)->where('nama_kelas', $request->kelas_id)->where('tahun_ajaran', $request->tahunajaran)->count();

        if ($cekJadwal >= 1) {
            if ($request->ulha_1 && $request->ulha_2 && $request->uts && $request->ulha_3 && $request->uas) {
                $nilai = ($request->ulha_1 + $request->ulha_2 + $request->uts + $request->ulha_3 + (2 * $request->uas)) / 6;
                $nilai = (int) $nilai;
                $deskripsi = Nilai::where('guru_id', $request->guru_id)->first();
                $isi = Nilai::where('guru_id', $request->guru_id)->count();
                if ($isi >= 1) {
                    if ($nilai > 90) {
                        Rapot::create([
                            'siswa_id' => (string)$request->siswa_id,
                            'kelas_id' => (string)$request->kelas_id,
                            'guru_id' => (string)$request->guru_id,
                            'mapel_id' => (string)$guru->mapel_id,
                            'p_nilai' => $nilai,
                            'p_predikat' => 'A',
                            'p_deskripsi' => $deskripsi->deskripsi_a,
                        ]);
                    } else if ($nilai > 80) {
                        Rapot::create([
                            'siswa_id' => (string)$request->siswa_id,
                            'kelas_id' => (string)$request->kelas_id,
                            'guru_id' => (string)$request->guru_id,
                            'mapel_id' => $guru->mapel_id,
                            'p_nilai' => $nilai,
                            'p_predikat' => 'B',
                            'p_deskripsi' => $deskripsi->deskripsi_b,
                        ]);
                    } else if ($nilai > 70) {
                        Rapot::create([
                            'siswa_id' => (string)$request->siswa_id,
                            'kelas_id' => (string)$request->kelas_id,
                            'guru_id' => (string)$request->guru_id,
                            'mapel_id' => $guru->mapel_id,
                            'p_nilai' => $nilai,
                            'p_predikat' => 'C',
                            'p_deskripsi' => $deskripsi->deskripsi_c,

                        ]);
                    } else {
                        Rapot::create([
                            'siswa_id' => (string)$request->siswa_id,
                            'kelas_id' => (string) $request->kelas_id,
                            'guru_id' => (string)$request->guru_id,
                            'mapel_id' => $guru->mapel_id,
                            'p_nilai' => $nilai,
                            'p_predikat' => 'D',
                            'p_deskripsi' => $deskripsi->deskripsi_d,

                        ]);
                    }
                } else {
                    return response()->json(['error' => 'Tolong masukkan deskripsi predikat anda terlebih dahulu!']);
                }
            }
            Ulangan::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'siswa_id' => (string)$request->siswa_id,
                    'kelas_id' => (string)$request->kelas_id,
                    'guru_id' => (string)$request->guru_id,
                    'mapel_id' => (string)$request->mapel_id,
                    'ulha_1' => (string)$request->ulha_1,
                    'ulha_2' => (string)$request->ulha_2,
                    'uts' => (string)$request->uts,
                    'ulha_3' => (string)$request->ulha_3,
                    'uas' => (string)$request->uas,
                ]
            );
            return response()->json(['success' => 'Nilai ulangan siswa berhasil ditambahkan!']);
        } else {
            return response()->json(['error' => 'Maaf guru ini tidak mengajar kelas ini!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::where('kelas_id', $id)->get();
        return view('guru.ulangan.nilai', compact('guru', 'kelas', 'siswa'));
    }

    public function addNilai($id, $tahunajaran)
    {
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $tahun_ajaran = $tahunajaran;
        $kelas = Kelas::where('nama_kelas', $id)->get();
        $namaKelas = $id;
        $guruId = $guru->id_card;
        $siswa = Siswa::where('kelas_id', $id)->where('tahun_ajaran', $tahunajaran)->get();
        return view('guru.ulangan.nilai', compact('guru', 'kelas', 'siswa', 'namaKelas', 'guruId', 'tahun_ajaran'));
    }

    public function showNilaiUlangan($id, $tahunajaran, $mapel)
    {

        $jadwal = Jadwal::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran)->where('mapel_id', $mapel)->first();
        $guru = Guru::findorfail($jadwal->guru_id);
        $tahun_ajaran = $tahunajaran;
        $kelas = Kelas::where('nama_kelas', $id)->get();
        $namaKelas = $id;
        $guruId = $guru->id_card;
        $siswa = Siswa::where('kelas_id', $id)->where('tahun_ajaran', $tahunajaran)->get();
        return view('kepsek.nilaiulanganperclass', compact('guru', 'kelas', 'siswa', 'namaKelas', 'guruId', 'tahun_ajaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::orderBy('nama_siswa')->where('kelas_id', $kelas->nama_kelas)->get();
        return view('admin.ulangan.index', compact('kelas', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ulangan($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $jadwal = Jadwal::orderBy('mapel_id')->where('nama_kelas', $kelas->nama_kelas)->get();
        $mapel = $jadwal->groupBy('mapel_id');
        return view('admin.ulangan.show', compact('mapel', 'siswa', 'kelas'));
    }

    public function ulanganadmin($id, $tahunajaran)
    {
        $siswa = Siswa::where('kelas_id', $id)->where('tahun_ajaran', $tahunajaran);
        $kelas = Kelas::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran);
        $jadwal = Jadwal::orderBy('mapel_id')->where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran)->get();
        $mapel = $jadwal->groupBy('mapel_id');
        return view('admin.ulangan.show', compact('mapel', 'siswa', 'kelas'));
    }

    public function siswa()
    {
        $tahunajaran = TahunAjaran::latest()->first();
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $kelas = Kelas::where('nama_kelas', $siswa->kelas_id)->where('tahun_ajaran', $tahunajaran->nama)->first();
        $jadwal = Jadwal::where('nama_kelas', $kelas->nama_kelas)->where('tahun_ajaran', $tahunajaran->nama)->orderBy('mapel_id')->get();
        $mapel = $jadwal->groupBy('mapel_id');
        return view('siswa.ulangan', compact('siswa', 'kelas', 'mapel'));
    }

    public function showTahunAjaran()
    {
        $tahunajaran = TahunAjaran::OrderBy('nama', 'asc')->get();
        return view('admin.nilaiulangan.home', compact('tahunajaran'));
    }

    /**
     * FUNCTION MODEL SOAL
     */
    public function listModelSoal()
    {
        $tipeujian = TipeUjian::all();
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $mapel = Mapel::where('id', $guru->mapel_id)->first();
        $modelsoal = QuestionModels::where('mapel_id', $guru->mapel_id)->OrderBy('created_at', 'desc')->get();

        return view('guru.ujianonline.modelsoal.list', compact('modelsoal', 'tipeujian', 'mapel'));
    }

    public function detailModelSoal($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $mapel = Mapel::where('id', $guru->mapel_id)->first();
        $soal = Question::where('question_model_id', $id)->withTrashed()->get();
        $modelsoal = QuestionModels::where('id', $id)->first();

        return view('guru.ujianonline.modelsoal.detail', compact('mapel', 'modelsoal', 'soal'));
    }

    public function simpanModelSoal(Request $request)
    {
        $this->validate($request, [
            'tipe_ujian_id' => 'required',
            'mapel_id' => 'required',
            'nama_model_soal' => 'required'
        ]);

        QuestionModels::create([
            'tipe_ujian_id' => $request->tipe_ujian_id,
            'mapel_id' => $request->mapel_id,
            'nama_model_soal' => $request->nama_model_soal
        ]);

        return redirect()->back()->with('success', 'Model soal berhasil ditambahkan!');
    }

    /**
     * FUNCTION SOAL
     */
    public function simpanSoalPilihanBerganda(Request $request)
    {
        $this->validate($request, [
            'question_model_id' => 'required',
            'question_text' => 'required',
            'answer_explanation' => 'required',
            'grade' => 'required',
        ]);

        $question = Question::create([
            'question_model_id' => $request->question_model_id,
            'question_text' => $request->question_text,
            'answer_explanation' => $request->answer_explanation,
            'grade' => $request->grade,
            'type' => 'Pilihan Berganda'
        ]);

        foreach ($request->input() as $key => $value) {
            if (strpos($key, 'opsi') !== false && $value != '') {
                $status = $request->input('question_answer') == $key ? 1 : 0;
                QuestionOptions::create([
                    'question_id' => $question->id,
                    'option'      => $value,
                    'correct'     => $status
                ]);
            }
        }

        return redirect()->back()->with('success', 'Soal pilihan berganda berhasil ditambahkan!');
    }

    public function viewEditSoalPilihanBerganda($id)
    {
        $id = Crypt::decrypt($id);
        $soal = Question::withTrashed()->findorfail($id);
        $modelsoal = QuestionModels::where('id', $soal->question_model_id)->first();
        $opsisoal = QuestionOptions::where('question_id', $soal->id)->OrderBy('created_at', 'asc')->withTrashed()->get();

        return view('guru.ujianonline.soal.editPilihanBerganda', compact('soal', 'modelsoal', 'opsisoal'));
    }

    public function editSoalPilihanBerganda(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $question = Question::find($id);

        $this->validate($request, [
            'question_text' => 'required',
            'answer_explanation' => 'required',
            'grade' => 'required',
        ]);

        if ($question->question_text !== $request->question_text) {
            $question->question_text = $request->question_text;
        }

        if ($question->answer_explanation !== $request->answer_explanation) {
            $question->answer_explanation = $request->answer_explanation;
        }

        if ($question->grade !== $request->grade) {
            $question->grade = $request->grade;
        }

        $question->save();

        return redirect()->back()->with('success', 'Soal berhasil diperbaharui!');
    }

    public function simpanSoalEssay(Request $request)
    {
        $this->validate($request, [
            'question_model_id' => 'required',
            'question_text' => 'required',
            'grade' => 'required',
        ]);

        Question::create([
            'question_model_id' => $request->question_model_id,
            'question_text' => $request->question_text,
            'grade' => $request->grade,
            'answer_explanation' => '',
            'type' => 'Essay'
        ]);

        return redirect()->back()->with('success', 'Soal essay berhasil ditambahkan!');
    }

    public function viewEditSoalEssay($id)
    {
        $id = Crypt::decrypt($id);
        $soal = Question::withTrashed()->findorfail($id);
        $modelsoal = QuestionModels::where('id', $soal->question_model_id)->first();;

        return view('guru.ujianonline.soal.editEssay', compact('soal', 'modelsoal'));
    }

    public function editSoalEssay(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $question = Question::find($id);

        $this->validate($request, [
            'question_text' => 'required',
            'grade' => 'required',
        ]);

        if ($question->question_text !== $request->question_text) {
            $question->question_text = $request->question_text;
        }

        if ($question->grade !== $request->grade) {
            $question->grade = $request->grade;
        }

        $question->save();

        return redirect()->back()->with('success', 'Soal berhasil diperbaharui!');
    }

    public function softDeleteSoal($id)
    {
        $id = Crypt::decrypt($id);
        $jadwal = Question::findorfail($id);
        $jadwal->delete();

        return redirect()->back()->with('warning', 'Data soal berhasil dihapus!');
    }

    public function restoreSoal($id)
    {
        $id = Crypt::decrypt($id);
        $jadwal = Question::withTrashed()->findorfail($id);
        $jadwal->restore();

        return redirect()->back()->with('info', 'Data soal berhasil direstore!');
    }

    public function udpateJawabanOpsi($id)
    {
        $id = Crypt::decrypt($id);
        $opsi = QuestionOptions::where('id', $id)->first();
        $opsiMassUpdate = QuestionOptions::where('question_id', $opsi->question_id)->update(['correct' => 0]);
        $opsi->correct = 1;
        $opsi->save();

        return redirect()->back()->with('info', 'Jawaban berhasil diperbaharui!');
    }

    public function tambahOpsi(Request $request)
    {
        $this->validate($request, [
            'question_id' => 'required',
            'opsi' => 'required',
        ]);

        QuestionOptions::create([
            'question_id' => $request->question_id,
            'option' => $request->opsi,
            'correct' => 0
        ]);

        return redirect()->back()->with('success', 'Opsi berhasil ditambahkan!');
    }

    public function hapusOpsi($id)
    {
        $id = Crypt::decrypt($id);
        QuestionOptions::where('id', $id)->forceDelete();

        return redirect()->back()->with('warning', 'Jawaban berhasil dihapus!');
    }

    /**
     *  UJIAN SISWA
     */
    public function mulaiUjian($id) {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $jadwalUjian = JadwalUjian::where('id', $id)->first();
        $question = Question::where('question_model_id', $jadwalUjian->question_model_id)->OrderBy('id', 'asc')->get();
        $ujian = Ujian::where('siswa_id', $siswa->id)->where('jadwal_ujian_id', $jadwalUjian->id)->first();

        if ($ujian === null) {
            $ujian = Ujian::create([
                'siswa_id' => $siswa->id,
                'jadwal_ujian_id' => $jadwalUjian->id,
                'hasil' => 0,
                'is_finish' => 0
            ]);
        } 

        foreach ($question as $key => $value) {
            $jawaban = UjianJawaban::where('question_id', $value->id)->where('ujian_id', $ujian->id)->first();

            if ($jawaban !== null) {
                if ($value->type === 'Essay') {
                    $value->jawaban = $jawaban->essay;
                } else {
                    $value->jawaban = $jawaban->question_option_id;
                }
            }

            if ($value->type == 'Pilihan Berganda') {
                $question_option = QuestionOptions::where('question_id', $value->id)->OrderBy('id', 'asc')->get();
                $value->question_option = $question_option;
            }
        }

        return view('siswa.ujian.ujian', compact('siswa', 'jadwalUjian', 'question', 'ujian'));
    }

    public function simpanUjianJawaban(Request $request) {
        $this->validate($request, [
            'ujian_id' => 'required',
            'question_id' => 'required',
            'jawaban' => 'required',
        ]);

        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $question = Question::where('id', $request->question_id)->first();
        $arrOfkondisi = [
            'siswa_id' => $siswa->id,
            'question_id' => $question->id,
            'ujian_id' => $request->ujian_id,
        ];
        $arrOfJawaban = [
            'siswa_id' => $siswa->id,
            'question_id' => $question->id,
            'ujian_id' => $request->ujian_id,
            'hasil' => 0,
            'is_finish' => 0
        ];

        if ($question->type === 'Pilihan Berganda') {
            $arrOfJawaban['question_option_id'] = $request->jawaban;
        } else {
            $arrOfJawaban['essay'] = $request->jawaban;
        }

        $ujianJawaban = UjianJawaban::updateOrCreate($arrOfkondisi, $arrOfJawaban);

        return response()->json(['success' => 'Berhasil menyimpan jawaban', 'data' => $ujianJawaban]);
    }

    public function selesaiUjian(Request $request) {
        $id = $request->idUjian;
        $ujian = Ujian::where('id', $id)->first();
        $ujian->is_finish = 1;
        $ujian->save();

        return response()->json(['success' => 'Berhasil menyimpan jawaban', 'data' => $ujian]);
    }

    /**
     * KOREKSI UJIAN
     */
    public function koreksiViewList($id) {
        $id = Crypt::decrypt($id);
        $jadwalUjian = JadwalUjian::where('id', $id)->first();
        $ujian = Ujian::where('jadwal_ujian_id', $jadwalUjian->id)->get();

        return view('guru.ujianonline.koreksi.list', compact('jadwalUjian', 'ujian'));
    }


    public function koreksiViewDetail($id) {
        $id = Crypt::decrypt($id);
        $ujian = Ujian::where('id', $id)->first();
        $ujianJawaban = UjianJawaban::where('ujian_id', $ujian->id)->get();

        foreach ($ujianJawaban as $key => $value) {
            $question = Question::where('id', $value->question_id)->first();
            $value->question = $question;

            if ($question->type == 'Pilihan Berganda') {
                $question_option = QuestionOptions::where('question_id', $question->id)->OrderBy('id', 'asc')->get();
                $value->question_option = $question_option;
            }
        }

        return view('guru.ujianonline.koreksi.detail', compact('ujian', 'ujianJawaban'));
    }

    public function simpanNilai(Request $request) {
        $jawaban = json_decode($request->jawaban);
        $totalScore = $request->totalScore;
        $idUjian = $request->idUjian;

        foreach ($jawaban as $key => $value) {
            $ujianJawaban = UjianJawaban::where('id', $value->id)->first();
            $ujianJawaban->mark = $value->score;
            $ujianJawaban->save();
        }

        $ujian = Ujian::where('id', $idUjian)->first();
        $ujian->hasil = $totalScore;
        $ujian->save();

        return response()->json(['success' => 'Berhasil menyimpan jawaban']);
    }
}
