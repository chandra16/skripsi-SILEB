<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('guru')->insert([
            'id' => 1,
            'id_card' => '00001',
            'nip' => '1000000000',
            'nama_guru' => 'Guru Biologi Sample 1',
            'mapel_id' => 1,
            'kode' => '001',
            'jk' => 'L',
            'telp' => '082208220822',
            'tmp_lahir' => 'Jakarta',
            'tgl_lahir' => '2022-10-30',
            'foto' => 'uploads/guru/54222230102022_pain_rinnegan.jpg',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('guru')->insert([
            'id' => 2,
            'id_card' => '00002',
            'nip' => '1000000001',
            'nama_guru' => 'Guru Fisika Sample 1',
            'mapel_id' => 2,
            'kode' => '002',
            'jk' => 'P',
            'telp' => '082208220823',
            'tmp_lahir' => 'Jakarta',
            'tgl_lahir' => '2021-10-30',
            'foto' => 'uploads/guru/54222230102022_pain_rinnegan.jpg',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('guru')->insert([
            'id' => 3,
            'id_card' => '00003',
            'nip' => '1000000002',
            'nama_guru' => 'Guru Kimia Sample 1',
            'mapel_id' => 3,
            'kode' => '003',
            'jk' => 'P',
            'telp' => '082208220824',
            'tmp_lahir' => 'Jakarta',
            'tgl_lahir' => '2020-10-30',
            'foto' => 'uploads/guru/54222230102022_pain_rinnegan.jpg',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('guru')->insert([
            'id' => 4,
            'id_card' => '00004',
            'nip' => '1000000003',
            'nama_guru' => 'Guru Akuntansi Sample 1',
            'mapel_id' => 4,
            'kode' => '004',
            'jk' => 'L',
            'telp' => '082208220825',
            'tmp_lahir' => 'Jakarta',
            'tgl_lahir' => '2019-10-30',
            'foto' => 'uploads/guru/54222230102022_pain_rinnegan.jpg',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('guru')->insert([
            'id' => 5,
            'id_card' => '00005',
            'nip' => '1000000004',
            'nama_guru' => 'Guru Ekonomi Sample 1',
            'mapel_id' => 5,
            'kode' => '005',
            'jk' => 'L',
            'telp' => '082208220826',
            'tmp_lahir' => 'Jakarta',
            'tgl_lahir' => '2018-10-30',
            'foto' => 'uploads/guru/54222230102022_pain_rinnegan.jpg',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
