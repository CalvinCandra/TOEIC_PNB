<?php

namespace App\Http\Middleware;

use App\Models\Peserta;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisableHistory
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->level === 'peserta') {
            $peserta = Peserta::where('id_users', auth()->id())->first();

            if ($peserta) {
                $path = $request->path();

                // ============================================
                // LAPIS 1: Cek status peserta
                // Mencegah peserta yang sudah selesai (status = Sudah)
                // mengakses kembali halaman ujian dari manapun
                // ============================================
                if ($peserta->status === 'Sudah') {
                    $examPaths  = ['Listening', 'SoalListening', 'Reading', 'SoalReading'];
                    $isExamPath = in_array($path, $examPaths)
                        || str_starts_with($path, 'SoalListening/')
                        || str_starts_with($path, 'SoalReading/');

                    if ($isExamPath) {
                        return redirect('/peserta')
                            ->with('info', 'Sesi ujian kamu telah berakhir.');
                    }
                }

                // ============================================
                // LAPIS 2: Cek urutan ujian
                // Mencegah peserta skip urutan atau kembali ke sesi sebelumnya
                // ============================================
                $isListeningPath = in_array($path, ['Listening', 'SoalListening'])
                    || str_starts_with($path, 'SoalListening/');

                // Jika sudah masuk Reading, tidak bisa kembali ke Listening
                if ($isListeningPath && ! is_null($peserta->reading_start_at)) {
                    return redirect('/Reading')
                        ->with('error', 'Sesi Listening sudah selesai. Lanjutkan ujian Reading.');
                }

                $isReadingPath = in_array($path, ['Reading', 'SoalReading'])
                    || str_starts_with($path, 'SoalReading/');

                // Jika belum memulai Listening, tidak bisa masuk Reading
                if ($isReadingPath && is_null($peserta->listening_start_at)) {
                    return redirect('/Listening')
                        ->with('error', 'Selesaikan ujian Listening terlebih dahulu.');
                }

                // ============================================
                // LAPIS 3: DIHAPUS
                // Token navigasi one-time use menyebabkan refresh
                // selalu redirect ke halaman aturan karena token
                // sudah dihapus setelah load pertama.
                // Lapis 1 dan 2 sudah cukup melindungi akses tidak sah.
                // ============================================
            }
        }

        // ============================================
        // LAPIS 4: Set header no-cache
        // Mencegah browser cache halaman ujian
        // Tombol Back tidak bisa tampilkan halaman dari cache
        // ============================================
        $response = $next($request);

        return $response
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
}