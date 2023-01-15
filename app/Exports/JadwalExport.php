<?php

namespace App\Exports;

use App\Jadwal;
use App\TahunAjaran;
use Maatwebsite\Excel\Concerns\FromCollection;

class JadwalExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $tahunajaran=TahunAjaran::latest()->first();
        $jadwal = Jadwal::join('hari', 'hari.id', '=', 'jadwal.hari_id')
            ->join('kelas', 'kelas.nama_kelas', '=', 'jadwal.nama_kelas')
            ->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')
            ->join('guru', 'guru.id', '=', 'jadwal.guru_id')
            ->join('ruang', 'ruang.id', '=', 'jadwal.ruang_id')
            ->where('jadwal.tahun_ajaran',$tahunajaran->nama)
            ->select('hari.nama_hari', 'kelas.nama_kelas', 'mapel.nama_mapel', 'guru.nama_guru', 'jadwal.jam_mulai', 'jadwal.jam_selesai', 'ruang.nama_ruang')
            ->get();
        return $jadwal;
    }
}
