<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom hasil dan bukti ke tabel cruds
     */
    public function up(): void
    {
        Schema::table('cruds', function (Blueprint $table) {
            $table->text('hasil')->nullable()->after('instansi');
            $table->string('bukti')->nullable()->after('hasil');
        });
    }

    /**
     * Menghapus kolom hasil dan bukti jika rollback
     */
    public function down(): void
    {
        Schema::table('cruds', function (Blueprint $table) {
            $table->dropColumn(['hasil', 'bukti']);
        });
    }
};
