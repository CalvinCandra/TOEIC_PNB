<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Peserta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ChartPreviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $majors = ['Teknologi Informasi', 'Teknik Elektro', 'Teknik Mesin', 'Akuntansi'];
        $sessions = ['Session 1', 'Session 2', 'Session 3'];
        $statuses = ['Sudah', 'Kerjain', 'Belum'];

        // We will create 150 peserta in total.
        for ($i = 0; $i < 150; $i++) {
            $nim = '20' . $faker->randomNumber(8, true);
            $nama = $faker->name;
            $jurusan = $majors[array_rand($majors)];
            $sesi = $sessions[array_rand($sessions)];
            $status = $statuses[array_rand($statuses)];

            // Create User first
            $user = User::create([
                'name' => $nama,
                'email' => $nim, // usually email is nim in this context
                'password' => Hash::make('password'),
                'level' => 'Peserta',
                'is_password_changed' => false,
            ]);

            // Create Peserta
            $skor_listening = 0;
            $skor_reading = 0;
            if ($status === 'Sudah') {
                // random score between 100 and 495
                $skor_listening = $faker->numberBetween(100, 495);
                $skor_reading = $faker->numberBetween(100, 495);
            }

            Peserta::create([
                'nama_peserta' => $nama,
                'nim' => $nim,
                'tanggal_lahir' => $faker->date('Y-m-d', '2005-01-01'),
                'jurusan' => $jurusan,
                'sesi' => $sesi,
                'status' => $status,
                'skor_listening' => $skor_listening,
                'skor_reading' => $skor_reading,
                'benar_listening' => $status === 'Sudah' ? $faker->numberBetween(10, 100) : 0,
                'benar_reading' => $status === 'Sudah' ? $faker->numberBetween(10, 100) : 0,
                'id_users' => $user->id,
            ]);
        }
    }
}
