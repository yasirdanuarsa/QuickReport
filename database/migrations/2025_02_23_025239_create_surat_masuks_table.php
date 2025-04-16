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
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_laporan'); //option surat atau telfon
            $table->string('no_surat', 50);
            $table->date('tanggal_surat');
            $table->string('pengirim', 100);
            $table->text('perihal');
            $table->string('file_surat', 50);
            $table->string('no_telp');
            $table->string('nama_pelapor');
            $table->string('instansi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};
