<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
     protected $table = 'kelas';
    protected $fillable = ['jurusan_id','nama_kelas','tipe_kelas','kapasitas','tahun_ajaran'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function siswa()
    {
        return $this->hasMany(FormulirPendaftaran::class, 'kelas_id');
    }
}
