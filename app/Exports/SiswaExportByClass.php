<?php

namespace App\Exports;

use App\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;

class SiswaExportByClass implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */

    private $nama_kelas;
    private $tahun_ajaran;

    public function __construct($nama_kelas,$tahun_ajaran)
    {
        $this->nama_kelas = $nama_kelas;
        $this->tahun_ajaran = $tahun_ajaran;
    }
    
    public function collection()
    {
        $siswa = Siswa::where('kelas_id',$this->nama_kelas)->where('tahun_ajaran',$this->tahun_ajaran)->get();
        $result = Siswa::join('kelas', 'kelas.nama_kelas', '=', 'siswa.kelas_id')->select('siswa.nama_siswa', 'siswa.no_induk', 'siswa.jk', 'kelas.nama_kelas')->get();
        return $result;

    }
}
