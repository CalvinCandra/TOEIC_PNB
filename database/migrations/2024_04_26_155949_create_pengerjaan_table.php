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
        Schema::create('pengerjaan', function (Blueprint $table) {
            $table->id('id_pengerjaan');
            $table->string('nilai', 100);
            $table->unsignedBigInteger('id_peserta');
            $table->foreign('id_peserta')->references('id_peserta')->on('peserta');
            $table->unsignedBigInteger('id_soal');
            $table->foreign('id_soal')->references('id_soal')->on('soal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengerjaan');
    }
};
