<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pendaftaran';

    protected $fillable = [
        'formulir_id',
        'jenis_dokumen',
        'nama_file',
        'path_file',
        'original_name',
        'extension',
        'size',
        'mime_type'
    ];

    protected $casts = [
        'size' => 'decimal:2'
    ];

    // Relasi ke FormulirPendaftaran
    public function formulir()
    {
        return $this->belongsTo(FormulirPendaftaran::class, 'formulir_id');
    }

    // Helper methods
    public function getJenisDokumenTextAttribute()
    {
        $jenis = [
            'kartu_keluarga' => 'Kartu Keluarga',
            'akta_kelahiran' => 'Akta Kelahiran',
            'foto' => 'Foto',
            'foto_3x4' => 'Foto 3x4',
            'surat_keterangan_lulus' => 'Surat Keterangan Lulus',
            'ijazah_sd' => 'Ijazah SD',
            'ktp_orang_tua' => 'KTP Ayah dan Ibu atau Wali'
        ];

        return $jenis[$this->jenis_dokumen] ?? $this->jenis_dokumen;
    }

    public function isImage()
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        return in_array(strtolower($this->extension), $imageExtensions);
    }

    public function getFilePath()
    {
        return storage_path('app/' . $this->path_file);
    }
}
