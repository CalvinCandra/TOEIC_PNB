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
        Schema::create('soal', function (Blueprint $table) {
            $table->id('id_soal');
            $table->string('soal', 255);
            $table->string('jawaban_a', 255);
            $table->string('jawaban_b', 255);
            $table->string('jawaban_c', 255);
            $table->string('jawaban_d', 255);
            $table->char('kunci_jawaban', 4);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal');
    }
};
