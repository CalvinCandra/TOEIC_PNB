<?php

namespace App\Services\Mail;

use App\Mail\SendMail;
use App\Models\Peserta;
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

    public function sendToPeserta(int $id): bool
    {
        Log::info('[MailService::sendToPeserta] Kirim email ke peserta', ['id_peserta' => $id]);

        try {
            $peserta = Peserta::with('user')->findOrFail($id);
            Mail::to($peserta->user->email)->send(new SendMail($peserta));
            Log::info('[MailService::sendToPeserta] Email berhasil dikirim', ['email' => $peserta->user->email]);

            return true;
        } catch (\Throwable $th) {
            Log::error('[MailService::sendToPeserta] Gagal kirim email', [
                'id_peserta' => $id,
                'error' => $th->getMessage(),
            ]);

            return false;
        }
    }

    public function sendToPesertaAll(string $sesiParam): bool
    {
        if (! isset($this->sesiMap[$sesiParam])) {
            Log::warning('[MailService::sendToPesertaAll] Parameter sesi tidak valid', [
                'sesi_param' => $sesiParam,
            ]);

            return false;
        }

        $sesiNama = $this->sesiMap[$sesiParam];

        Log::info('[MailService::sendToPesertaAll] Kirim email ke peserta sesi', [
            'sesi' => $sesiNama,
        ]);

        set_time_limit(0);

        Peserta::with('user')->where('sesi', $sesiNama)->chunk(100, function ($batch) {
            foreach ($batch as $peserta) {
                try {
                    Mail::to($peserta->user->email)->send(new SendMail($peserta));
                } catch (\Throwable $th) {
                    Log::error('[MailService::sendToPesertaAll] Gagal kirim ke peserta', [
                        'email' => $peserta->user->email,
                        'error' => $th->getMessage(),
                    ]);
                }
                sleep(1);
            }
            sleep(60);
        });

        return true;
    }
}
