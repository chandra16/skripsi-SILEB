<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class KehadiranSiswa extends Model
{
    protected $fillable = ['ket', 'color'];

    protected $table = 'kehadiransiswa';
}
