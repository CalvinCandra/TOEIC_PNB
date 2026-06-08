<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('self_study_attempts', function (Blueprint $table) {
            $table->id('id_attempt');
            $table->unsignedBigInteger('id_peserta');
            $table->unsignedBigInteger('id_bank');
            $table->unsignedBigInteger('id_part');
            $table->integer('attempt_number');
            $table->integer('jumlah_benar')->default(0);
            $table->integer('jumlah_salah')->default(0);
            $table->integer('skor')->default(0);
            $table->integer('durasi_detik')->nullable();
            $table->timestamps();

            $table->foreign('id_peserta')->references('id_peserta')->on('peserta')->cascadeOnDelete();
            $table->foreign('id_bank')->references('id_bank')->on('bank_soal')->cascadeOnDelete();
            $table->foreign('id_part')->references('id_part')->on('part')->cascadeOnDelete();
            $table->index(['id_peserta', 'id_bank', 'id_part', 'attempt_number'], 'ssa_lookup_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('self_study_attempts');
    }
};
