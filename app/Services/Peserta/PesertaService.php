<?php

namespace App\Services\Peserta;

use App\Exports\PesertaExport;
use App\Imports\UserImport;
use App\Models\Peserta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class PesertaService
{
    public function getPesertaAll(?string $search = null)
    {
        Log::info('[PesertaService::getPesertaAll] Mengambil semua peserta', [
            'search' => $search,
        ]);

        return Peserta::with('user')
            ->when($search, fn ($q) => $q
                ->where('nama_peserta', 'like', "%{$search}%")
                ->orWhere('nim', 'like', "%{$search}%")
                ->orWhere('jurusan', 'like', "%{$search}%")
            )->paginate(15);
    }

    public function getPesertaBySesi(string $sesi, ?string $search = null)
    {
        Log::info('[PesertaService::getPesertaBySesi] Mengambil peserta by sesi', [
            'sesi' => $sesi,
            'search' => $search,
        ]);

        return Peserta::with('user')
            ->where('sesi', $sesi)
            ->when($search, fn ($q) => $q
                ->where('nama_peserta', 'like', "%{$search}%")
            )->paginate(15);
    }

    public function importPesertaExcel(Request $request): bool
    {
        Log::info('[PesertaService::importPesertaExcel] Memulai import Excel');

        try {
            Excel::import(new UserImport, $request->file('file'));
            Log::info('[PesertaService::importPesertaExcel] Import Excel berhasil');

            return true;
        } catch (\Throwable $th) {
            Log::error('[PesertaService::importPesertaExcel] Import Excel gagal', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    

    public function updatePeserta(Request $request): bool
    {
        Log::info('[PesertaService::updatePeserta] Memulai update peserta', [
            'id_peserta' => $request->id_peserta,
        ]);

        $peserta = Peserta::find($request->id_peserta);
        $user    = $peserta?->user;

        // Validasi NIM selalu dijalankan
        $rules = [
            'nim' => 'min:10|max:10',
        ];

        // Validasi unique email HANYA jika email berubah
        if ($request->email !== $user?->email) {
            $rules['email'] = 'email|unique:users,email';
        }

        $request->validate($rules, [
            'nim.max'      => 'NIM Must be 10 Numbers',
            'nim.min'      => 'NIM Must be 10 Numbers',
            'email.unique' => 'Email already exists',
        ]);

        DB::beginTransaction();
        try {
            Peserta::where('id_peserta', $request->id_peserta)->update([
                'nama_peserta' => $request->name,
                'nim'          => $request->nim,
                'sesi'         => $request->sesi,
                'status'       => $request->status,
            ]);

            User::where('id', $user->id)->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            DB::commit();

            Log::info('[PesertaService::updatePeserta] Update peserta berhasil', [
                'id_peserta' => $request->id_peserta,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('[PesertaService::updatePeserta] Update peserta gagal', [
                'id_peserta' => $request->id_peserta,
                'error'      => $th->getMessage(),
                'file'       => $th->getFile(),
                'line'       => $th->getLine(),
            ]);

            return false;
        }
    }

    public function deletePeserta(Request $request): bool
    {
        Log::info('[PesertaService::deletePeserta] Memulai hapus peserta', [
            'id_peserta' => $request->id_peserta,
            'id_users' => $request->id_users,
        ]);

        DB::beginTransaction();
        try {
            Peserta::where('id_peserta', $request->id_peserta)->delete();
            User::where('id', $request->id_users)->delete();
            DB::commit();
            Log::info('[PesertaService::deletePeserta] Hapus peserta berhasil', [
                'id_peserta' => $request->id_peserta,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[PesertaService::deletePeserta] Hapus peserta gagal', [
                'id_peserta' => $request->id_peserta,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function resetAllStatusPeserta(string $sesi) {
        Peserta::where('sesi', $sesi)->update(['status' => 'Belum', 'listening_start_at' => null, 'reading_start_at' => null]);
    }

    public function exportExcel(string $sesi)
    {
        Log::info('[PesertaService::exportExcel] Export Excel peserta', [
            'sesi' => $sesi,
        ]);

        return Excel::download(new PesertaExport($sesi), 'Data_Peserta_'.$sesi.'.xlsx');
    }

    public function resetPasswordPeserta($id_peserta) {
        $user = Peserta::findOrFail($id_peserta);

        $format_tgl = Carbon::parse($user->tanggal_lahir)->format('dmY');

        User::where('id', $user->id_users)->update([
            'password' => Hash::make($format_tgl),
            'is_password_changed' => false,
        ]);

        return true;
    }
}
