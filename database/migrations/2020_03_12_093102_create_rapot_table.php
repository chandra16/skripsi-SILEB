<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapot', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('siswa_id',50);
            $table->string('kelas_id',50);
            $table->string('guru_id',50);
            $table->string('mapel_id',50);
            $table->string('p_nilai', 5);
            $table->string('p_predikat', 5);
            $table->text('p_deskripsi');
            $table->string('k_nilai', 5)->nullable();
            $table->string('k_predikat', 5)->nullable();
            $table->text('k_deskripsi')->nullable();
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
        Schema::dropIfExists('rapot');
    }
}
