<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipeUjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipe_ujian')->insert([
            'id' => 1,
            'nama' => 'Ulangan Harian 1',
            'keterangan' => 'Merupakan Ulangan Harian 1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('tipe_ujian')->insert([
            'id' => 2,
            'nama' => 'Ulangan Harian 2',
            'keterangan' => 'Merupakan Ulangan Harian 2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('tipe_ujian')->insert([
            'id' => 3,
            'nama' => 'Ulangan Harian 3',
            'keterangan' => 'Merupakan Ulangan Harian 3',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('tipe_ujian')->insert([
            'id' => 4,
            'nama' => 'Ujian Tengah Semester',
            'keterangan' => 'Merupakan Ujian Tengah Semester',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('tipe_ujian')->insert([
            'id' => 5,
            'nama' => 'Ujian Akhir Semester',
            'keterangan' => 'Merupakan Ujian Akhir Semester',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
