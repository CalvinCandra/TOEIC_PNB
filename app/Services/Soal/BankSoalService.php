<?php

namespace App\Services\Soal;

use App\Models\BankSoal;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BankSoalService
{
    public function getBankSoalAll($search = null)
    {
        Log::info('[BankSoalService::getBankSoalAll] Mengambil semua bank soal', ['search' => $search]);

        $query = BankSoal::latest();

        if ($search) {
            $query->where('bank', 'like', "%{$search}%")
                  ->orWhere('sesi_bank', 'like', "%{$search}%")
                  ->orWhere('mode', 'like', "%{$search}%");
        }

        return $query->paginate(15);
    }

    public function storeBankSoal(Request $request): bool
    {
        Log::info('[BankSoalService::storeBankSoal] Memulai tambah bank soal', [
            'sesi_bank' => $request->sesi_bank,
            'mode' => $request->mode ?? 'toeic',
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_akhir' => $request->waktu_akhir,
        ]);

        DB::beginTransaction();
        try {
            $finalSesi = $request->sesi_bank === '__NEW__' ? $request->new_sesi : $request->sesi_bank;

            BankSoal::create([
                'bank' => $request->bank,
                'sesi_bank' => $finalSesi,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_akhir' => $request->waktu_akhir,
                'mode' => $request->mode ?? 'toeic',
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
            $finalSesi = $request->sesi_bank === '__NEW__' ? $request->new_sesi : $request->sesi_bank;

            $updateData = [
                'bank' => $request->bank,
                'sesi_bank' => $finalSesi,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_akhir' => $request->waktu_akhir,
            ];

            if ($request->has('mode')) {
                $updateData['mode'] = $request->mode;
            }

            BankSoal::where('id_bank', $request->id_bank)->update($updateData);
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
