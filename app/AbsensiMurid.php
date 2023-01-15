<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsensiMurid extends Model
{
    protected $fillable = ['tanggal','jadwal_id', 'nama_kelas','mapel_id' ,'nama_siswa','kehadiran_id','tahun_ajaran','angkatan','file_name','file_path'];
        
    public function siswa()
    {
        return $this->belongsTo('App\Siswa')->withDefault();
    }

    public function kehadiran()
    {
        return $this->belongsTo('App\KehadiranSiswa')->withDefault();
    }

     public function jamkehadiran()
        {
            return "{$this->created_at->format('H:i:s')}";
        }

    protected $table = 'absensimurid';
}