<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom 'notified' untuk menandai apakah email sudah dikirim.
     */
    public function up(): void
    {
       // Kolom sudah ada, jadi tidak perlu ditambahkan lagi
    }

    /**
     * Hapus kolom 'notified' saat rollback.
     */
    public function down(): void
    {
       // Kolom sudah ada, jadi tidak perlu ditambahkan lagi
    }
};
