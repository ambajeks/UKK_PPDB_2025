<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'formulir_pendaftaran';

    protected $fillable = [
        'user_id',
        'nomor_pendaftaran',
        'nama_lengkap',
        'jenis_kelamin',
        'nisn',
        'asal_sekolah',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'nik',
        'anak_ke',
        'alamat',
        'desa',
        'kelurahan',
        'kecamatan',
        'kota',
        'no_hp',
        'jurusan_id',
        'gelombang_id'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function gelombang()
    {
        return $this->belongsTo(GelombangPendaftaran::class, 'gelombang_id');
    }

    // PERBAIKI RELASI DOKUMEN
    public function dokumen()
    {
        return $this->hasMany(DokumenPendaftaran::class, 'formulir_id');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'formulir_id');
    }

    public function wali()
    {
        return $this->hasOne(Wali::class, 'formulir_id');
    }
}