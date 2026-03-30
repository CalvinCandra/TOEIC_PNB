<?php

namespace App\Services;

use App\Models\Audio;
use App\Models\Gambar;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PartService
{
    // =========================================================
    // LISTENING
    // =========================================================

    public function getDashListening(int $id_bank, ?string $search = null): array
    {
        Log::info('[PartService::getDashListening] Mengambil data part listening', [
            'id_bank' => $id_bank,
            'search' => $search,
        ]);

        $part = Part::with(['bank', 'audio', 'gambar'])
            ->where('id_bank', $id_bank)
            ->where('kategori', 'Listening')
            ->when($search, fn ($q) => $q->where('part', 'LIKE', '%'.$search.'%'))
            ->paginate(15);

        $gambar = Gambar::all();
        $audio = Audio::all();

        // Auto-increment tanda (urutan part)
        $tanda = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Listening')
            ->orderBy('tanda', 'desc')
            ->first();
        $nomor = $tanda ? intval($tanda->tanda) + 1 : 1;

        // Auto-increment nomor soal — dari Listening saja
        $nomorSoal = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Listening')
            ->orderBy('sampai_nomor', 'desc')
            ->first();
        $angka = $nomorSoal ? intval($nomorSoal->sampai_nomor) + 1 : 1;

        return compact('part', 'gambar', 'audio', 'nomor', 'angka');
    }

    public function storeListening(Request $request): bool|string
    {
        Log::info('[PartService::storeListening] Memulai tambah part listening', [
            'part' => $request->part,
            'id_bank' => $request->id_bank,
        ]);

        $request->validate([
            'petunjuk' => 'required|string',
        ], [
            'petunjuk.required' => 'Direction cannot be empty',
        ]);

        if ($request->dari_nomor >= $request->sampai_nomor) {
            return 'Please do not fill in the numbers below '.$request->dari_nomor;
        }

        $partSame = Part::where('part', $request->part)
            ->where('kategori', 'Listening')
            ->where('id_bank', $request->id_bank)
            ->first();

        if ($partSame) {
            return 'Part Already Exists';
        }

        DB::beginTransaction();
        try {
            Part::create([
                'part' => $request->part,
                'kategori' => 'Listening',
                'petunjuk' => $request->petunjuk,
                'dari_nomor' => $request->dari_nomor,
                'sampai_nomor' => $request->sampai_nomor,
                'token_part' => strtoupper(Str::password(5, true, true, false, false)),
                'tanda' => $request->tanda,
                'id_bank' => $request->id_bank,
                'id_gambar' => $request->gambar,
                'id_audio' => $request->audio,
            ]);
            DB::commit();
            Log::info('[PartService::storeListening] Tambah part listening berhasil', [
                'part' => $request->part,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[PartService::storeListening] Tambah part listening gagal', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function updateListening(Request $request): bool|string
    {
        Log::info('[PartService::updateListening] Memulai update part listening', [
            'id_part' => $request->id_part,
        ]);

        if ($request->dari_nomor >= $request->sampai_nomor) {
            return 'Please do not fill in the numbers below '.$request->dari_nomor;
        }

        $cekPart = Part::where('id_part', $request->id_part)->first();
        if ($cekPart && $cekPart->part != $request->part) {
            $partSame = Part::where('part', $request->part)
                ->where('kategori', 'Listening')
                ->where('id_bank', $request->id_bank)
                ->first();
            if ($partSame) {
                return 'Part Already Exists';
            }
        }

        DB::beginTransaction();
        try {
            Part::where('id_part', $request->id_part)->update([
                'part' => $request->part,
                'kategori' => 'Listening',
                'petunjuk' => $request->petunjuk,
                'dari_nomor' => $request->dari_nomor,
                'sampai_nomor' => $request->sampai_nomor,
                'id_bank' => $request->id_bank,
                'id_gambar' => $request->gambar,
                'id_audio' => $request->audio,
            ]);
            DB::commit();
            Log::info('[PartService::updateListening] Update part listening berhasil', [
                'id_part' => $request->id_part,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[PartService::updateListening] Update part listening gagal', [
                'id_part' => $request->id_part,
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
        Log::info('[PartService::getDashReading] Mengambil data part reading', [
            'id_bank' => $id_bank,
            'search' => $search,
        ]);

        $part = Part::with(['bank', 'gambar'])
            ->where('id_bank', $id_bank)
            ->where('kategori', 'Reading')
            ->when($search, fn ($q) => $q->where('part', 'LIKE', '%'.$search.'%'))
            ->paginate(15);

        $gambar = Gambar::all();

        // Auto-increment tanda (urutan part)
        $tanda = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Reading')
            ->orderBy('tanda', 'desc')
            ->first();
        $nomor = $tanda ? intval($tanda->tanda) + 1 : 1;

        // Auto-increment nomor soal — gabung Listening + Reading
        $nomorSoalListening = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Listening')
            ->orderBy('sampai_nomor', 'desc')
            ->first();
        $nomorSoalReading = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Reading')
            ->orderBy('sampai_nomor', 'desc')
            ->first();

        if (! $nomorSoalListening && ! $nomorSoalReading) {
            $angka = 1;
        } elseif (! $nomorSoalReading) {
            $angka = intval($nomorSoalListening->sampai_nomor) + 1;
        } else {
            $angka = intval($nomorSoalReading->sampai_nomor) + 1;
        }

        return compact('part', 'gambar', 'nomor', 'angka');
    }

    public function storeReading(Request $request): bool|string
    {
        Log::info('[PartService::storeReading] Memulai tambah part reading', [
            'part' => $request->part,
            'id_bank' => $request->id_bank,
        ]);

        if ($request->dari_nomor >= $request->sampai_nomor) {
            return 'Please do not fill in the numbers below '.$request->dari_nomor;
        }

        $partSame = Part::where('part', $request->part)
            ->where('kategori', 'Reading')
            ->where('id_bank', $request->id_bank)
            ->first();

        if ($partSame) {
            return 'Part Already Exists';
        }

        DB::beginTransaction();
        try {
            Part::create([
                'part' => $request->part,
                'kategori' => 'Reading',
                'petunjuk' => $request->petunjuk,
                'multi_soal' => $request->multi,
                'dari_nomor' => $request->dari_nomor,
                'sampai_nomor' => $request->sampai_nomor,
                'token_part' => strtoupper(Str::password(5, true, true, false, false)),
                'tanda' => $request->tanda,
                'id_bank' => $request->id_bank,
                'id_gambar' => $request->gambar,
                'id_audio' => null,
            ]);
            DB::commit();
            Log::info('[PartService::storeReading] Tambah part reading berhasil', [
                'part' => $request->part,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[PartService::storeReading] Tambah part reading gagal', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function updateReading(Request $request): bool|string
    {
        Log::info('[PartService::updateReading] Memulai update part reading', [
            'id_part' => $request->id_part,
        ]);

        if ($request->dari_nomor >= $request->sampai_nomor) {
            return 'Please do not fill in the numbers below '.$request->dari_nomor;
        }

        $cekPart = Part::where('id_part', $request->id_part)->first();
        if ($cekPart && $cekPart->part != $request->part) {
            $partSame = Part::where('part', $request->part)
                ->where('kategori', 'Reading')
                ->where('id_bank', $request->id_bank)
                ->first();
            if ($partSame) {
                return 'Part Already Exists';
            }
        }

        DB::beginTransaction();
        try {
            Part::where('id_part', $request->id_part)->update([
                'part' => $request->part,
                'kategori' => 'Reading',
                'petunjuk' => $request->petunjuk,
                'multi_soal' => $request->multi,
                'dari_nomor' => $request->dari_nomor,
                'sampai_nomor' => $request->sampai_nomor,
                'id_bank' => $request->id_bank,
                'id_gambar' => $request->gambar,
                'id_audio' => null,
            ]);
            DB::commit();
            Log::info('[PartService::updateReading] Update part reading berhasil', [
                'id_part' => $request->id_part,
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[PartService::updateReading] Update part reading gagal', [
                'id_part' => $request->id_part,
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

    public function deletePart(int $id_part): bool
    {
        Log::info('[PartService::deletePart] Memulai hapus part', [
            'id_part' => $id_part,
        ]);

        try {
            Part::findOrFail($id_part)->delete();
            Log::info('[PartService::deletePart] Hapus part berhasil', [
                'id_part' => $id_part,
            ]);

            return true;
        } catch (\Throwable $th) {
            Log::error('[PartService::deletePart] Hapus part gagal', [
                'id_part' => $id_part,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }
}
