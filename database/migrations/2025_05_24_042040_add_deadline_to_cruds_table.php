<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     public function up(): void
    {
        Schema::table('cruds', function (Blueprint $table) {
            $table->date('deadline')->nullable()->after('status');
            $table->boolean('notified')->default(false)->after('deadline'); // Flag notifikasi terkirim
        });

        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crud_id')->constrained('cruds')->onDelete('cascade');
            $table->string('status');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('cruds', function (Blueprint $table) {
            $table->dropColumn(['deadline', 'notified']);
        });
        Schema::dropIfExists('notification_logs');
    }
};
