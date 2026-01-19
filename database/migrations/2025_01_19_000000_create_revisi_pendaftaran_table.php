<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('revisi_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulir_id')->constrained('formulir_pendaftaran')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->json('field_revisi'); // Menyimpan field mana yang perlu direvisi
            $table->text('catatan_revisi'); // Catatan umum untuk revisi
            $table->enum('status_revisi', ['menunggu', 'selesai'])->default('menunggu');
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('revisi_pendaftaran');
    }
};
