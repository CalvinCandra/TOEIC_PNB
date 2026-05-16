<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Soal;
use App\Services\Exam\UjianService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SoalController extends Controller
{
    public function __construct(protected UjianService $ujianService) {}

    // ============================================================
    // PRIVATE HELPERS
    // ============================================================

    /**
     * Guard: pastikan session 'bank' masih ada.
     * Jika tidak ada → peserta belum input token atau session expired.
     */
    private function guardSession(Request $request): bool
    {
        if ($request->session()->get('bank') === null) {
            return false;
        }

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        if (! $peserta) {
            return false;
        }

        if ($peserta->status === 'Sudah') {
            $this->clearExamSession($request);
            return false;
        }

        return true;
    }

    /**
     * Hapus semua session yang berkaitan dengan ujian.
     * Dipanggil saat ujian selesai, error, atau peserta keluar.
     */
    private function clearExamSession(Request $request): void
    {
        $request->session()->forget([
            'bank',
            'waktu',
            'quizEndTime',
            'waktu_akhir',
        ]);
    }

/**
     * Hitung sisa waktu ujian dalam detik.
     * FIX: dilindungi dari nilai null dan negatif.
     * Nilai negatif menyebabkan JavaScript timer langsung trigger auto-submit
     * dan me-redirect peserta ke halaman Aturan saat refresh.
     */
    private function getRemainingSeconds(Request $request): int
    {
        $quizEndTime = $request->session()->get('quizEndTime');

        if (! $quizEndTime) {
            return 0;
        }

        $diff = Carbon::now()->diffInSeconds(Carbon::parse($quizEndTime), false);

        

        // false = signed diff; positif = masih ada waktu, negatif = sudah lewat
        return max(0, $diff);
    }

    /**
     * Ambil base URL S3 dengan cache 1 jam.
     * Storage::disk('s3')->url() melakukan HTTP call setiap request — di-cache agar ringan.
     */
    private function getS3Url(string $folder): string
    {
        return Cache::remember("s3_url_{$folder}", 3600, function () use ($folder) {
            return Storage::disk('s3')->url("{$folder}/");
        });
    }

    // ============================================================
    // LISTENING
    // ============================================================

    public function Listening(Request $request)
    {
        Log::info('[SoalController::Listening] Masuk halaman aturan listening', [
            'id_users' => auth()->id(),
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        return view('peserta.Soal.ListeningAturan');
    }

    public function GetListening(Request $request)
    {
        Log::info('[SoalController::GetListening] Peserta mulai listening', [
            'id_users' => auth()->id(),
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        // FIX: getBankFromSession() hanya dipanggil SEKALI (sebelumnya 2x = 2 query)
        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            Log::warning('[SoalController::GetListening] Bank soal tidak ditemukan');
            return redirect('/DashboardSoal');
        }

        // FIX: getPesertaByUser() hanya dipanggil SEKALI (sebelumnya 2x = 2 query)
        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        if (! $peserta) {
            Log::warning('[SoalController::GetListening] Peserta tidak ditemukan');
            return redirect('/DashboardSoal');
        }

        if (is_null($peserta->listening_start_at)) {
            $peserta->update(['listening_start_at' => now()]);
        }

        $peserta->update(['status' => 'Kerjain']);

        $quizEndTime = Carbon::now()->addMinutes(45);
        $request->session()->put('quizEndTime', $quizEndTime);
        $request->session()->put('waktu_akhir', Carbon::today()->format('Y-m-d') . ' ' . $getBank->waktu_akhir);

        // FIX: tambahkan orderBy('tanda') agar selalu ambil Part 1 bukan random
        $partPertama = Part::where('kategori', 'Listening')
            ->where('id_bank', $getBank->id_bank)
            ->orderBy('tanda')
            ->first();

        if (! $partPertama) {
            Log::error('[SoalController::GetListening] Part pertama listening tidak ditemukan', [
                'id_bank' => $getBank->id_bank,
            ]);
            return redirect('/DashboardSoal');
        }

        Log::info('[SoalController::GetListening] Redirect ke part pertama', [
            'id_peserta' => $peserta->id_peserta,
            'token_part' => $partPertama->token_part,
        ]);

        return redirect("/SoalListening/{$partPertama->token_part}");
    }

    public function soalListening(Request $request, string $token)
    {
        Log::info('[SoalController::soalListening] Tampil soal listening', [
            'id_users'   => auth()->id(),
            'token_part' => $token,
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        // FIX: guard $getBank null — sebelumnya tidak ada, menyebabkan crash
        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');
            return redirect('/DashboardSoal');
        }

        $part = Part::with(['audio', 'gambar'])
            ->where('kategori', 'Listening')
            ->where('token_part', $token)
            ->first();

        if (! $part) {
            Log::error('[SoalController::soalListening] Part tidak ditemukan', ['token' => $token]);
            return redirect('/DashboardSoal');
        }

        $GetAllPart = Part::where('kategori', 'Listening')
            ->where('id_bank', $getBank->id_bank)
            ->orderBy('tanda')
            ->get();

        // OPTIMASI: query disederhanakan — tidak perlu join bank_soal dan part
        // karena $part->dari_nomor dan $part->sampai_nomor sudah tersedia
        // dan id_bank sudah diketahui dari $getBank
        $soalListening = Soal::with(['audio', 'gambar'])
            ->where('kategori', 'Listening')
            ->where('id_bank', $getBank->id_bank)
            ->whereBetween('nomor_soal', [$part->dari_nomor, $part->sampai_nomor])
            ->orderBy('nomor_soal')
            ->get();

        // Hitung sisa waktu dari DB (listening_start_at), bukan dari session quizEndTime
        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        if ($peserta && $peserta->listening_start_at) {
            $durasiDetik   = 46 * 60;
            $elapsed       = now()->diffInSeconds($peserta->listening_start_at);
            $remainingTime = max(0, $durasiDetik - $elapsed);

            $newEndTime = \Carbon\Carbon::parse($peserta->listening_start_at)->addSeconds($durasiDetik);
            $request->session()->put('quizEndTime', $newEndTime);
        } else {
            $remainingTime = $this->getRemainingSeconds($request);
        }

        $request->session()->put('waktu', $remainingTime);

        // OPTIMASI: URL S3 di-cache, tidak di-generate ulang setiap request
        $urlpathimage = $this->getS3Url('gambar');
        $urlpathaudio = $this->getS3Url('audio');

        return response()
            ->view('peserta.Soal.Listeningtest', compact(
                'soalListening',
                'part',
                'GetAllPart',
                'urlpathimage',
                'urlpathaudio'
            ) + ['type' => 'listening'])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function ProsesJawabListening(Request $request)
    {
        Log::info('[SoalController::ProsesJawabListening] Proses jawaban listening', [
            'id_users'    => auth()->id(),
            'jumlah_soal' => count($request->id_soal ?? []),
            'tombol'      => $request->tombol,
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        if (! $request->isMethod('post')) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid. Jawaban tidak terkumpul.');
            return redirect('/DashboardSoal');
        }

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        try {
            $this->ujianService->simpanJawaban(
                $peserta->id_peserta,
                $request->id_soal,
                $request->jawaban ?? []
            );
        } catch (\Throwable $th) {
            Log::error('[SoalController::ProsesJawabListening] Gagal simpan jawaban', [
                'error' => $th->getMessage(),
            ]);
        }

        if ($request->tombol === 'next') {
            $nextPart = $this->ujianService->getNextPart(
                (int) $request->id_part,
                $getBank->id_bank,
                'Listening'
            );

            return redirect("/SoalListening/{$nextPart->token_part}");
        }

        $request->session()->forget(['waktu', 'quizEndTime']);

        return redirect()->route('nilaiListening');
    }

    public function GetNilaiListening(Request $request)
    {
        Log::info('[SoalController::GetNilaiListening] Hitung nilai listening', [
            'id_users' => auth()->id(),
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');
            return redirect('/DashboardSoal');
        }

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());
        $hasil   = $this->ujianService->hitungSkorListening($peserta, $getBank);

        $request->session()->put('benarListening', $hasil['benar']);
        $request->session()->put('salahListening', $hasil['salah']);
        $request->session()->forget(['waktu', 'quizEndTime']);

        return redirect('/Reading');
    }

    // ============================================================
    // READING
    // ============================================================

    public function Reading(Request $request)
    {
        Log::info('[SoalController::Reading] Masuk halaman aturan reading', [
            'id_users' => auth()->id(),
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        return view('peserta.Soal.ReadingAturan');
    }

    public function GetReading(Request $request)
    {
        Log::info('[SoalController::GetReading] Peserta mulai reading', [
            'id_users' => auth()->id(),
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        // FIX: getBankFromSession() hanya dipanggil SEKALI (sebelumnya 2x = 2 query)
        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');
            return redirect('/DashboardSoal');
        }

        // FIX: getPesertaByUser() hanya dipanggil SEKALI (sebelumnya tidak ada guard null)
        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        if (! $peserta) {
            Log::warning('[SoalController::GetReading] Peserta tidak ditemukan');
            return redirect('/DashboardSoal');
        }

        if (is_null($peserta->reading_start_at)) {
            $peserta->update(['reading_start_at' => now()]);
        }

        $quizEndTime = Carbon::now()->addMinutes(75);
        $request->session()->put('quizEndTime', $quizEndTime);
        $request->session()->put('waktu_akhir', Carbon::today()->format('Y-m-d') . ' ' . $getBank->waktu_akhir);

        // FIX: tambahkan orderBy('tanda') agar selalu ambil Part pertama yang benar
        $partPertama = Part::where('kategori', 'Reading')
            ->where('id_bank', $getBank->id_bank)
            ->orderBy('tanda')
            ->first();

        if (! $partPertama) {
            Log::error('[SoalController::GetReading] Part pertama reading tidak ditemukan', [
                'id_bank' => $getBank->id_bank,
            ]);
            return redirect('/DashboardSoal');
        }

        return redirect("/SoalReading/{$partPertama->token_part}");
    }

    public function soalReading(Request $request, string $token)
    {
        Log::info('[SoalController::soalReading] Tampil soal reading', [
            'id_users'   => auth()->id(),
            'token_part' => $token,
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');
            return redirect('/DashboardSoal');
        }

        $part = Part::with(['audio', 'gambar', 'gambar1', 'gambar2'])
            ->where('kategori', 'Reading')
            ->where('token_part', $token)
            ->first();

        if (! $part) {
            Log::error('[SoalController::soalReading] Part tidak ditemukan', ['token' => $token]);
            return redirect('/DashboardSoal');
        }

        $GetAllPart = Part::where('kategori', 'Reading')
            ->where('id_bank', $getBank->id_bank)
            ->orderBy('tanda')
            ->get();

        // OPTIMASI: query disederhanakan — tidak perlu join bank_soal dan part
        $soalReading = Soal::with(['audio', 'gambar', 'gambar1', 'gambar2'])
            ->where('kategori', 'Reading')
            ->where('id_bank', $getBank->id_bank)
            ->whereBetween('nomor_soal', [$part->dari_nomor, $part->sampai_nomor])
            ->orderBy('nomor_soal')
            ->get();

        // Hitung sisa waktu dari DB (reading_start_at), bukan dari session quizEndTime
        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        if ($peserta && $peserta->reading_start_at) {
            $durasiDetik   = 75 * 60;
            $elapsed       = now()->diffInSeconds($peserta->reading_start_at);
            $remainingTime = max(0, $durasiDetik - $elapsed);

            $newEndTime = \Carbon\Carbon::parse($peserta->reading_start_at)->addSeconds($durasiDetik);
            $request->session()->put('quizEndTime', $newEndTime);
        } else {
            $remainingTime = $this->getRemainingSeconds($request);
        }

        $request->session()->put('waktu', $remainingTime);

        // OPTIMASI: URL S3 di-cache
        $urlpathimage = $this->getS3Url('gambar');

        return response()
            ->view('peserta.Soal.Readingtest', compact(
                'soalReading',
                'part',
                'GetAllPart',
                'urlpathimage'
            ) + ['type' => 'reading'])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function ProsesJawabReading(Request $request)
    {
        Log::info('[SoalController::ProsesJawabReading] Proses jawaban reading', [
            'id_users'    => auth()->id(),
            'jumlah_soal' => count($request->id_soal ?? []),
            'tombol'      => $request->tombol,
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        if (! $request->isMethod('post')) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');
            return redirect('/DashboardSoal');
        }

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        try {
            $this->ujianService->simpanJawaban(
                $peserta->id_peserta,
                $request->id_soal,
                $request->jawaban ?? []
            );
        } catch (\Throwable $th) {
            Log::error('[SoalController::ProsesJawabReading] Gagal simpan jawaban', [
                'error' => $th->getMessage(),
            ]);
        }

        if ($request->tombol === 'next') {
            $nextPart = $this->ujianService->getNextPart(
                (int) $request->id_part,
                $getBank->id_bank,
                'Reading'
            );

            return redirect("/SoalReading/{$nextPart->token_part}");
        }

        $request->session()->forget(['waktu', 'quizEndTime']);

        return redirect()->route('nilaiReading');
    }

    public function GetNilaiReading(Request $request)
    {
        Log::info('[SoalController::GetNilaiReading] Hitung nilai reading', [
            'id_users' => auth()->id(),
        ]);

        if (! $this->guardSession($request)) {
            return redirect('/DashboardSoal');
        }

        $getBank = $this->ujianService->getBankFromSession($request->session()->get('bank'));

        if (! $getBank) {
            $this->clearExamSession($request);
            Alert::error('Information', 'Waktu habis atau token tidak valid.');
            return redirect('/DashboardSoal');
        }

        $peserta = $this->ujianService->getPesertaByUser(auth()->id());
        $hasil   = $this->ujianService->hitungSkorReading($peserta, $getBank);

        $request->session()->put('benarReading', $hasil['benar']);
        $request->session()->put('salahReading', $hasil['salah']);
        $request->session()->forget(['waktu', 'quizEndTime']);

        return redirect('/Result');
    }

    // ============================================================
    // UTILITY
    // ============================================================

    public function destory(Request $request)
    {
        $request->session()->forget([
            'benarReading',
            'salahReading',
            'benarListening',
            'salahListening',
            'bank',
            'waktu',
            'waktu_akhir',
            'email_sent',
            'result_generated',
            'quizEndTime',
        ]);

        return redirect('/DashboardSoal');
    }

    public function getRemainingTime(string $type)
    {
        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        if (! $peserta) {
            return response()->json(['remaining' => 0, 'auto_submit' => true]);
        }

        $durasiDetik = $type === 'listening' ? (46 * 60) : (75 * 60);

        $startAt = $type === 'listening'
            ? $peserta->listening_start_at
            : $peserta->reading_start_at;

        if (! $startAt) {
            return response()->json([
                'remaining'   => $durasiDetik,
                'auto_submit' => false,
            ]);
        }

        $elapsed   = \Carbon\Carbon::parse($startAt)->diffInSeconds(now());
        $remaining = max(0, $durasiDetik - $elapsed);

        Log::info('[getRemainingTime]', [
            'type' => $type,
            'startAt' => $startAt,
            'startAt_type' => gettype($startAt),
            'now' => now(),
            'elapsed' => $elapsed,
            'remaining' => $remaining,
        ]);

        return response()->json([
            'remaining'   => (int) $remaining,
            'auto_submit' => $remaining <= 0,
        ]);
    }

    public function leaveExam(Request $request)
    {
        $peserta = $this->ujianService->getPesertaByUser(auth()->id());

        if (! $peserta) {
            return response()->json(['success' => false], 404);
        }

        $this->ujianService->leaveExam($peserta);
        $this->clearExamSession($request);

        return response()->json(['success' => true]);
    }
}