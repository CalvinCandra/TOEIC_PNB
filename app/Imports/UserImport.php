<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Status;
use App\Models\Peserta;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // validasi header
        if (!isset($row['name']) || !isset($row['email']) || !isset($row['nim']) || !isset($row['major']) || !isset($row['session'])) {
            Session::flash('gagal', 'Please Add Header with name "Name, Email, Nim, Major, Session" in File Excel');
            return null;
        }


        // Dapatkan data Peserta berdasarkan NIM
        $peserta = Peserta::where('nim', $row['nim'])->first();

        // Dapatkan data User berdasarkan email
        $user = User::where('email', $row['email'])->first();

        // Jika salah satu dari mereka ditemukan, batalkan inputan
        if ($peserta !== null || $user !== null) {
            Session::flash('gagal', 'Email or NIM already exists: ' . $row['email'] . ' / ' . $row['nim']);
            return null;
        }

        // generate password otomatis
        $password = strtoupper(Str::password(8, true, false, false, false));

        // Simpan pengguna terlebih dahulu
        $user = User::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($password),
            'level' => 'peserta'
        ]);

        // get id berdasarkan data yang baru ditambah
        $User = User::select('*')->where('email', $row['email'])->first();

        // Simpan password asli di tabel lain setelah pengguna disimpan
        Peserta::create([
            'nama_peserta' => $row['name'],
            'nim' => $row['nim'],
            'token' => $password,
            'jurusan' => $row['major'],
            'sesi' => $row['session'],
            'status' => 'Belum',
            'benar_listening' => 0,
            'benar_reading' => 0,
            'skor_listening' => 0,
            'skor_reading' => 0,
            'id_users' => $user['id'],
        ]);

        return $user;
    }
}
