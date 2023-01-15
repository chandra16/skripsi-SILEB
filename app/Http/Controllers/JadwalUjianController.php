<?php

namespace App\Http\Controllers;

use Auth;
use App\JadwalUjian;
use App\Hari;
use App\Kelas;
use App\Guru;
use App\Siswa;
use App\Ruang;
use App\Mapel;
use App\TahunAjaran;
use App\TipeUjian;
use App\QuestionModels;
use App\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use PDF;
use App\Exports\JadwalExport;
use App\Imports\JadwalImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use DB;

class JadwalUjianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunajaran = TahunAjaran::latest()->first();
        $hari = Hari::all();
        $tipeujian = TipeUjian::all();
        $kelas = Kelas::where('tahun_ajaran', isset($tahunajaran) ? $tahunajaran->nama : '0')->OrderBy('nama_kelas', 'asc')->get();
        $ruang = Ruang::all();
        $guru = Guru::OrderBy('kode', 'asc')->get();
        return view('admin.jadwalUjian.index', compact('hari', 'kelas', 'guru', 'ruang', 'tahunajaran', 'tipeujian'));
    }

    public function indexGuest()
    {
        $tahunajaran = TahunAjaran::latest()->first();
        $hari = Hari::all();
        $tipeujian = TipeUjian::all();
        $kelas = Kelas::where('tahun_ajaran', isset($tahunajaran) ? $tahunajaran->nama : '0')->OrderBy('nama_kelas', 'asc')->get();
        $ruang = Ruang::all();
        $guru = Guru::OrderBy('kode', 'asc')->get();
        return view('guest.jadwalUjian.index', compact('hari', 'kelas', 'guru', 'ruang', 'tahunajaran', 'tipeujian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tipe_ujian_id' => 'required',
            'tanggal' => 'required',
            'nama_kelas' => 'required',
            'guru_id' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'ruang_id' => 'required',
            'tahun_ajaran' => 'required',
        ]);

        $guru = Guru::findorfail($request->guru_id);
        JadwalUjian::updateOrCreate(
            [
                'id' => $request->jadwal_id
            ],
            [
                'tipe_ujian_id' => $request->tipe_ujian_id,
                'mapel_id' => $guru->mapel_id,
                'guru_id' => $request->guru_id,
                'ruang_id' => $request->ruang_id,
                'nama_kelas' => $request->nama_kelas,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'tahun_ajaran' => $request->tahun_ajaran,

            ]
        );

        return redirect()->back()->with('success', 'Data jadwal ujian berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $tahunajaran)
    {
        $kelas = Kelas::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran)->get();
        $jadwal = JadwalUjian::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran)->OrderBy('tanggal', 'desc')->OrderBy('jam_mulai', 'asc')->get();
        return view('admin.jadwalujian.show', compact('jadwal', 'kelas', 'tahunajaran'));
    }

    public function showJadwalForGuest($id, $tahunajaran)
    {
        $kelas = Kelas::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran)->get();
        $jadwal = JadwalUjian::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran)->OrderBy('tanggal', 'desc')->OrderBy('jam_mulai', 'asc')->get();
        return view('guest.jadwalujian.show', compact('jadwal', 'kelas'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id, $tahunajaran)
    {
        $id = Crypt::decrypt($id);
        $jadwal = JadwalUjian::findorfail($id);
        $hari = Hari::all();
        $kelas = Kelas::all();
        $ruang = Ruang::all();
        $tipeujian = TipeUjian::all();
        $guru = Guru::OrderBy('kode', 'asc')->get();
        return view('admin.jadwalujian.edit', compact('jadwal', 'hari', 'kelas', 'guru', 'ruang', 'tahunajaran', 'tipeujian'));
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
        $jadwal = JadwalUjian::findorfail($id);
        $jadwal->delete();

        return redirect()->back()->with('warning', 'Data jadwal ujian berhasil dihapus! (Silahkan cek trash data jadwal)');
    }

    public function trash()
    {
        $jadwal = JadwalUjian::onlyTrashed()->get();
        return view('admin.jadwalujian.trash', compact('jadwal'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $jadwal = JadwalUjian::withTrashed()->findorfail($id);
        $jadwal->restore();
        return redirect()->back()->with('info', 'Data jadwal ujian berhasil direstore! (Silahkan cek data jadwal)');
    }

    public function kill($id)
    {
        $jadwal = JadwalUjian::withTrashed()->findorfail($id);
        $jadwal->forceDelete();
        return redirect()->back()->with('success', 'Data jadwal ujian berhasil dihapus secara permanent');
    }

    public function view(Request $request)
    {
        $jadwal = JadwalUjian::where('nama_kelas', $request->nama_kelas)->where('tahun_ajaran', $request->tahun_ajaran)->OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->get();
        foreach ($jadwal as $val) {
            $newForm[] = array(
                'hari' => $val->hari->nama_hari,
                'mapel' => $val->mapel->nama_mapel,
                'kelas' => $val->nama_kelas,
                'guru' => $val->guru->nama_guru,
                'jam_mulai' => $val->jam_mulai,
                'jam_selesai' => $val->jam_selesai,
                'ruang' => $val->ruang->nama_ruang,
            );
        }
        return response()->json($newForm);
    }

    public function jadwalSekarang(Request $request)
    {
        $jadwal = JadwalUjian::OrderBy('jam_mulai')->OrderBy('jam_selesai')->OrderBy('nama_kelas')->where('hari_id', $request->hari)->where('jam_mulai', '<=', $request->jam)->where('jam_selesai', '>=', $request->jam)->get();
        foreach ($jadwal as $val) {
            $newForm[] = array(
                'mapel' => $val->mapel->nama_mapel,
                'kelas' => $val->kelas->nama_kelas,
                'guru' => $val->guru->nama_guru,
                'jam_mulai' => $val->jam_mulai,
                'jam_selesai' => $val->jam_selesai,
                'ruang' => $val->ruang->nama_ruang,
                'ket' => $val->absen($val->guru_id),
            );
        }
        return response()->json($newForm);
    }

    public function cetak_pdf(Request $request)
    {
        $jadwal = JadwalUjian::OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->where('nama_kelas', $request->id)->get();
        $kelas = Kelas::findorfail($request->nama);
        $pdf = PDF::loadView('jadwal-pdf', ['jadwal' => $jadwal, 'kelas' => $kelas]);
        return $pdf->stream();
        // return $pdf->stream('jadwal-pdf.pdf');
    }

    public function guru()
    {
        $tahunajaran = TahunAjaran::latest()->first();
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $jadwal = JadwalUjian::orderBy('hari_id')->OrderBy('jam_mulai')->where('guru_id', $guru->id)->where('tahun_ajaran', $tahunajaran->nama)->get();
        return view('guru.jadwal', compact('jadwal', 'guru'));
    }



    public function siswa()
    {
        $tahunajaran = TahunAjaran::latest()->first();
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $kelas = Kelas::where('nama_kelas', $siswa->kelas_id)->where('tahun_ajaran', $tahunajaran->nama)->first();
        $jadwal = JadwalUjian::orderBy('hari_id')->OrderBy('jam_mulai')->where('nama_kelas', $kelas->nama_kelas)->get();
        return view('siswa.jadwal', compact('jadwal', 'kelas', 'siswa'));
    }

    public function export_excel()
    {
        return Excel::download(new JadwalExport, 'jadwal.xlsx');
    }

    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_jadwal', $nama_file);
        Excel::import(new JadwalImport, public_path('/file_jadwal/' . $nama_file));
        return redirect()->back()->with('success', 'Data Siswa Berhasil Diimport!');
    }

    public function deleteAll()
    {
        $jadwal = JadwalUjian::all();
        if ($jadwal->count() >= 1) {
            JadwalUjian::whereNotNull('id')->delete();
            JadwalUjian::withTrashed()->whereNotNull('id')->forceDelete();
            return redirect()->back()->with('success', 'Data table jadwal berhasil dihapus!');
        } else {
            return redirect()->back()->with('warning', 'Data table jadwal kosong!');
        }
    }

    public function deleteJadwalById($id, $tahunajaran)
    {
        $jadwal = JadwalUjian::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran)->get();
        if ($jadwal->count() >= 1) {
            JadwalUjian::whereNotNull('id')->delete();
            JadwalUjian::withTrashed()->whereNotNull('id')->forceDelete();
            return redirect()->back()->with('success', 'Data table jadwal berhasil dihapus!');
        } else {
            return redirect()->back()->with('warning', 'Data table jadwal kosong!');
        }
    }

    public function showJadwalPerMapel($id, $mapel, $angkatan)
    {
        $tahunajaran = TahunAjaran::latest()->first();
        $kelas = Kelas::where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran->nama)->where('angkatan', $angkatan)->get();
        $jadwal = JadwalUjian::where('mapel_id', $mapel)->where('nama_kelas', $id)->where('tahun_ajaran', $tahunajaran->nama)->OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->get();
        return view('kepsek.daftarjadwal', compact('jadwal', 'kelas'));
    }

    /**
     *  FOR GURU
     */
    public function showJadwalUjianPerGuruLogin()
    {
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $mapel = Mapel::where('id', $guru->mapel_id)->first();
        $tahunajaran = TahunAjaran::latest()->first();
        $jadwal = JadwalUjian::where('mapel_id', $mapel->id)->OrderBy('tanggal', 'desc')->OrderBy('jam_mulai', 'asc')->get();
        $tipeujian = TipeUjian::all();

        return view('guru.ujianonline.jadwal.list', compact('jadwal', 'mapel', 'tipeujian'));
    }

    public function viewSetModelSoal($id)
    {
        $id = Crypt::decrypt($id);
        $jadwalUjian = JadwalUjian::where('id', $id)->first();
        $modelsoal = QuestionModels::where('tipe_ujian_id', $jadwalUjian->tipe_ujian_id)->where('mapel_id', $jadwalUjian->mapel_id)->get();

        return view('guru.ujianonline.jadwal.setModelSoal', compact('jadwalUjian', 'modelsoal'));
    }

    public function setModelSoal(Request $request)
    {
        $this->validate($request, [
            'question_model_id' => 'required',
            'jadwal_ujian_id' => 'required',
        ]);

        $jadwalUjian = JadwalUjian::where('id', $request->jadwal_ujian_id)->first();
        $jadwalUjian->question_model_id = $request->question_model_id;
        $jadwalUjian->save();

        return redirect()->back()->with('success', 'Model soal berhasil dipilih!');
    }

    /**
     * FOR SISWA
     */
    public function viewJadwalUjianSiswa()
    {
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $jadwalUjian = DB::select('
            SELECT 
                ju.*,
                g.nama_guru,
                r.nama_ruang,
                m.nama_mapel,
                tu.nama AS "nama_tipe_ujian",
                (SELECT COUNT(id) FROM question q WHERE q.question_model_id = ju.question_model_id) AS count_question,
                (SELECT COUNT(id) FROM question q WHERE q.question_model_id = ju.question_model_id AND q.type = "Essay") AS count_essay_question,
                (SELECT COUNT(id) FROM question q WHERE q.question_model_id = ju.question_model_id AND q.type = "Pilihan Berganda") AS count_pilber_question
            FROM jadwalujian ju
            JOIN guru g ON g.id = ju.guru_id
            JOIN ruang r ON r.id = ju.ruang_id
            JOIN mapel m ON m.id = ju.mapel_id
            JOIN tipe_ujian tu ON tu.id = ju.tipe_ujian_id
            WHERE 
                ju.nama_kelas = "' . $siswa->kelas_id . '" AND
                ju.tahun_ajaran = "' . $siswa->tahun_ajaran . '" AND
                ju.question_model_id IS NOT NULL AND
                ju.deleted_at IS NULL
            ORDER BY
                ju.tanggal DESC, 
                ju.jam_mulai ASC
            ;
        ');

        foreach ($jadwalUjian as $key => $value) {
            $ujian = Ujian::where('jadwal_ujian_id', $value->id)->where('siswa_id', $siswa->id)->first();

            if ($ujian !== null) {
                $value->nilai = $ujian->hasil;
                $value->ujian_diambil = 1;
                $value->ujian_selesai_diambil = $ujian->is_finish;
            } else {
                $value->nilai = 0;
                $value->ujian_diambil = 0;
                $value->ujian_selesai_diambil = 0;
            }
        }

        return view('siswa.ujian.jadwal', compact('jadwalUjian', 'siswa'));
    }
}
