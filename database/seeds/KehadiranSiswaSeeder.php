<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KehadiranSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kehadiransiswa')->insert([
            'id' => 1,
            'ket' => 'Hadir',
            'color' => '3C0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('kehadiransiswa')->insert([
            'id' => 2,
            'ket' => 'Izin',
            'color' => '0CF',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        DB::table('kehadiransiswa')->insert([
            'id' => 3,
            'ket' => 'Sakit',
            'color' => 'FF0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        DB::table('kehadiransiswa')->insert([
            'id' => 4,
            'ket' => 'Tanpa Keterangan',
            'color' => 'F00',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    
    }
}
