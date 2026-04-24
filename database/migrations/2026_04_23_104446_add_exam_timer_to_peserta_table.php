<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->timestamp('listening_start_at')->nullable()->after('skor_reading');
            $table->timestamp('reading_start_at')->nullable()->after('listening_start_at');
        });
    }

    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn(['listening_start_at', 'reading_start_at']);
        });
    }
};