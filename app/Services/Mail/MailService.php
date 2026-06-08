<?php

namespace App\Services\Mail;

use App\Mail\SendMail;
use App\Models\Petugas;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService
{
    private array $sesiMap = [
        'Sesione' => 'Session 1',
        'Sesitwo' => 'Session 2',
        'Sesithree' => 'Session 3',
        'Sesifour' => 'Session 4',
        'Sesifive' => 'Session 5',
        'Sesisix' => 'Session 6',
        'Sesiseven' => 'Session 7',
        'Sesieight' => 'Session 8',
    ];

    public function sendToPetugas(int $id): bool
    {
        Log::info('[MailService::sendToPetugas] Kirim email ke petugas', ['id_petugas' => $id]);

        try {
            $petugas = Petugas::with('user')->findOrFail($id);
            Mail::to($petugas->user->email)->send(new SendMail($petugas));
            Log::info('[MailService::sendToPetugas] Email berhasil dikirim', ['email' => $petugas->user->email]);

            return true;
        } catch (\Throwable $th) {
            Log::error('[MailService::sendToPetugas] Gagal kirim email', [
                'id_petugas' => $id,
                'error' => $th->getMessage(),
            ]);

            return false;
        }
    }

    public function sendToPetugasAll(): void
    {
        Log::info('[MailService::sendToPetugasAll] Kirim email ke semua petugas');
        set_time_limit(0);

        Petugas::with('user')->chunk(100, function ($batch) {
            foreach ($batch as $petugas) {
                try {
                    Mail::to($petugas->user->email)->send(new SendMail($petugas));
                } catch (\Throwable $th) {
                    Log::error('[MailService::sendToPetugasAll] Gagal kirim ke petugas', [
                        'email' => $petugas->user->email,
                        'error' => $th->getMessage(),
                    ]);
                }
                sleep(1);
            }
            sleep(60);
        });
    }

}
