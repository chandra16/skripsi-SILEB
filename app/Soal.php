<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mapel', 'kelas', 'judul','user_id_teacher','file_name','file_path','angkatan',
    ];

    /**
     * This is For CRUD
     * Mengkaitkan table materi
     *
     */
    protected $table = 'Soal';
}