<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ujian extends Model
{   
    use SoftDeletes;

    protected $fillable = ['siswa_id', 'jadwal_ujian_id', 'hasil', 'is_finish'];

    public function siswa()
    {
      return $this->belongsTo('App\Siswa')->withDefault();
    }

    public function jadwalUjian()
    {
      return $this->belongsTo('App\JadwalUjian')->withDefault();
    }

    protected $table = 'ujian';
}
