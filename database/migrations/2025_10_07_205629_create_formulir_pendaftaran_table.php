<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulirPendaftaranTable extends Migration
{
    public function up()
    {
        Schema::create('formulir_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
              $table->foreignId('jurusan_id')->nullable();
            $table->string('nomor_pendaftaran', 20)->unique()->nullable();
            $table->string('nama_lengkap', 100)->nullable();
            $table->string('jenis_kelamin', 100)->nullable();
            $table->string('nisn', 20)->unique()->nullable();
            $table->string('asal_sekolah', 100)->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->nullable();
            $table->string('nik', 20)->unique()->nullable();
            $table->integer('anak_ke')->nullable();
            $table->text('alamat')->nullable();
            $table->string('desa', 50)->nullable();
            $table->string('kelurahan', 50)->nullable();
            $table->string('kecamatan', 50)->nullable();
            $table->string('kota', 50)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->foreignId('gelombang_id')->constrained('gelombang_pendaftaran')->onDelete('cascade');
            $table->timestamps();
         
        });
    }

    public function down()
    {
        Schema::dropIfExists('formulir_pendaftaran');
    }
}
