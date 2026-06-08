<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bank_soal', function (Blueprint $table) {
            $table->enum('mode', ['toeic', 'self_study'])
                  ->default('toeic')
                  ->after('sesi_bank');
        });

        DB::table('bank_soal')->update(['mode' => 'toeic']);
    }

    public function down(): void
    {
        Schema::table('bank_soal', function (Blueprint $table) {
            $table->dropColumn('mode');
        });
    }
};
