<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mapel', 'kelas', 'judul', 'isi', 'kesimpulan', 'keterangan', 'user_id_teacher','file_name','file_path','angkatan',
    ];

    /**
     * This is For CRUD
     * Mengkaitkan table materi
     *
     */
    protected $table = 'materi';
}
