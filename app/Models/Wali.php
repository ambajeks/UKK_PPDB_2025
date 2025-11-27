<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wali extends Model
{
    protected $fillable = ['formulir_id','nama_wali','alamat_wali','no_hp_wali'];
       public function formulir()
    { 
        return $this->belongsTo(FormulirPendaftaran::class, 'formulir_id'); 
    }
}
