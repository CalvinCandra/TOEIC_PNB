<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Peserta;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    // Send Mail Petugas persatu
    public function SendPetugas($id)
    {
        $petugas = Petugas::with('user')->select('*')->where('id_petugas', $id)->first();
        $email = Mail::to($petugas->user['email'])->send(new SendMail($petugas));

        if ($email) {
            toast('Send Mail Successful!', 'success');
            return redirect()->back();
        } else {
            toast('Send Mail Error!', 'error');
            return redirect()->back();
        }
    }

    // Send Mailm Petugas Sekaligus
    public function SendPetugasAll()
    {
        set_time_limit(0); // Tidak ada batas waktu eksekusi

        // Tentukan ukuran batch
        $batchSize = 100;
        // Jeda antara batch dalam detik
        $delayBetweenBatches = 60; // 1 menit

        Petugas::with('user')->chunk($batchSize, function ($batch) use ($delayBetweenBatches) {
            foreach ($batch as $data) {
                // Kirim email menggunakan queue
                Mail::to($data->user['email'])->send(new SendMail($data));
                sleep(1);
            }
            // Jeda antar batch
            sleep($delayBetweenBatches);
        });

        toast('Send Mail Successful!', 'success');
        return redirect()->back();
    }

    // Send Mail Peserta persatu
    public function SendPeserta($id)
    {
        $peserta = Peserta::with('user')->select('*')->where('id_peserta', $id)->first();
        Mail::to($peserta->user['email'])->send(new SendMail($peserta));

        toast('Send Mail Successful!', 'success');
        return redirect()->back();
    }

    // Send Mail Peserta Sekaligus
    public function SendPesertaAll($sesi)
    {
        set_time_limit(0); // Tidak ada batas waktu eksekusi

        // Tentukan ukuran batch
        $batchSize = 100;
        // Jeda antara batch dalam detik
        $delayBetweenBatches = 60; // 1 menit

        if ($sesi == 'Sesione') {
            Peserta::with('user')->where('sesi', 'Session 1')->chunk($batchSize, function ($batch) use ($delayBetweenBatches) {
                foreach ($batch as $data) {
                    // Kirim email menggunakan queue
                    Mail::to($data->user['email'])->send(new SendMail($data));
                    sleep(1);
                }
                // Jeda antar batch
                sleep($delayBetweenBatches);
            });

            toast('Send Mail Successful!', 'success');
            return redirect()->back();
        } elseif ($sesi == 'Sesitwo') {
            Peserta::with('user')->where('sesi', 'Session 2')->chunk($batchSize, function ($batch) use ($delayBetweenBatches) {
                foreach ($batch as $data) {
                    // Kirim email menggunakan queue
                    Mail::to($data->user['email'])->send(new SendMail($data));
                    sleep(1);
                }
                // Jeda antar batch
                sleep($delayBetweenBatches);
            });
        } elseif ($sesi == 'Sesithree') {
            Peserta::with('user')->where('sesi', 'Session 3')->chunk($batchSize, function ($batch) use ($delayBetweenBatches) {
                foreach ($batch as $data) {
                    // Kirim email menggunakan queue
                    Mail::to($data->user['email'])->send(new SendMail($data));
                    sleep(1);
                }
                // Jeda antar batch
                sleep($delayBetweenBatches);
            });
        } elseif ($sesi == 'Sesifour') {
            Peserta::with('user')->where('sesi', 'Session 4')->chunk($batchSize, function ($batch) use ($delayBetweenBatches) {
                foreach ($batch as $data) {
                    // Kirim email menggunakan queue
                    Mail::to($data->user['email'])->send(new SendMail($data));
                    sleep(1);
                }
                // Jeda antar batch
                sleep($delayBetweenBatches);
            });
        } else {
            toast('Session Valid', 'error');
            return redirect()->back();
        }

        toast('Send Mail Successful!', 'success');
        return redirect()->back();
    }
}
