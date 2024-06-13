<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\BankSoal;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    // Method untuk menampilkan form pembuatan soal
    public function create($id_bank)
    {
        $bankSoal = BankSoal::findOrFail($id_bank);
        return view('soal.create', compact('bankSoal'));
    }

    // Method untuk menyimpan soal baru
    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'id_bank' => 'required|exists:bank_soal,id_bank',
            // tambahkan validasi lainnya sesuai kebutuhan
        ]);

        Soal::create([
            'pertanyaan' => $request->pertanyaan,
            'id_bank' => $request->id_bank,
            // tambahkan field lainnya sesuai kebutuhan
        ]);

        return redirect()->route('banksoal.index')->with('success', 'Soal berhasil dibuat.');
    }

    // Method untuk menghapus soal
    public function destroy(Soal $soal)
    {
        $soal->delete();
        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }
}
