<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom status ke tabel cruds
     */
    public function up(): void
    {
        Schema::table('cruds', function (Blueprint $table) {
            $table->enum('status', ['pending', 'selesai'])->default('pending')->after('instansi');
        });
    }

    /**
     * Hapus kolom status jika rollback
     */
    public function down(): void
    {
        Schema::table('cruds', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
