<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalujianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwalujian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tipe_ujian_id');
            $table->integer('mapel_id');
            $table->integer('guru_id');
            $table->integer('ruang_id');
            $table->integer('question_model_id')->nullable();
            $table->string('tahun_ajaran', 50);
            $table->string('nama_kelas', 50);
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwalujian');
    }
}
