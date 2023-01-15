<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensimuridTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  
    public function up()
    {
        Schema::create('absensimurid', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tanggal');
            $table->string('jadwal_id', 50);
            $table->string('nama_kelas', 50);
            $table->string('mapel_id', 50);
            $table->string('nama_siswa', 50);
            $table->integer('kehadiran_id');
            $table->string('tahun_ajaran', 50);
            $table->integer('angkatan');
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensimurid');
    }
}
