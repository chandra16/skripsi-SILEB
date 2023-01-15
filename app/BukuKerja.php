<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BukuKerja extends Model
{
    protected $fillable = [
        'id_buku', 'nama','file_name','file_path','tahun_ajaran'
    ];

     protected $table = 'bukukerja';
}
