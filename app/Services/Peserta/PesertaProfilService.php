<?php

namespace App\Services\Peserta;

use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PesertaProfilService
{
    public function getPeserta(int $userId): ?Peserta
    {
        return Peserta::with('user')->where('id_users', $userId)->first();
    }

    public function updateProfil(Request $request, int $userId): bool|string
    {
        $request->validate([
            'nim' => 'min:10|max:10',
        ], [
            'nim.max' => 'NIM Must be 10 Numbers',
            'nim.min' => 'NIM Must be 10 Numbers',
        ]);

        $peserta = Peserta::where('id_users', $userId)->first();

        if ($request->nim !== $peserta->nim) {
            if (Peserta::where('nim', $request->nim)->exists()) {
                return 'Nim already exists';
            }
        }

        DB::beginTransaction();
        try {
            User::where('id', $userId)->update([
                'name' => $request->name,
            ]);

            Peserta::where('id_users', $userId)->update([
                'nama_peserta' => $request->name,
                'nim' => $request->nim,
                'jurusan' => $request->jurusan,
            ]);

            DB::commit();
            Log::info('[PesertaProfilService::updateProfil] Update profil berhasil', [
                'id_users' => $userId,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[PesertaProfilService::updateProfil] Update profil gagal', [
                'id_users' => $userId,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function downloadResult(int $userId): array|null
    {
        $peserta = Peserta::with('user')->where('id_users', $userId)->first();

        if (! $peserta) {
            Log::warning('[PesertaProfilService::downloadResult] Peserta tidak ditemukan', [
                'id_users' => $userId,
            ]);

            return ['status' => 'not_found'];
        }

        return match ($peserta->pdf_status) {

            'pending' => [
                'status'  => 'pending',
                'message' => 'Your result has not been processed yet. Please wait a moment.',
            ],

            'processing' => [
                'status'  => 'processing',
                'message' => 'Your result is currently being calculated. Please wait a moment and try again.',
            ],

            'done' => $this->streamPdf($peserta),

            'failed' => [
                'status'  => 'failed',
                'message' => 'Your result PDF could not be generated. Please contact the exam committee.',
            ],

            default => [
                'status'  => 'unknown',
                'message' => 'An unexpected error occurred. Please contact the exam committee.',
            ],
        };
    }

    private function streamPdf(Peserta $peserta): array
    {
        $path = $peserta->pdf_path;

        if (! Storage::disk('s3')->exists($path)) {
            Log::error('[PesertaProfilService::downloadResult] File PDF tidak ditemukan di S3', [
                'nim'  => $peserta->nim,
                'sesi' => $peserta->sesi,
                'path' => $path,
            ]);

            return [
                'status'  => 'file_missing',
                'message' => 'Your result PDF file was not found. Please contact the exam committee.',
            ];
        }

        Log::info('[PesertaProfilService::downloadResult] Download PDF berhasil', [
            'nim'  => $peserta->nim,
            'sesi' => $peserta->sesi,
            'path' => $path,
        ]);

        return [
            'status'   => 'done',
            'download' => redirect(Storage::disk('s3')->url($path)),
        ];
    }

    public function resetPassword(Request $request, int $userId): bool|string
    {
        // 1. Validasi disesuaikan dengan atribut "name" di form HTML
        $request->validate([
            'password_old' => 'required',
            'password_new' => 'required|min:8|same:password_confirmation',
        ], [
            // (Opsional) Custom pesan error jika password tidak sama
            'password_new.same' => 'The password confirmation does not match.'
        ]);

        $user = User::find($userId);

        if (! $user) {
            Log::warning('[PesertaProfilService::resetPassword] User tidak ditemukan', [
                'id_users' => $userId,
            ]);

            return 'User not found';
        }

        // 2. Gunakan Hash::check bawaan Laravel sebagai best practice
        if (! Hash::check($request->password_old, $user->password)) {
            Log::warning('[PesertaProfilService::resetPassword] Password lama salah', [
                'id_users' => $userId,
            ]);

            // Kembalikan string yang spesifik untuk ditampilkan ke user
            return 'Old password is incorrect';
        }

        try {
            // 3. Gunakan Hash::make
            $user->password = Hash::make($request->password_new);
            $user->is_password_changed = true;
            $user->save();

            Log::info('[PesertaProfilService::resetPassword] Password reset berhasil', [
                'id_users' => $userId,
            ]);

            return true;
        } catch (\Throwable $th) {
            Log::error('[PesertaProfilService::resetPassword] Password reset gagal', [
                'id_users' => $userId,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }
}
