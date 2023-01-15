<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
   protected $fillable = [
        'id', 'nama',
    ];

    protected $table = 'tahun_ajarans';
}
