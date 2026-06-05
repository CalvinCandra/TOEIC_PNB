<?php

namespace App\Services\Part;

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
            ->paginate(15)->withQueryString();

        $gambar = Gambar::all();
        $audio = Audio::all();

        // Cross-category sequential numbering — Listening range tanda 1-4
        $lastPartListening = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Listening')
            ->orderBy('tanda', 'desc')
            ->first();

        $nextTanda = $lastPartListening ? intval($lastPartListening->tanda) + 1 : 1;
        $isListeningFull = $nextTanda > 4;
        $nextPartName = "Part {$nextTanda}";

        // Auto-increment nomor soal — dari Listening saja
        $nomorSoal = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Listening')
            ->orderBy('sampai_nomor', 'desc')
            ->first();
        $angka = $nomorSoal ? intval($nomorSoal->sampai_nomor) + 1 : 1;

        $hasReading = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Reading')
            ->exists();

        return [
            'part' => $part,
            'gambar' => $gambar,
            'audio' => $audio,
            'nomor' => $nextTanda,
            'angka' => $angka,
            'nextPartName' => $nextPartName,
            'isListeningFull' => $isListeningFull,
            'hasReading' => $hasReading,
        ];
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

        // 🩹 Validasi block Listening setelah Reading ada
        $hasReading = Part::where('id_bank', $request->id_bank)
            ->where('kategori', 'Reading')
            ->exists();

        if ($hasReading) {
            return 'Cannot add new Listening Part after Reading Parts exist. '
                 . 'Please delete all Reading Parts first if you need to add more Listening.';
        }

        // Validasi max 4 Listening Part per bank
        $listeningCount = Part::where('id_bank', $request->id_bank)
            ->where('kategori', 'Listening')
            ->count();

        if ($listeningCount >= 4) {
            return 'Maximum 4 Listening parts allowed per bank (Part 1-4).';
        }

        if ($request->dari_nomor >= $request->sampai_nomor) {
            return 'Please do not fill in the numbers below '.$request->dari_nomor;
        }

        // Auto-generate nama Part (override input)
        $autoTanda = $listeningCount + 1;
        $autoPartName = "Part {$autoTanda}";

        $partSame = Part::where('part', $autoPartName)
            ->where('kategori', 'Listening')
            ->where('id_bank', $request->id_bank)
            ->first();

        if ($partSame) {
            return 'Part Already Exists';
        }

        DB::beginTransaction();
        try {
            Part::create([
                'part' => $autoPartName,
                'kategori' => 'Listening',
                'petunjuk' => $request->petunjuk,
                'dari_nomor' => $request->dari_nomor,
                'sampai_nomor' => $request->sampai_nomor,
                'token_part' => strtoupper(Str::password(5, true, true, false, false)),
                'tanda' => $autoTanda,
                'id_bank' => $request->id_bank,
                'id_gambar' => $request->gambar,
                'id_audio' => $request->audio,
            ]);
            DB::commit();
            Log::info('[PartService::storeListening] Tambah part listening berhasil', [
                'part' => $autoPartName,
                'tanda' => $autoTanda,
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
            ->paginate(15)->withQueryString();

        $gambar = Gambar::all();

        // Reading mulai dari tanda 5 minimal
        $lastPartReading = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Reading')
            ->orderBy('tanda', 'desc')
            ->first();

        $nextTanda = $lastPartReading
            ? intval($lastPartReading->tanda) + 1
            : 5;

        $isReadingFull = $nextTanda > 7;
        $nextPartName = "Part {$nextTanda}";

        // Cek apakah Reading boleh dibuat (wajib ada minimal 1 Listening)
        $hasListening = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Listening')
            ->exists();

        // Auto-increment nomor soal lintas kategori
        $lastListening = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Listening')
            ->orderBy('sampai_nomor', 'desc')
            ->first();

        $lastReadingByNomor = Part::where('id_bank', $id_bank)
            ->where('kategori', 'Reading')
            ->orderBy('sampai_nomor', 'desc')
            ->first();

        if ($lastReadingByNomor) {
            $angka = intval($lastReadingByNomor->sampai_nomor) + 1;
        } elseif ($lastListening) {
            $angka = intval($lastListening->sampai_nomor) + 1;
        } else {
            $angka = 1;
        }

        return [
            'part' => $part,
            'gambar' => $gambar,
            'nomor' => $nextTanda,
            'angka' => $angka,
            'nextPartName' => $nextPartName,
            'isReadingFull' => $isReadingFull,
            'hasListening' => $hasListening,
        ];
    }

    public function storeReading(Request $request): bool|string
    {
        Log::info('[PartService::storeReading] Memulai tambah part reading', [
            'part' => $request->part,
            'id_bank' => $request->id_bank,
        ]);

        // Validasi wajib ada minimal 1 Listening Part dulu
        $hasListening = Part::where('id_bank', $request->id_bank)
            ->where('kategori', 'Listening')
            ->exists();

        if (! $hasListening) {
            return 'Please add at least 1 Listening Part first before creating Reading Part.';
        }

        // Validasi max 3 Reading Part per bank
        $readingCount = Part::where('id_bank', $request->id_bank)
            ->where('kategori', 'Reading')
            ->count();

        if ($readingCount >= 3) {
            return 'Maximum 3 Reading parts allowed per bank (Part 5-7).';
        }

        if ($request->dari_nomor >= $request->sampai_nomor) {
            return 'Please do not fill in the numbers below '.$request->dari_nomor;
        }

        // Validasi cross-category nomor — Reading harus > sampai_nomor Listening
        $maxListeningNomor = Part::where('id_bank', $request->id_bank)
            ->where('kategori', 'Listening')
            ->max('sampai_nomor');

        if ($maxListeningNomor && $request->dari_nomor <= $maxListeningNomor) {
            return "Reading must start from question number ".($maxListeningNomor + 1)." or higher.";
        }

        // Auto-generate nama & tanda
        $autoTanda = 5 + $readingCount;
        $autoPartName = "Part {$autoTanda}";

        $partSame = Part::where('part', $autoPartName)
            ->where('kategori', 'Reading')
            ->where('id_bank', $request->id_bank)
            ->first();

        if ($partSame) {
            return 'Part Already Exists';
        }

        DB::beginTransaction();
        try {
            Part::create([
                'part' => $autoPartName,
                'kategori' => 'Reading',
                'petunjuk' => $request->petunjuk,
                'multi_soal' => $request->multi,
                'dari_nomor' => $request->dari_nomor,
                'sampai_nomor' => $request->sampai_nomor,
                'token_part' => strtoupper(Str::password(5, true, true, false, false)),
                'tanda' => $autoTanda,
                'id_bank' => $request->id_bank,
                'id_gambar' => $request->gambar,
                'id_audio' => null,
            ]);
            DB::commit();
            Log::info('[PartService::storeReading] Tambah part reading berhasil', [
                'part' => $autoPartName,
                'tanda' => $autoTanda,
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
