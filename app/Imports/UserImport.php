<?php

namespace App\Imports;

use App\Models\Peserta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;   

class UserImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Ambil hanya kolom yang dibutuhkan, buang kolom kosong/angka dari header
        $row = array_intersect_key($row, array_flip(['name', 'email', 'nim', 'birthdate','major', 'session']));
        $row = array_change_key_case($row, CASE_LOWER);

        // Jika semua value kosong atau null, abaikan baris ini tanpa log dan tanpa flash
        $values = array_filter(array_map(fn ($v) => trim((string) $v), $row));
        if (empty($values)) {
            return null;
        }

        // 1. Validasi header Excel — hanya dijalankan jika baris tidak kosong
        $requiredKeys = ['name', 'email', 'nim', 'birthdate', 'major', 'session'];
        foreach ($requiredKeys as $key) {
            if (! isset($row[$key]) || trim((string) $row[$key]) === '') {
                Log::warning('[UserImport::model] Header Excel tidak lengkap atau nilai kosong', [
                    'keys_ditemukan' => array_keys($row),
                    'key_bermasalah' => $key,
                ]);
                Session::flash('gagal', 'Please Add Header with name "Name, Email, Nim, Major, Session" in File Excel');

                return null;
            }
        }

        // 2. Cek duplikasi NIM dan Email secara bersamaan dalam satu query
        $nimSudahAda = Peserta::where('nim', $row['nim'])->exists();
        $emailSudahAda = User::where('email', $row['email'])->exists();

        if ($nimSudahAda || $emailSudahAda) {
            Log::warning('[UserImport::model] Data duplikat, baris dilewati', [
                'email' => $row['email'],
                'nim' => $row['nim'],
                'duplikat_email' => $emailSudahAda,
                'duplikat_nim' => $nimSudahAda,
            ]);
            Session::flash('gagal', 'Email or NIM already exists: '.$row['email'].' / '.$row['nim']);

            return null;
        }

        // Cek dan konversi format tanggal lahir
        $rawDate = $row['birthdate'];
        
        try {
            if (is_numeric($rawDate)) {
                // Jika Excel membacanya sebagai Angka Serial (contoh: 36840)
                $carbonDate = Carbon::instance(Date::excelToDateTimeObject($rawDate));
            } else {
                // Jika Excel membacanya sebagai String (contoh: "10/11/2000" atau "10-11-2000")
                // Mengubah slash ke dash membantu Carbon membaca format hari-bulan-tahun dengan akurat
                $carbonDate = Carbon::parse(str_replace('/', '-', $rawDate));
            }

            // atur tanggal lahir jadi password default (contoh output: "10112000")
            $passwordDefault = $carbonDate->format('dmY');
            
            // atur format agar masuk ke database (contoh output: "2000-11-10")
            $formatDate = $carbonDate->format('Y-m-d');

        } catch (\Exception $e) {
            // Jika ada format tanggal yang benar-benar hancur, catat ke log dan gagalkan baris ini
            Log::error('[UserImport::model] Format tanggal lahir tidak valid', [
                'email' => $row['email'],
                'birthdate_input' => $rawDate,
                'error' => $e->getMessage()
            ]);
            Session::flash('gagal', 'Format birthdate salah pada user: '.$row['email']);
            
            return null;
        }

        // 3. Simpan dalam transaction agar atomic — jika salah satu gagal, keduanya dibatalkan
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => Hash::make($passwordDefault),
                'level' => 'peserta',
            ]);

            Peserta::create([
                'nama_peserta' => $row['name'],
                'nim' => $row['nim'],
                'tanggal_lahir' => $formatDate,
                'jurusan' => $row['major'],
                'sesi' => $row['session'],
                'status' => 'Belum',
                'benar_listening' => 0,
                'benar_reading' => 0,
                'skor_listening' => 0,
                'skor_reading' => 0,
                'id_users' => $user->id, // langsung dari instance, tidak perlu query ulang
            ]);

            DB::commit();

            Log::info('[UserImport::model] Peserta berhasil diimport', [
                'email' => $row['email'],
                'nim' => $row['nim'],
                'session' => $row['session'],
            ]);

            return $user;

        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('[UserImport::model] Gagal import baris, transaction di-rollback', [
                'email' => $row['email'],
                'nim' => $row['nim'],
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            Session::flash('gagal', 'Gagal import data: '.$row['email']);

            return null;
        }
    }
}
