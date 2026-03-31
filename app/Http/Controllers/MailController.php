<?php

namespace App\Http\Controllers;

use App\Services\Mail\MailService;

class MailController extends Controller
{
    public function __construct(protected MailService $mailService) {}

    public function SendPetugas(int $id)
    {
        $this->mailService->sendToPetugas($id)
            ? toast('Send Mail Successful!', 'success')
            : toast('Send Mail Error!', 'error');

        return redirect()->back();
    }

    public function SendPetugasAll()
    {
        $this->mailService->sendToPetugasAll();
        toast('Send Mail Successful!', 'success');

        return redirect()->back();
    }

    public function SendPeserta(int $id)
    {
        $this->mailService->sendToPeserta($id)
            ? toast('Send Mail Successful!', 'success')
            : toast('Send Mail Error!', 'error');

        return redirect()->back();
    }

    public function SendPesertaAll(string $sesi)
    {
        $result = $this->mailService->sendToPesertaAll($sesi);
        $result
            ? toast('Send Mail Successful!', 'success')
            : toast('Session tidak valid!', 'error');

        return redirect()->back();
    }
}
