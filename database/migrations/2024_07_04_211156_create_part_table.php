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
        Schema::create('part', function (Blueprint $table) {
            $table->id('id_part');
            $table->string('part', 100);
            $table->string('kategori', 100);
            $table->unsignedBigInteger('id_bank');
            $table->foreign('id_bank')->references('id_bank')->on('bank_soal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part');
    }
};
