<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orang_tua', function (Blueprint $table) {
            // Cek dulu kolom yang ada
            if (!Schema::hasColumn('orang_tua', 'formulir_id')) {
                // Jika formulir_id tidak ada, tambahkan dulu
                $table->foreignId('formulir_id')->nullable()->constrained('formulir_pendaftaran')->onDelete('cascade')->after('id');
            }
            
            // Hapus unique constraint dari formulir_id jika ada
            if (Schema::hasIndex('orang_tua', 'orang_tua_formulir_id_unique')) {
                $table->dropUnique('orang_tua_formulir_id_unique');
            }
            
            // Tambah kolom jenis_orangtua - letakkan setelah id jika formulir_id tidak ada
            if (Schema::hasColumn('orang_tua', 'formulir_id')) {
                $table->enum('jenis_orangtua', ['ayah', 'ibu'])->default('ayah')->after('formulir_id');
            } else {
                $table->enum('jenis_orangtua', ['ayah', 'ibu'])->default('ayah')->after('id');
            }
            
            // Buat composite unique key
            $table->unique(['formulir_id', 'jenis_orangtua']);
        });
    }

    public function down()
    {
        Schema::table('orang_tua', function (Blueprint $table) {
            // Hapus composite unique key
            $table->dropUnique(['formulir_id', 'jenis_orangtua']);
            
            // Hapus kolom jenis_orangtua
            $table->dropColumn('jenis_orangtua');
            
            // Tidak perlu restore unique constraint karena kita mau multiple records
        });
    }
};