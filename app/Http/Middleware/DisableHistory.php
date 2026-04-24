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

                if ($peserta->status === 'Sudah') {
                    $examPaths = ['Listening', 'SoalListening', 'Reading', 'SoalReading'];
                    $isExamPath = in_array($path, $examPaths)
                        || str_starts_with($path, 'SoalListening/')
                        || str_starts_with($path, 'SoalReading/');

                    if ($isExamPath) {
                        return redirect('/peserta')
                            ->with('info', 'Sesi ujian kamu telah berakhir.');
                    }
                }

                $isListeningPath = in_array($path, ['Listening', 'SoalListening'])
                    || str_starts_with($path, 'SoalListening/');

                if ($isListeningPath && !is_null($peserta->reading_start_at)) {
                    return redirect('/Reading')
                        ->with('error', 'Sesi Listening sudah selesai. Lanjutkan ujian Reading.');
                }

                $isReadingPath = in_array($path, ['Reading', 'SoalReading'])
                    || str_starts_with($path, 'SoalReading/');

                if ($isReadingPath && is_null($peserta->listening_start_at)) {
                    return redirect('/Listening')
                        ->with('error', 'Selesaikan ujian Listening terlebih dahulu.');
                }

                if (str_starts_with($path, 'SoalListening/')) {
                    $urlToken     = $request->route('token');
                    $sessionToken = $request->session()->get('exam_nav_token');
                    $expiry       = $request->session()->get('exam_nav_expiry', 0);
                    $isValid      = ($sessionToken === $urlToken) && (time() < $expiry);

                    if (!$isValid) {
                        $request->session()->forget(['exam_nav_token', 'exam_nav_expiry']);

                        return redirect('/Listening')
                            ->with('info', 'Silakan mulai ujian Listening dari halaman ini.');
                    }

                    $request->session()->forget(['exam_nav_token', 'exam_nav_expiry']);
                }

                if (str_starts_with($path, 'SoalReading/')) {
                    $urlToken     = $request->route('token');
                    $sessionToken = $request->session()->get('exam_nav_token');
                    $expiry       = $request->session()->get('exam_nav_expiry', 0);
                    $isValid      = ($sessionToken === $urlToken) && (time() < $expiry);

                    if (!$isValid) {
                        $request->session()->forget(['exam_nav_token', 'exam_nav_expiry']);

                        return redirect('/Reading')
                            ->with('info', 'Silakan mulai ujian Reading dari halaman ini.');
                    }

                    $request->session()->forget(['exam_nav_token', 'exam_nav_expiry']);
                }
            }
        }

        $response = $next($request);

        return $response
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
}