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
        Schema::create('hasils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kegiatans_id');
            $table->unsignedBigInteger('petugas_id');
            $table->text('laporan');
            $table->date('tanggal_pelaporan');
            $table->timestamps();

            $table->foreign('kegiatans_id')->references('id')->on('kegiatans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('petugas_id')->references('id')->on('petugas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasils');
    }
};
