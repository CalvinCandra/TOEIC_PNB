<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureToggleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('feature_toggles')->insert([
            'feature_key' => 'toeic_simulation',
            'is_enabled'  => true,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
}
