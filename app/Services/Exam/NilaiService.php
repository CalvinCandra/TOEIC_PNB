<?php

namespace App\Services\Exam;

use App\Models\Nilai;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NilaiService
{
    public function generateResult(array $sessionData, int $userId): ?array
    {
        Log::info('[NilaiService::generateResult] Memulai kalkulasi hasil ujian', [
            'id_users' => $userId,
        ]);

        $readingBenar = $sessionData['benarReading'] ?? 0;
        $readingSalah = $sessionData['salahReading'] ?? 0;
        $listeningBenar = $sessionData['benarListening'] ?? 0;
        $listeningSalah = $sessionData['salahListening'] ?? 0;

        Log::info('[NilaiService::generateResult] Data jawaban dari session', [
            'benar_listening' => $listeningBenar,
            'benar_reading' => $readingBenar,
        ]);

        $nilaiReading = Nilai::where('jawaban_benar', $readingBenar)->first();
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

        $skorReading = $nilaiReading ? $nilaiReading->skor_reading : 0;
        $skorListening = $nilaiListening ? $nilaiListening->skor_listening : 0;
        $totalSkor = $skorReading + $skorListening;

        Log::info('[NilaiService::generateResult] Skor dihitung', [
            'skor_listening' => $skorListening,
            'skor_reading' => $skorReading,
            'total_skor' => $totalSkor,
        ]);

        $result = $this->determineCategory($totalSkor);
        $kategori = $result['kategori'];
        $rangeSkor = $result['range'];
        $detail = $result['detail'];

        $peserta = Peserta::with('user')->where('id_users', $userId)->first();

        $pdf = Pdf::loadView('vendor.pdf.result', [
            'nama_peserta' => $peserta->nama_peserta,
            'email' => $peserta->user->email,
            'nim' => $peserta->nim,
            'jurusan' => $peserta->jurusan,
            'skorReading' => $skorReading,
            'benarReading' => $readingBenar,
            'salahReading' => $readingSalah,
            'skorListening' => $skorListening,
            'benarListening' => $listeningBenar,
            'salahListening' => $listeningSalah,
            'totalSkor' => $totalSkor,
            'kategori' => $kategori,
            'rangeSkor' => $rangeSkor,
            'detail' => $detail,
        ])->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true);

        $sesiFolderName = str_replace(' ', '_', strtolower($peserta->sesi));
        $pdfDir = storage_path("app/public/result/{$sesiFolderName}/");
        $pdfPath = $pdfDir.'Result_'.$peserta->nim.'_'.$peserta->sesi.'_'.Str::random(5).'.pdf';

        if (! is_dir($pdfDir)) {
            mkdir($pdfDir, 0755, true);
        }

        $pdf->save($pdfPath);

        Log::info('[NilaiService::generateResult] PDF disimpan', [
            'id_peserta' => $peserta->id_peserta,
            'nim' => $peserta->nim,
            'sesi' => $peserta->sesi,
            'total_skor' => $totalSkor,
            'path' => $pdfPath,
        ]);

        return compact(
            'peserta',
            'skorReading', 'skorListening', 'totalSkor',
            'kategori', 'rangeSkor', 'detail'
        );
    }

    private function determineCategory(int $totalSkor): array
    {
        return match (true) {
            $totalSkor >= 945 => [
                'kategori' => 'Proficient user - Effective Operational Proficiency C1',
                'range' => '945 - 990',
                'detail' => 'Can understand a wide range of demanding, longer texts, and recognise implicit meaning. Can express him/ herself fluently and spontaneously without much obvious searching for expressions.',
            ],
            $totalSkor >= 785 => [
                'kategori' => 'Independent user - Vantage B2',
                'range' => '785 - 940',
                'detail' => 'Can understand the main ideas of complex text on both concrete and abstract topics, including technical discussions in his/her field of specialisation.',
            ],
            $totalSkor >= 550 => [
                'kategori' => 'Independent user - Threshold B1',
                'range' => '550 - 780',
                'detail' => 'Can understand the main points of clear standard input on familiar matters regularly encountered in work, school, leisure, etc.',
            ],
            $totalSkor >= 225 => [
                'kategori' => 'Basic user - Waystage A2',
                'range' => '225 - 545',
                'detail' => 'Can understand sentences and frequently used expressions related to areas of most immediate relevance.',
            ],
            default => [
                'kategori' => 'Basic user - Breakthrough A1',
                'range' => '0 - 220',
                'detail' => 'Can understand and use familiar everyday expressions and very basic phrases aimed at the satisfaction of needs of a concrete type.',
            ],
        };
    }
}
