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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_laporan');
            $table->date('tanggal_laporan');
            $table->string('perihal');
            $table->string('instansi');
            $table->string('status_petugas')->default('Pending');
            $table->foreignId('petugas_id')->constrained('petugas');
            $table->text('hasil_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};