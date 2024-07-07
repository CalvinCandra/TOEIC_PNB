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
            $table->string('petunjuk', 1000)->after('part');
            $table->integer('dari_nomor')->after('petunjuk');
            $table->integer('sampai_nomor')->after('dari_nomor');
            $table->unsignedBigInteger('id_gambar')->nullable()->after('id_bank');
            $table->foreign('id_gambar')->references('id_gambar')->on('gambar');
            $table->unsignedBigInteger('id_audio')->nullable()->after('id_gambar');
            $table->foreign('id_audio')->references('id_audio')->on('audio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('part', function (Blueprint $table) {
            $table->dropColumn('petunjuk');
            $table->dropColumn('dari_nomor');
            $table->dropColumn('sampai_nomor');
            $table->dropForeign(['id_gambar']);
            $table->dropColumn('id_gambar');
            $table->dropForeign(['id_audio']);
            $table->dropColumn('id_audio');
        });
    }
};
