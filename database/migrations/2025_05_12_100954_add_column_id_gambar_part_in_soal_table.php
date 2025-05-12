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
            $table->unsignedBigInteger('id_gambar_1')->nullable()->after('id_gambar');
            $table->foreign('id_gambar_1')->references('id_gambar')->on('gambar');
            $table->unsignedBigInteger('id_gambar_2')->nullable()->after('id_gambar_1');
            $table->foreign('id_gambar_2')->references('id_gambar')->on('gambar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->dropForeign(['id_gambar_1']);
            $table->dropColumn('id_gambar_1');
            $table->dropForeign(['id_gambar_2']);
            $table->dropColumn('id_gambar_2');
        });
    }
};
