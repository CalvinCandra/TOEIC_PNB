<?php

namespace App\Jobs;

use App\Models\Nilai;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GeneratePdfResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 120;

    public function __construct(
        protected int $pesertaId,
        protected int $listeningBenar,
        protected int $listeningSalah,
        protected int $readingBenar,
        protected int $readingSalah,
    ) {}

    public function handle(): void
    {
        $peserta = Peserta::with('user')->find($this->pesertaId);
        $peserta->update(['pdf_status' => 'processing']);

        try {
            $nilaiListening = Nilai::where('jawaban_benar', $this->listeningBenar)->first();
            $nilaiReading   = Nilai::where('jawaban_benar', $this->readingBenar)->first();

            $skorListening = $nilaiListening ? $nilaiListening->skor_listening : 0;
            $skorReading   = $nilaiReading   ? $nilaiReading->skor_reading    : 0;
            $totalSkor     = $skorListening + $skorReading;

            $pdf = Pdf::loadView('vendor.pdf.result', [
                'nama_peserta'   => $peserta->nama_peserta,
                'email'          => $peserta->user->email,
                'nim'            => $peserta->nim,
                'jurusan'        => $peserta->jurusan,
                'skorReading'    => $skorReading,
                'benarReading'   => $this->readingBenar,
                'salahReading'   => $this->readingSalah,
                'skorListening'  => $skorListening,
                'benarListening' => $this->listeningBenar,
                'salahListening' => $this->listeningSalah,
                'totalSkor'      => $totalSkor,
                'kategori'       => $this->determineCategory($totalSkor)['kategori'],
                'rangeSkor'      => $this->determineCategory($totalSkor)['range'],
                'detail'         => $this->determineCategory($totalSkor)['detail'],
            ])->setPaper('a4');

            $sesiFolderName = str_replace(' ', '_', strtolower($peserta->sesi));
            $fileName       = 'Result_' . $peserta->nim . '_' . $peserta->sesi . '_' . Str::random(5) . '.pdf';
            $s3Path         = "result/{$sesiFolderName}/{$fileName}";

            $tempDir  = storage_path('app/temp');
            $tempPath = $tempDir . '/' . $fileName;
            @mkdir($tempDir, 0755, true);
            $pdf->save($tempPath);

            Storage::disk('s3')->put($s3Path, file_get_contents($tempPath), 'public');

            @unlink($tempPath);

            $peserta->update([
                'pdf_status' => 'done',
                'pdf_path'   => $s3Path,
            ]);

            Log::info("PDF Result uploaded to S3: {$s3Path}");
        } catch (\Throwable $th) {
            $peserta->update(['pdf_status' => 'failed']);
            Log::error('Gagal generate PDF ke S3: ' . $th->getMessage());
            throw $th;
        }
    }

    public function failed(\Throwable $exception): void
    {
        $peserta = Peserta::find($this->pesertaId);

        if ($peserta) {
            $peserta->update(['pdf_status' => 'failed']);
        }
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