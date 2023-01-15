<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Kepala Sekolah Sample',
            'email' => 'kepalasekolah@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'KepSek',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'name' => 'Siswa Sample',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Siswa',
            'no_induk' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        DB::table('users')->insert([
            'id' => 4,
            'name' => 'Guru Biologi Sample 1',
            'email' => 'gurubiologi1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Guru',
            'id_card' => '00001',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'id' => 5,
            'name' => 'Guru Fisika Sample 1',
            'email' => 'gurufisika1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Guru',
            'id_card' => '00002',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'id' => 6,
            'name' => 'Guru Kimia Sample 1',
            'email' => 'gurukimia1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Guru',
            'id_card' => '00003',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'id' => 7,
            'name' => 'Guru Akuntansi Sample 1',
            'email' => 'guruakuntansi1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Guru',
            'id_card' => '00004',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'id' => 8,
            'name' => 'Guru Ekonomi Sample 1',
            'email' => 'guruekonomi1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Guru',
            'id_card' => '00005',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
