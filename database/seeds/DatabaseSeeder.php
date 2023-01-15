<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(HariSeeder::class);
        $this->call(KehadiranSeeder::class);
        $this->call(PaketSeeder::class);
        $this->call(RuangSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(KehadiranSiswaSeeder::class);
        $this->call(MapelSeeder::class);
        $this->call(GuruSeeder::class);
        $this->call(TahunAjaranSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(SiswaSeeder::class);
        $this->call(TipeUjianSeeder::class);
    }
}
