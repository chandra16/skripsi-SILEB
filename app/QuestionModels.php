<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionModels extends Model
{
    use SoftDeletes;

    protected $fillable = ['tipe_ujian_id', 'mapel_id', 'nama_model_soal'];


    public function tipeUjian()
    {
        return $this->belongsTo('App\TipeUjian')->withDefault();
    }

    public function mapel()
    {
        return $this->belongsTo('App\Mapel')->withDefault();
    }

    protected $table = 'question_models';
}
