<?php

namespace App\Services\Exam;

use App\Models\Nilai;
use App\Models\Peserta;
use Illuminate\Support\Facades\Log;

class NilaiService
{
    public function generateResult(array $sessionData, int $userId): ?array
    {
        Log::info('[NilaiService::generateResult] Memulai kalkulasi hasil ujian', [
            'id_users' => $userId,
        ]);

        $readingBenar   = $sessionData['benarReading']   ?? 0;
        $readingSalah = $sessionData['salahReading']   ?? 0;
        $listeningBenar = $sessionData['benarListening'] ?? 0;
        $listeningSalah = $sessionData['salahListening'] ?? 0;

        Log::info('[NilaiService::generateResult] Data jawaban dari session', [
            'benar_listening' => $listeningBenar,
            'benar_reading' => $readingBenar,
        ]);

        $nilaiReading   = Nilai::where('jawaban_benar', $readingBenar)->first();
        $nilaiListening = Nilai::where('jawaban_benar', $listeningBenar)->first();

        if (! $nilaiReading) {
            Log::warning('[NilaiService::generateResult] Data nilai reading tidak ditemukan', [
                'benar_reading' => $readingBenar,
            ]);
        }
        if (! $nilaiListening) {
            Log::warning('[NilaiService::generateResult] Data nilai listening tidak ditemukan', [
                'benar_listening' => $listeningBenar,
            ]);
        }

        $skorReading   = $nilaiReading   ? $nilaiReading->skor_reading    : 0;
        $skorListening = $nilaiListening ? $nilaiListening->skor_listening : 0;
        $totalSkor     = $skorReading + $skorListening;

        Log::info('[NilaiService::generateResult] Skor dihitung', [
            'skor_listening' => $skorListening,
            'skor_reading' => $skorReading,
            'total_skor' => $totalSkor,
        ]);

        $result    = $this->determineCategory($totalSkor);
        $kategori  = $result['kategori'];
        $rangeSkor = $result['range'];
        $detail    = $result['detail'];

        $peserta = Peserta::with('user')->where('id_users', $userId)->first();

        if (! $peserta) {
            return null;
        }

        $peserta->update(['pdf_status' => 'pending']);

        return compact(
            'peserta',
            'skorReading', 'skorListening', 'totalSkor',
            'kategori', 'rangeSkor', 'detail',
            'listeningBenar', 'listeningSalah',
            'readingBenar', 'readingSalah',
        );
    }

    private function determineCategory(int $totalSkor): array
    {
        return match (true) {
            $totalSkor >= 945 => [
                'kategori' => 'Proficient user - Effective Operational Proficiency C1',
                'range'    => '945 - 990',
                'detail'   => 'Can understand a wide range of demanding, longer texts, and recognise implicit meaning.',
            ],
            $totalSkor >= 785 => [
                'kategori' => 'Independent user - Vantage B2',
                'range'    => '785 - 940',
                'detail'   => 'Can understand the main ideas of complex text on both concrete and abstract topics.',
            ],
            $totalSkor >= 550 => [
                'kategori' => 'Independent user - Threshold B1',
                'range'    => '550 - 780',
                'detail'   => 'Can understand the main points of clear standard input on familiar matters.',
            ],
            $totalSkor >= 225 => [
                'kategori' => 'Basic user - Waystage A2',
                'range'    => '225 - 545',
                'detail'   => 'Can understand sentences and frequently used expressions related to areas of most immediate relevance.',
            ],
            default => [
                'kategori' => 'Basic user - Breakthrough A1',
                'range'    => '0 - 220',
                'detail'   => 'Can understand and use familiar everyday expressions and very basic phrases.',
            ],
        };
    }
}