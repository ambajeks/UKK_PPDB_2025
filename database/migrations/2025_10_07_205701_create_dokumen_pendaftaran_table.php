<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumen_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulir_id')->constrained('formulir_pendaftaran')->onDelete('cascade');
            $table->enum('jenis_dokumen', [
                'kartu_keluarga',
                'akta_kelahiran', 
                'foto_3x4',
                'surat_keterangan_lulus',
                'ijazah_sd',
                'ktp_orang_tua'
            ]);
            $table->string('nama_file');
            $table->string('path_file');
            $table->string('original_name');
            $table->string('extension', 10);
            $table->decimal('size', 10, 2);
            $table->string('mime_type');
            $table->timestamps();

            $table->unique(['formulir_id', 'jenis_dokumen']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_pendaftaran');
    }
};