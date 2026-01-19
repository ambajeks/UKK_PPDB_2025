<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisiPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'revisi_pendaftaran';

    protected $fillable = [
        'formulir_id',
        'admin_id',
        'field_revisi',
        'catatan_revisi',
        'status_revisi',
        'selesai_at'
    ];

    protected $casts = [
        'field_revisi' => 'array',
        'selesai_at' => 'datetime',
    ];

    public function formulir()
    {
        return $this->belongsTo(FormulirPendaftaran::class, 'formulir_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Helper untuk cek apakah revisi sedang menunggu
    public function isMenunggu()
    {
        return $this->status_revisi === 'menunggu';
    }

    // Helper untuk cek apakah revisi sudah selesai
    public function isSelesai()
    {
        return $this->status_revisi === 'selesai';
    }
}
