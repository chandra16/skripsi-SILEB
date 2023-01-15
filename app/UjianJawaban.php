<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UjianJawaban extends Model
{
    use SoftDeletes;

    protected $fillable = ['ujian_id', 'siswa_id', 'question_id', 'question_option_id', 'essay', 'mark', 'feedback'];

    public function ujian()
    {
      return $this->belongsTo('App\Ujian')->withDefault();
    }

    public function siswa()
    {
      return $this->belongsTo('App\Siswa')->withDefault();
    }

    public function question()
    {
      return $this->belongsTo('App\Question')->withDefault();
    }

    public function questionOption()
    {
      return $this->belongsTo('App\QuestionOption')->withDefault();
    }
    
    protected $table = 'ujian_jawaban';
}
