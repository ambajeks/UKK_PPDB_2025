<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurusanTable extends Migration
{
    public function up()
    {
       Schema::create('jurusan', function (Blueprint $table) {
    $table->id();
    $table->string('nama', 100);
    $table->string('kode_jurusan', 10)->unique()->nullable();
    $table->timestamps(); // ✅ tambahkan ini
});

    }

    public function down()
    {
        Schema::dropIfExists('jurusan');
    }
}
