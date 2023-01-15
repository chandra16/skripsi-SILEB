<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('siswa_id',50);
            $table->string('kelas_id',50);
            $table->string('guru_id',50);
            $table->string('mapel_id',50);
            $table->string('ulha_1', 5)->nullable();
            $table->string('ulha_2', 5)->nullable();
            $table->string('uts', 5)->nullable();
            $table->string('ulha_3', 5)->nullable();
            $table->string('uas', 5)->nullable();
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
        Schema::dropIfExists('ulangan');
    }
}
