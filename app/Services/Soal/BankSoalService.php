<?php

namespace App\Services\Soal;

use App\Models\BankSoal;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BankSoalService
{
    public function getBankSoalAll()
    {
        Log::info('[BankSoalService::getBankSoalAll] Mengambil semua bank soal');

        return BankSoal::latest()->paginate(15);
    }

    public function storeBankSoal(Request $request): bool
    {
        Log::info('[BankSoalService::storeBankSoal] Memulai tambah bank soal', [
            'sesi_bank' => $request->sesi_bank,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_akhir' => $request->waktu_akhir,
        ]);

        DB::beginTransaction();
        try {
            BankSoal::create([
                'bank' => $request->bank,
                'sesi_bank' => $request->sesi_bank,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_akhir' => $request->waktu_akhir,
            ]);
            DB::commit();
            Log::info('[BankSoalService::storeBankSoal] Tambah bank soal berhasil', [
                'sesi_bank' => $request->sesi_bank,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[BankSoalService::storeBankSoal] Tambah bank soal gagal', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function updateBankSoal(Request $request): bool
    {
        Log::info('[BankSoalService::updateBankSoal] Memulai update bank soal', [
            'id_bank' => $request->id_bank,
        ]);

        DB::beginTransaction();
        try {
            BankSoal::where('id_bank', $request->id_bank)->update([
                'bank' => $request->bank,
                'sesi_bank' => $request->sesi_bank,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_akhir' => $request->waktu_akhir,
            ]);
            DB::commit();
            Log::info('[BankSoalService::updateBankSoal] Update bank soal berhasil', [
                'id_bank' => $request->id_bank,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[BankSoalService::updateBankSoal] Update bank soal gagal', [
                'id_bank' => $request->id_bank,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function deleteBankSoal(int $id_bank): bool
    {
        Log::info('[BankSoalService::deleteBankSoal] Memulai hapus bank soal beserta data terkait', [
            'id_bank' => $id_bank,
        ]);

        DB::beginTransaction();
        try {
            $deletedSoal = \App\Models\Soal::where('id_bank', $id_bank)->count();
            $deletedPart = Part::where('id_bank', $id_bank)->count();

            \App\Models\Soal::where('id_bank', $id_bank)->delete();
            Part::where('id_bank', $id_bank)->delete();
            BankSoal::where('id_bank', $id_bank)->delete();

            DB::commit();
            Log::info('[BankSoalService::deleteBankSoal] Hapus bank soal berhasil', [
                'id_bank' => $id_bank,
                'soal_dihapus' => $deletedSoal,
                'part_dihapus' => $deletedPart,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[BankSoalService::deleteBankSoal] Hapus bank soal gagal', [
                'id_bank' => $id_bank,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }
}
