<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipeUjian extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'keterangan'
    ];

    /**
     * This is For CRUD
     * Mengkaitkan table materi
     *
     */
    protected $table = 'tipe_ujian';
}
