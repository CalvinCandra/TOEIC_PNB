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
    public function SendPetugas($id){
        $petugas = Petugas::with('user')->select('*')->where('id_petugas', $id)->first();
        $email = Mail::to($petugas->user['email'])->send(new SendMail($petugas));

        if($email){
            toast('Send Mail Successful!','success');
            return redirect()->back();
        }else{
            toast('Send Mail Error!','error');
            return redirect()->back();
        }
    }

    // Send Mailm Petugas Sekaligus
    public function SendPetugasAll(){
        $petugas = Petugas::with('user')->select('*')->get();
        
        foreach($petugas as $data){
            Mail::to($data->user['email'])->send(new SendMail($data));
        };
        
        toast('Send Mail Successful!','success');
        return redirect()->back();
    }

    // Send Mail Peserta persatu
    public function SendPeserta($id){
        $peserta = Peserta::with('user')->select('*')->where('id_peserta', $id)->first();
        Mail::to($peserta->user['email'])->send(new SendMail($peserta));
        
        toast('Send Mail Successful!','success');
        return redirect()->back();
    }

    // Send Mail Peserta Sekaligus
    public function SendPesertaAll(){
        $peserta = Peserta::with('user')->select('*')->get();
        
        foreach($peserta as $data){
            Mail::to($data->user['email'])->send(new SendMail($data));
        };
        
        toast('Send Mail Successful!','success');
        return redirect()->back();
    }
}
