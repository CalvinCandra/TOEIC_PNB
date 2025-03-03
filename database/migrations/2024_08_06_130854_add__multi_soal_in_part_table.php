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
        Schema::table('part', function (Blueprint $table) {
            $table->string('multi_soal', 1000)->nullable()->after('petunjuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('part', function (Blueprint $table) {
            $table->dropColumn('multi_soal');
        });
    }
};
