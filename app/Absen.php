<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $fillable = ['guru_id', 'tanggal', 'kehadiran_id', 'attachment_file_name', 'attachment_file_path'];

    public function guru()
    {
        return $this->belongsTo('App\Guru')->withDefault();
    }

    public function kehadiran()
    {
        return $this->belongsTo('App\Kehadiran')->withDefault();
    }

    protected $table = 'absensi_guru';
}
