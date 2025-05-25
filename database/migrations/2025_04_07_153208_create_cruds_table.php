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
        Schema::create('cruds', function (Blueprint $table) {
            $table->id();
            $table->string('report_type'); // 'surat_masuk' or 'telepon'
            $table->string('surat_masuk_path')->nullable(); // For file path
            $table->string('nomor_telepon')->nullable();
            $table->string('activity'); // New activity column
            $table->date('tanggal_laporan');
            $table->date('deadline')->nullable();
            $table->string('perihal');
            $table->string('instansi');
            $table->foreignId('users_id')->constrained('users'); // bukan 'petugas'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cruds', function (Blueprint $table) {
            $table->dropColumn([
                'excel_export_path',
                'officer_status', 
                'workflow_stage',
                'report_source'
            ]);
        });
    }
};
