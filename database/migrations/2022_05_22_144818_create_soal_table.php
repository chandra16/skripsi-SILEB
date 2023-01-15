<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Soal', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->string('mapel');
            $table->string('kelas');
            $table->string('judul');
            $table->string('angkatan');
             $table->string('user_id_teacher', 10);
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
        Schema::dropIfExists('Soal');
    }
}
