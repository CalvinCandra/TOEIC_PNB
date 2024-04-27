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
        Schema::table('soal', function (Blueprint $table) {
            $table->unsignedBigInteger('id_gambar')->after('id_suara');
            $table->foreign('id_gambar')->references('id_gambar')->on('gambar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->dropForeign(['id_gambar']);
            $table->dropColumn('id_gambar');
        });
    }
};
