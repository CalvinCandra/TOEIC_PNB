<?php

namespace App\Services\Staff;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PetugasAdminService
{
    public function getPetugasAll(?string $search = null)
    {
        Log::info('[PetugasAdminService::getPetugasAll] Mengambil semua petugas', [
            'search' => $search,
        ]);

        return Petugas::with('user')
            ->when($search, fn ($q) => $q
                ->where('nama_petugas', 'like', "%{$search}%")
            )->paginate(15);
    }

    public function storePetugas(Request $request): bool
    {
        Log::info('[PetugasAdminService::storePetugas] Memulai tambah petugas', [
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        DB::beginTransaction();
        try {
            $password = strtoupper(Str::password(8, true, false, false, false));

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'level' => 'petugas',
            ]);

            Petugas::create([
                'nama_petugas' => $request->name,
                'token' => $password,
                'id_users' => $user->id,
            ]);

            DB::commit();
            Log::info('[PetugasAdminService::storePetugas] Tambah petugas berhasil', [
                'id_users' => $user->id,
                'nama_petugas' => $request->nama_petugas,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[PetugasAdminService::storePetugas] Tambah petugas gagal', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function updatePetugas(Request $request): bool
    {
        Log::info('[PetugasAdminService::updatePetugas] Memulai update petugas', [
            'id_petugas' => $request->id_petugas,
        ]);

        $petugas = Petugas::find($request->id_petugas);
        $user    = $petugas?->user;

        // Validasi NIM selalu dijalankan
        $rules = [
            'name' => 'required|string|max:255',
        ];

        // Validasi unique email HANYA jika email berubah
        if ($request->email !== $user?->email) {
            $rules['email'] = 'email|unique:users,email';
        }

        $request->validate($rules, [
            'email.unique' => 'Email already exists',
        ]);

        DB::beginTransaction();
        try {
            Petugas::where('id_petugas', $request->id_petugas)->update([
                'nama_petugas' => $request->name,
            ]);
            User::where('id', $request->id_users)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            DB::commit();
            Log::info('[PetugasAdminService::updatePetugas] Update petugas berhasil', [
                'id_petugas' => $request->id_petugas,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[PetugasAdminService::updatePetugas] Update petugas gagal', [
                'id_petugas' => $request->id_petugas,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function deletePetugas(Request $request): bool
    {
        Log::info('[PetugasAdminService::deletePetugas] Memulai hapus petugas', [
            'id_petugas' => $request->id_petugas,
            'id_users' => $request->id_users,
        ]);

        DB::beginTransaction();
        try {
            \App\Models\Soal::where('id_users', $request->id_users)->update(['id_users' => null]);
            Petugas::where('id_petugas', $request->id_petugas)->delete();
            User::where('id', $request->id_users)->delete();
            DB::commit();
            Log::info('[PetugasAdminService::deletePetugas] Hapus petugas berhasil', [
                'id_petugas' => $request->id_petugas,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[PetugasAdminService::deletePetugas] Hapus petugas gagal', [
                'id_petugas' => $request->id_petugas,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }
}
