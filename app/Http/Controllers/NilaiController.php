<?php

namespace App\Http\Controllers;

use DB;
use stdClass;
use App\Guru;
use App\Nilai;
use App\Kelas;
use App\Mapel;
use App\TipeUjian;
use App\TahunAjaran;
use App\JadwalUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $nilai = Nilai::where('guru_id', $guru->id)->first();
        return view('guru.nilai', compact('nilai', 'guru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guru = Guru::orderBy('kode')->get();
        return view('admin.nilai.index', compact('guru'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guru = Guru::where('kode', $request->guru_id)->first();

        Nilai::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'guru_id' => $guru->id,
                'kkm' => $request->kkm,
                'deskripsi_a' => $request->predikat_a,
                'deskripsi_b' => $request->predikat_b,
                'deskripsi_c' => $request->predikat_c,
                'deskripsi_d' => $request->predikat_d,
            ]
        );

        return redirect()->back()->with('success', 'Data nilai kkm dan predikat berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 
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

    /**
     * LAPORAN UJIAN ONLINE
     */
    public function viewLaporanUjianOnline()
    {
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $mapel = Mapel::where('id', $guru->mapel_id)->first();
        $kelas = Kelas::where('angkatan', $mapel->angkatan)->where('tahun_ajaran', $mapel->tahun_ajaran)->get();
        $tahunajaran = TahunAjaran::all();
        $tipeujian = TipeUjian::all();

        return view('guru.nilai.laporanUjianOnline', compact('tahunajaran', 'tipeujian', 'mapel', 'guru', 'kelas'));
    }

    public function searchLaporanUjianOnlineData(Request $request)
    {
        $paramKelas = $request->kelas;
        $paramTipeUjianId = $request->tipeUjianId;
        
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $mapel = Mapel::where('id', $guru->mapel_id)->first();
        $kelas = Kelas::where('angkatan', $mapel->angkatan)->where('tahun_ajaran', $mapel->tahun_ajaran)->where('paket_id', $mapel->paket_id)->get();
        $nilaiKKM = Nilai::where('guru_id', $guru->id)->first();

        $listTahunAjaran = '"' . $mapel->tahun_ajaran . '"';
        $listKelas = '';

        for ($i=0; $i < count($kelas); $i++) { 
            $value = $kelas[$i];
            $listKelas = $listKelas . '"' . $value->nama_kelas . '"';

            if ($i < count($kelas) - 1) {
                $listKelas = $listKelas . ', ';
            }
        }

        $queryKelasId = '';
        $queryTipeUjian = '';

        if ($paramKelas) {
            $queryKelasId = 'ju.nama_kelas = "' . $paramKelas . '" AND';
            $listKelas = '"' . $paramKelas . '"';
        }

        if ($paramTipeUjianId) {
            $queryTipeUjian = 'ju.tipe_ujian_id = "' . $paramTipeUjianId . '" AND';
        }

        $queryJadwalUjian = '
            SELECT 
                ju.*
            FROM jadwalujian ju
            WHERE 
                ' . $queryTipeUjian . '
                ' . $queryKelasId . '
                ju.mapel_id = "' . $mapel->id . '" AND
                ju.question_model_id IS NOT NULL AND
                ju.deleted_at IS NULL
            ;
        ';

        $dataJadwalUjian = DB::select($queryJadwalUjian);

        $queryGetDataSeluruhSiswa = '
            SELECT COUNT(id) AS total_data
            FROM siswa s
            WHERE 
                s.tahun_ajaran IN (' . $listTahunAjaran . ') AND
                s.kelas_id IN (' . $listKelas . ') AND
                s.deleted_at IS NULL
        ';

        $dataSeluruhSiswa = DB::select($queryGetDataSeluruhSiswa);

        $queryGetDataSiswaUjian = '
            SELECT u.hasil, s.nama_siswa, s.kelas_id
            FROM ujian u
            INNER JOIN siswa s ON s.id = u.siswa_id
            INNER JOIN jadwalujian ju ON ju.id = u.jadwal_ujian_id
            WHERE 
                u.is_finish = 1 AND
                ' . $queryTipeUjian . '
                s.tahun_ajaran IN (' . $listTahunAjaran . ') AND
                s.kelas_id IN (' . $listKelas . ') AND
                s.deleted_at IS NULL
        ';

        $dataSeluruhSiswaUjian = DB::select($queryGetDataSiswaUjian);

        $KKM = ($nilaiKKM->kkm) ? $nilaiKKM->kkm : 0;
        $totalSiswaUjian = count($dataSeluruhSiswaUjian);
        $totalNilaiSiswa = 0;
        $totalSiswaPassed = 0;

        for ($i=0; $i < count($dataSeluruhSiswaUjian); $i++) { 
            $value = $dataSeluruhSiswaUjian[$i];

            $totalNilaiSiswa += $value->hasil;

            if ($value->hasil >= $KKM) {
                $totalSiswaPassed += 1;
            }
        }

        $avgNilaiSiswa = ($totalSiswaUjian > 0) ? $totalNilaiSiswa/$totalSiswaUjian : 0;

        $data = new stdClass();
        $data -> total_jadwal_ujian = count($dataJadwalUjian);
        $data -> total_siswa = $dataSeluruhSiswa[0]->total_data;
        $data -> total_siswa_ujian = $totalSiswaUjian;
        $data -> rata_rata_nilai = number_format($avgNilaiSiswa, 2);
        $data -> total_siswa_passed = $totalSiswaPassed;
        $data -> total_siswa_not_passed = ($totalSiswaUjian >= $totalSiswaPassed) ? $totalSiswaUjian - $totalSiswaPassed : 0;
        $data -> nilai_kkm = $KKM;
        $data -> dataSiswaUjian = $dataSeluruhSiswaUjian;
        $dataJSON = json_encode($data);

        return response()->json([
            'success' => 'true',
            'data' => $dataJSON,
            'message' => 'Success get data laporan'
        ]);
    }
}
