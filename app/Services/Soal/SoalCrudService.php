<?php

namespace App\Services\Soal;

use App\Models\Audio;
use App\Models\Gambar;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SoalCrudService
{
    // =========================================================
    // LISTENING
    // =========================================================

    public function getDashListening(int $id_bank, ?string $search = null): array
    {
        Log::info('[SoalCrudService::getDashListening] Mengambil data soal listening', [
            'id_bank' => $id_bank,
            'search' => $search,
        ]);

        $soal = Soal::with(['user', 'audio', 'gambar'])
            ->where('id_bank', $id_bank)
            ->where('kategori', 'Listening')
            ->when($search, fn ($q) => $q
                ->orWhere('nomor_soal', 'LIKE', '%'.$search.'%')
                ->orWhere('soal', 'LIKE', '%'.$search.'%')
            )
            ->orderBy('nomor_soal', 'asc')
            ->paginate(15);

        $audio = Audio::all();
        $gambar = Gambar::all();

        // Auto-increment nomor soal — dari Listening saja
        $penomoran = Soal::where('id_bank', $id_bank)
            ->where('kategori', 'Listening')
            ->orderBy('nomor_soal', 'desc')
            ->first();
        $nomor = $penomoran ? intval($penomoran->nomor_soal) + 1 : 1;

        return compact('soal', 'audio', 'gambar', 'nomor');
    }

    public function storeListening(Request $request): bool
    {
        Log::info('[SoalCrudService::storeListening] Memulai tambah soal listening', [
            'nomor_soal' => $request->nomor_soal,
            'id_bank' => $request->id_bank,
            'id_users' => auth()->id(),
        ]);

        DB::beginTransaction();
        try {
            Soal::create([
                'nomor_soal' => $request->nomor_soal,
                'text' => null,
                'soal' => $request->soal,
                'jawaban_a' => $request->jawaban_a,
                'jawaban_b' => $request->jawaban_b,
                'jawaban_c' => $request->jawaban_c,
                'jawaban_d' => $request->jawaban_d,
                'kunci_jawaban' => strtoupper($request->kunci_jawaban),
                'kategori' => 'Listening',
                'id_gambar' => $request->gambar,
                'id_gambar_1' => null,
                'id_gambar_2' => null,
                'id_audio' => null,
                'id_users' => auth()->id(),
                'id_bank' => $request->id_bank,
            ]);
            DB::commit();
            Log::info('[SoalCrudService::storeListening] Tambah soal listening berhasil', [
                'nomor_soal' => $request->nomor_soal,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[SoalCrudService::storeListening] Tambah soal listening gagal', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function updateListening(Request $request): bool
    {
        Log::info('[SoalCrudService::updateListening] Memulai update soal listening', [
            'id_soal' => $request->id_soal,
        ]);

        DB::beginTransaction();
        try {
            Soal::where('id_soal', $request->id_soal)->update([
                'nomor_soal' => $request->nomor_soal,
                'text' => null,
                'soal' => $request->soal,
                'jawaban_a' => $request->jawaban_a,
                'jawaban_b' => $request->jawaban_b,
                'jawaban_c' => $request->jawaban_c,
                'jawaban_d' => $request->jawaban_d,
                'kunci_jawaban' => strtoupper($request->kunci_jawaban),
                'id_gambar' => $request->gambar,
                'id_gambar_1' => null,
                'id_gambar_2' => null,
                'id_audio' => null,
                'id_users' => auth()->id(),
            ]);
            DB::commit();
            Log::info('[SoalCrudService::updateListening] Update soal listening berhasil', [
                'id_soal' => $request->id_soal,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[SoalCrudService::updateListening] Update soal listening gagal', [
                'id_soal' => $request->id_soal,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    // =========================================================
    // READING
    // =========================================================

    public function getDashReading(int $id_bank, ?string $search = null): array
    {
        Log::info('[SoalCrudService::getDashReading] Mengambil data soal reading', [
            'id_bank' => $id_bank,
            'search' => $search,
        ]);

        $soal = Soal::with(['user', 'gambar'])
            ->where('id_bank', $id_bank)
            ->where('kategori', 'Reading')
            ->when($search, fn ($q) => $q
                ->orWhere('nomor_soal', 'LIKE', '%'.$search.'%')
                ->orWhere('soal', 'LIKE', '%'.$search.'%')
            )
            ->orderBy('nomor_soal', 'asc')
            ->paginate(15);

        $gambar = Gambar::all();

        // Auto-increment nomor soal — gabung Listening + Reading
        $penomoranListening = Soal::where('id_bank', $id_bank)
            ->where('kategori', 'Listening')
            ->orderBy('nomor_soal', 'desc')
            ->first();
        $penomoranReading = Soal::where('id_bank', $id_bank)
            ->where('kategori', 'Reading')
            ->orderBy('nomor_soal', 'desc')
            ->first();

        if (! $penomoranListening && ! $penomoranReading) {
            $nomor = 1;
        } elseif (! $penomoranReading) {
            $nomor = intval($penomoranListening->nomor_soal) + 1;
        } else {
            $nomor = intval($penomoranReading->nomor_soal) + 1;
        }

        return compact('soal', 'gambar', 'nomor');
    }

    public function storeReading(Request $request): bool
    {
        Log::info('[SoalCrudService::storeReading] Memulai tambah soal reading', [
            'nomor_soal' => $request->nomor_soal,
            'id_bank' => $request->id_bank,
            'id_users' => auth()->id(),
        ]);

        DB::beginTransaction();
        try {
            Soal::create([
                'nomor_soal' => $request->nomor_soal,
                'text' => $request->text,
                'soal' => $request->soal,
                'jawaban_a' => $request->jawaban_a,
                'jawaban_b' => $request->jawaban_b,
                'jawaban_c' => $request->jawaban_c,
                'jawaban_d' => $request->jawaban_d,
                'kunci_jawaban' => strtoupper($request->kunci_jawaban),
                'kategori' => 'Reading',
                'id_gambar' => $request->gambar,
                'id_gambar_1' => $request->gambar1,
                'id_gambar_2' => $request->gambar2,
                'id_audio' => null,
                'id_users' => auth()->id(),
                'id_bank' => $request->id_bank,
            ]);
            DB::commit();
            Log::info('[SoalCrudService::storeReading] Tambah soal reading berhasil', [
                'nomor_soal' => $request->nomor_soal,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[SoalCrudService::storeReading] Tambah soal reading gagal', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function updateReading(Request $request): bool
    {
        Log::info('[SoalCrudService::updateReading] Memulai update soal reading', [
            'id_soal' => $request->id_soal,
        ]);

        DB::beginTransaction();
        try {
            Soal::where('id_soal', $request->id_soal)->update([
                'nomor_soal' => $request->nomor_soal,
                'text' => $request->text,
                'soal' => $request->soal,
                'jawaban_a' => $request->jawaban_a,
                'jawaban_b' => $request->jawaban_b,
                'jawaban_c' => $request->jawaban_c,
                'jawaban_d' => $request->jawaban_d,
                'kunci_jawaban' => strtoupper($request->kunci_jawaban),
                'id_gambar' => $request->gambar,
                'id_gambar_1' => $request->gambar1,
                'id_gambar_2' => $request->gambar2,
                'id_audio' => null,
                'id_users' => auth()->id(),
            ]);
            DB::commit();
            Log::info('[SoalCrudService::updateReading] Update soal reading berhasil', [
                'id_soal' => $request->id_soal,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[SoalCrudService::updateReading] Update soal reading gagal', [
                'id_soal' => $request->id_soal,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    // =========================================================
    // DELETE — sama untuk Listening dan Reading
    // =========================================================

    public function deleteSoal(int $id_soal): bool
    {
        Log::info('[SoalCrudService::deleteSoal] Memulai hapus soal', [
            'id_soal' => $id_soal,
        ]);

        try {
            Soal::findOrFail($id_soal)->delete();
            Log::info('[SoalCrudService::deleteSoal] Hapus soal berhasil', [
                'id_soal' => $id_soal,
            ]);

            return true;
        } catch (\Throwable $th) {
            Log::error('[SoalCrudService::deleteSoal] Hapus soal gagal', [
                'id_soal' => $id_soal,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }
}
