<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kelas')->insert([
            'id' => 1,
            'nama_kelas' => 'X MIPA 1',
            'paket_id' => '1',
            'guru_id' => '00001',
            'angkatan' => '10',
            'tahun_ajaran' => '2022-2023',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
