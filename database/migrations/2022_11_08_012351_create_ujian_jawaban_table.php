<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjianJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian_jawaban', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ujian_id');
            $table->integer('siswa_id');
            $table->integer('question_id');
            $table->integer('question_option_id')->nullable();
            $table->text('essay')->nullable();
            $table->float('mark')->nullable();
            $table->text('feedback')->nullable();
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
        Schema::dropIfExists('ujian_jawaban');
    }
}
