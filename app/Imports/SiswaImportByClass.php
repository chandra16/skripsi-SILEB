<?php

namespace App\Imports;

use App\Siswa;
use App\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImportByClass implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    private $nama_kelas;
    private $tahun_ajaran;
    private $angkatan;

    public function __construct($nama_kelas,$tahun_ajaran,$angkatan)
    {
        $this->nama_kelas = $nama_kelas;
        $this->tahun_ajaran = $tahun_ajaran;
        $this->angkatan = $angkatan;
    }
    public function model(array $row)
    {
        $kelas = Kelas::where('nama_kelas', $this->nama_kelas)->where('tahun_ajaran', $this->tahun_ajaran)->where('angkatan', $this->angkatan)->first();
        if ($row[2] == 'L') {
            $foto = 'uploads/siswa/52471919042020_male.jpg';
        } else {
            $foto = 'uploads/siswa/50271431012020_female.jpg';
        }

        return new Siswa([
            'nama_siswa' => $row[0],
            'no_induk' => $row[1],
            'jk' => $row[2],
            'foto' => $foto,
            'kelas_id' => $kelas->nama_kelas,
            'tahun_ajaran' => $kelas->tahun_ajaran,
            'angkatan' => $kelas->angkatan,
        ]);
    }
}
