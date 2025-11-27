<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $table = 'orang_tua';
    protected $fillable = [
        'formulir_id','jenis_orangtua',
        'nama_ayah','tanggal_lahir_ayah','pekerjaan_ayah','penghasilan_ayah','alamat_ayah','no_hp_ayah','nik_ayah',
        'nama_ibu','tanggal_lahir_ibu','pekerjaan_ibu','penghasilan_ibu','alamat_ibu','no_hp_ibu','nik_ibu'
    ];

    public function formulir()
    { 
        return $this->belongsTo(FormulirPendaftaran::class, 'formulir_id'); 
    }
}
