<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('siswa')->insert([
            'id' => 1,
            'no_induk' => '1',
            'nis' => '1234567890',
            'nama_siswa' => 'Siswa Sample 1',
            'jk' => 'L',
            'telp' => '082208220822',
            'tmp_lahir' => 'Jakarta',
            'tgl_lahir' => '2022-10-10',
            'foto' => 'uploads/siswa/51482230102022_pain_rinnegan.jpg',
            'kelas_id' => 'X MIPA 1',
            'tahun_ajaran' => '2022-2023',
            'angkatan' => '10',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
