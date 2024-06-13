<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankSoal;
use App\Models\User;
use App\Models\Peserta;
use App\Models\Soal;
use App\Models\Gambar;
use App\Models\Audio;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class BankSoalController extends Controller
{
    public function index()
    {
        $data = BankSoal::all(); // Ambil semua data dari tabel bank_soal
        return view('petugas.content.petugassoal', compact('data')); // Kirim data ke view
    }

    public function create(Request $request)
    {
        $latestBankSoal = BankSoal::orderBy('id_bank', 'desc')->first();
        $newId = $latestBankSoal ? $latestBankSoal->id_bank + 1 : 1;
        $newBankName = 'Bank Soal ' . $newId;

        $bankSoal = new BankSoal();
        $bankSoal->bank = $newBankName;
        $bankSoal->save();

        return response()->json([
            'id' => $bankSoal->id_bank,
            'bank' => $bankSoal->bank,
        ]);
    }
}


