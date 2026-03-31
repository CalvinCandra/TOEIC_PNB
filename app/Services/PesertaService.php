<?php

namespace App\Services;

use App\Exports\PesertaExport;
use App\Imports\UserImport;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'id_users' => $request->id_users,
        ]);

        $request->validate([
            'nim' => 'min:10|max:10',
            'email' => 'email|unique:users,email,'.$request->id_users,
        ], [
            'nim.max' => 'NIM Must be 10 Numbers',
            'nim.min' => 'NIM Must be 10 Numbers',
        ]);

        DB::beginTransaction();
        try {
            Peserta::where('id_peserta', $request->id_peserta)->update([
                'nama_peserta' => $request->nama_peserta,
                'nim' => $request->nim,
                'sesi' => $request->sesi,
            ]);
            User::where('id', $request->id_users)->update([
                'name' => $request->nama_peserta,
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
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
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

    public function resetStatusPeserta(int $id_peserta): bool
    {
        Log::info('[PesertaService::resetStatusPeserta] Reset status peserta', [
            'id_peserta' => $id_peserta,
        ]);

        $result = (bool) Peserta::where('id_peserta', $id_peserta)
            ->update(['status' => 'Belum']);

        if (! $result) {
            Log::warning('[PesertaService::resetStatusPeserta] Peserta tidak ditemukan atau gagal direset', [
                'id_peserta' => $id_peserta,
            ]);
        }

        return $result;
    }

    public function exportExcel(string $sesi)
    {
        Log::info('[PesertaService::exportExcel] Export Excel peserta', [
            'sesi' => $sesi,
        ]);

        return Excel::download(new PesertaExport($sesi), 'Data_Peserta_'.$sesi.'.xlsx');
    }
}
