<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Peserta;
use App\Mail\ResultMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class NilaiController extends Controller
{
    // Function untuk penilaian
    public function Result(Request $request)
    {
        // Pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        // Cek apakah email sudah dikirim di sesi ini
        if ($request->session()->has('email_sent')) {
            return view('peserta.Result', [
                'peserta' => $request->session()->get('peserta'),
                'skorReading' => $request->session()->get('skorReading'),
                'skorListening' => $request->session()->get('skorListening'),
                'totalSkor' => $request->session()->get('totalSkor'),
                'kategori' => $request->session()->get('kategori'),
                'rangeSkor' => $request->session()->get('rangeSkor'),
                'detail' => $request->session()->get('detail'),
            ]);
        }

        $Readingbenar = $request->session()->get('benarReading');
        $Readingsalah = $request->session()->get('salahReading');
        $Listeningbenar = $request->session()->get('benarListening');
        $Listeningsalah = $request->session()->get('salahListening');

        // Mencocokkan nilai benar dengan skala nilai di database
        $nilaiReading = Nilai::where('jawaban_benar', $Readingbenar)->first();
        $nilaiListening = Nilai::where('jawaban_benar', $Listeningbenar)->first();

        // Jika tidak ditemukan, default skor ke 0
        $skorReading = $nilaiReading ? $nilaiReading->skor_reading : 0;
        $skorListening = $nilaiListening ? $nilaiListening->skor_listening : 0;

        // Menghitung total skor
        $totalSkor = $skorReading + $skorListening;

        // Menentukan kategori berdasarkan total skor
        $result = $this->determineCategory($totalSkor);
        $kategori = $result['kategori'];
        $rangeSkor = $result['range'];
        $detail = $result['detail'];

        $peserta = Peserta::with('user')->where('id_users', auth()->user()->id)->first();

        // Generate PDF
        $pdf = PDF::loadView('vendor.pdf.result', [
            'nama_peserta' => $peserta->nama_peserta,
            'email' => $peserta->user->email,
            'nim' => $peserta->nim,
            'jurusan' => $peserta->jurusan,
            'skorReading' => $skorReading,
            'benarReading' => $Readingbenar,
            'salahReading' => $Readingsalah,
            'skorListening' => $skorListening,
            'benarListening' => $Listeningbenar,
            'salahListening' => $Listeningsalah,
            'totalSkor' => $totalSkor,
            'kategori' => $kategori,
            'rangeSkor' => $rangeSkor,
            'detail' => $detail,
        ])->setPaper('a4', 'portrait')
        ->setOption('isRemoteEnabled', true);

        $pdfPath = storage_path('app/public/') . 'Result_' . $peserta->nim . '_' . Str::random(5) . '.pdf';
        $pdf->save($pdfPath);

        // Mengirimkan email hasil tes
        Mail::to($peserta->user->email)->send(new ResultMail(
            $peserta->nama_peserta,
            $peserta->user->email,
            $peserta->nim,
            $peserta->jurusan,
            $skorReading,
            $skorListening,
            $totalSkor,
            $kategori,
            $rangeSkor,
            $pdfPath
        ));

        // Simpan data ke dalam session
        $request->session()->put('email_sent', true);
        $request->session()->put('peserta', $peserta);
        $request->session()->put('skorReading', $skorReading);
        $request->session()->put('skorListening', $skorListening);
        $request->session()->put('totalSkor', $totalSkor);
        $request->session()->put('kategori', $kategori);
        $request->session()->put('rangeSkor', $rangeSkor);
        $request->session()->put('detail', $detail);

        return view('peserta.Result', compact('peserta', 'skorReading', 'skorListening', 'totalSkor', 'kategori', 'rangeSkor', 'detail'));
    }

    // Function untuk penentu kategori berdasarkan total skor
    private function determineCategory($totalSkor)
    {
        if ($totalSkor >= 905 && $totalSkor <= 990) {
            return ['kategori' => 'International Proficiency', 'range' => '905-990', 'detail' => 'This range of values indicates that the individual has a very high ability to speak English. They are able to communicate smoothly and effectively in a variety of professional and academic contexts. People in this category can easily understand complex texts, follow quick conversations, and express themselves clearly and persuasively. They can interact with native and non-native English speakers with confidence, using extensive vocabulary and complex sentence structure.'];
        } elseif ($totalSkor >= 785 && $totalSkor <= 900) {
            return ['kategori' => 'Working Proficiency Plus', 'range' => '785-900', 'detail' => 'This range of values indicates excellent English proficiency for professional needs. Individuals in this category are able to communicate smoothly in various work and daily life situations. They can understand relatively complex texts, follow in-depth discussions, and convey ideas clearly and organizedly. They may still require a little adaptation to interact in very formal or technical situations, but generally they can perform English tasks well.'];
        } elseif ($totalSkor >= 605 && $totalSkor <= 780) {
            return ['kategori' => 'Limited Working Proficiency', 'range' => '605-780', 'detail' => 'This range of values reflects an adequate English language proficiency for basic work situations. People with values in this category may be able to communicate in everyday contexts and may be capable of completing simple tasks using English. They can understand clear instructions and participate in not too complex conversations, although they may have difficulty with more technical material or in-depth discussions.'];
        } elseif ($totalSkor >= 405 && $totalSkor <= 600) {
            return ['kategori' => 'Elementary Proficiency Plus', 'range' => '405-600', 'detail' => 'This range of values indicates basic English skills. Individuals with values here may have a basic understanding of the English structure and commonly used vocabulary. They can understand simple texts and communicate in limited contexts, such as talking about everyday topics or routine work tasks. They may need extra time to process more complex information or to express ideas clearly.'];
        } elseif ($totalSkor >= 255 && $totalSkor <= 400) {
            return ['kategori' => 'Elementary Proficiency', 'range' => '255-400', 'detail' => 'This range of values reflects very limited English skills. Individuals with values here may be able to understand simple sentences and participate in very limited conversations. They may be able to perform basic tasks such as filling out forms or delivering very general information, but they will have difficulty understanding longer or more complex texts.'];
        } elseif ($totalSkor >= 185 && $totalSkor <= 250) {
            return ['kategori' => 'Memorised Proficiency', 'range' => '185-250', 'detail' => 'This range of values indicates that individuals have very limited ability in English. They may only be able to remember and repeat information that is already known with very limited. They can understand a few simple sentences and may communicate in very limited contexts, but their English language skills are significantly limited.'];
        } elseif ($totalSkor >= 10 && $totalSkor <= 180) {
            return ['kategori' => 'No Useful Proficiency', 'range' => '10-180', 'detail' => 'This range of values indicates that individuals do not have a useful ability in English for practical purposes. They may not be able to understand or communicate in English in a useful context. People with values here may have only basic knowledge or no knowledge of English at all.'];
        } elseif ($totalSkor < 10) {
            return ['kategori' => 'No Proficiency', 'range' => '5-0', 'detail' => 'This score range indicates that individuals have no practical proficiency in English. They may not be able to understand or communicate in English at all. People with scores in this range may have no knowledge of English or have not yet started learning it.'];
        }
    }
}
