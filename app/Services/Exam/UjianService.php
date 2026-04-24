<?php

namespace App\Services\Exam;

use App\Models\BankSoal;
use App\Models\JawabanPeserta;
use App\Models\Nilai;
use App\Models\Part;
use App\Models\Peserta;
use App\Models\soal;
use Illuminate\Support\Facades\Log;

class UjianService
{
    public function getBankFromSession(?string $bankToken): ?BankSoal
    {
        if (! $bankToken) {
            return null;
        }

        return BankSoal::where('bank', $bankToken)->first();
    }

    public function getPesertaByUser(int $userId): ?Peserta
    {
        return Peserta::where('id_users', $userId)->first();
    }

    public function simpanJawaban(int $idPeserta, array $idSoalList, array $jawaban): void
    {
        Log::info('[UjianService::simpanJawaban] Menyimpan jawaban', [
            'id_peserta' => $idPeserta,
            'jumlah_soal' => count($idSoalList),
        ]);

        foreach ($idSoalList as $idSoal) {
            JawabanPeserta::create([
                'id_peserta' => $idPeserta,
                'id_soal' => $idSoal,
                'jawaban' => $jawaban[$idSoal] ?? 'N',
            ]);
        }
    }

    public function getNextPart(int $idPart, int $idBank, string $kategori): ?Part
    {
        $currentPart = Part::where('id_part', $idPart)
            ->where('id_bank', $idBank)
            ->first();

        if (! $currentPart) {
            return null;
        }

        return Part::where('tanda', $currentPart->tanda + 1)
            ->where('kategori', $kategori)
            ->where('id_bank', $idBank)
            ->first();
    }

    public function hitungSkorListening(Peserta $peserta, BankSoal $bank): array
    {
        Log::info('[UjianService::hitungSkorListening] Menghitung skor listening', [
            'id_peserta' => $peserta->id_peserta,
        ]);

        $jawabanPeserta = JawabanPeserta::join('soal', 'soal.id_soal', '=', 'jawaban_peserta.id_soal')
            ->where('jawaban_peserta.id_peserta', $peserta->id_peserta)
            ->where('soal.kategori', 'Listening')
            ->where('soal.id_bank', $bank->id_bank)
            ->pluck('jawaban_peserta.jawaban', 'jawaban_peserta.id_soal');

        $soalListening = soal::where('kategori', 'Listening')
            ->where('id_bank', $bank->id_bank)
            ->pluck('kunci_jawaban', 'id_soal');

        $benar = 0;
        $salah = 0;
        foreach ($soalListening as $idSoal => $kunci) {
            $jawaban = $jawabanPeserta[$idSoal] ?? 'N';
            $jawaban === $kunci ? $benar++ : $salah++;
        }

        $nilaiListening = Nilai::where('jawaban_benar', $benar)->first();
        $skor = $nilaiListening ? $nilaiListening->skor_listening : 0;

        Log::info('[UjianService::hitungSkorListening] Skor listening', [
            'benar' => $benar,
            'salah' => $salah,
            'skor' => $skor,
        ]);

        $peserta->update([
            'benar_listening' => $benar,
            'skor_listening' => $skor,
        ]);

        JawabanPeserta::where('id_peserta', $peserta->id_peserta)->delete();

        return ['benar' => $benar, 'salah' => $salah, 'skor' => $skor];
    }

    public function hitungSkorReading(Peserta $peserta, BankSoal $bank): array
    {
        Log::info('[UjianService::hitungSkorReading] Menghitung skor reading', [
            'id_peserta' => $peserta->id_peserta,
        ]);

        $jawabanPeserta = JawabanPeserta::where('id_peserta', $peserta->id_peserta)
            ->pluck('jawaban', 'id_soal');

        $soalReading = soal::where('kategori', 'Reading')
            ->where('id_bank', $bank->id_bank)
            ->pluck('kunci_jawaban', 'id_soal');

        $benar = 0;
        $salah = 0;
        foreach ($soalReading as $idSoal => $kunci) {
            $jawaban = $jawabanPeserta[$idSoal] ?? 'N';
            $jawaban === $kunci ? $benar++ : $salah++;
        }

        $nilaiReading = Nilai::where('jawaban_benar', $benar)->first();
        $skor = $nilaiReading ? $nilaiReading->skor_reading : 0;

        Log::info('[UjianService::hitungSkorReading] Skor reading', [
            'benar' => $benar,
            'salah' => $salah,
            'skor' => $skor,
        ]);

        $peserta->update([
            'benar_reading' => $benar,
            'skor_reading' => $skor,
            'status' => 'Sudah',
        ]);

        JawabanPeserta::where('id_peserta', $peserta->id_peserta)->delete();

        return ['benar' => $benar, 'salah' => $salah, 'skor' => $skor];
    }

    public function leaveExam(Peserta $peserta): void
    {
        if ($peserta->status === 'Sudah') {
            return;
        }

        $peserta->update(['status' => 'Sudah']);
    }
}
