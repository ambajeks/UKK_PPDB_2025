<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('formulir_pendaftaran', function (Blueprint $table) {
            $table->enum('status_pengambilan_seragam', ['belum', 'sudah'])->default('belum')->after('verified_at');
            $table->timestamp('tanggal_pengambilan_seragam')->nullable()->after('status_pengambilan_seragam');
            $table->foreignId('admin_pengambilan_id')->nullable()->after('tanggal_pengambilan_seragam')
                  ->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formulir_pendaftaran', function (Blueprint $table) {
            $table->dropForeign(['admin_pengambilan_id']);
            $table->dropColumn(['status_pengambilan_seragam', 'tanggal_pengambilan_seragam', 'admin_pengambilan_id']);
        });
    }
};
