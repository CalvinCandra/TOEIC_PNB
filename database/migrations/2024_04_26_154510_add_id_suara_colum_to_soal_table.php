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
            $table->unsignedBigInteger('id_suara')->after('kunci_jawaban');
            $table->foreign('id_suara')->references('id_suara')->on('suara');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->dropForeign(['id_suara']);
            $table->dropColumn('id_suara');
        });
    }
};
