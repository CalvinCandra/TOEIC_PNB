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
        if ($totalSkor >= 945 && $totalSkor <= 990) {
            return ['kategori' => 'Proficient user - Effective Operational Proficiency C1', 'range' => '945 - 990', 'detail' => 'Can understand a wide range of demanding, longer texts, and recognise implicit meaning. Can express him/ herself fluently and spontaneously without much obvious searching for expressions. Can use language flexibly and effectively for social, academic and professional purposes. Can produce clear, well-structured, detailed text on complex subjects, showing controlled use of organisational patterns, connectors and cohesive devices.'];
        } elseif ($totalSkor >= 785 && $totalSkor <= 940) {
            return ['kategori' => 'Independent user - Vantage B2', 'range' => '785 - 940', 'detail' => 'Can understand the main ideas of complex text on both concrete and abstract topics, including technical discussions in his/her field of specialisation. Can interact with a degree of fluency and spontaneity that makes regular interaction with native speakers quite possible without strain for either party. Can produce clear, detailed text on a wide range of subjects and explain a viewpoint on a topical issue giving the advantages and disadvantages of various options.'];
        } elseif ($totalSkor >= 550 && $totalSkor <= 780) {
            return ['kategori' => 'Independent user - Threshold B1', 'range' => '550 - 780', 'detail' => 'Can understand the main points of clear standard input on familiar matters regularly encountered in work, school, leisure, etc. Can deal with most situations likely to arise whilst travelling in an area where the language is spoken. Can produce simple connected text on topics which are familiar or of personal interest. Can describe experiences and events, dreams, hopes and ambitions and briefly give reasons and explanations for opinions and plans.'];
        } elseif ($totalSkor >= 225 && $totalSkor <= 545) {
            return ['kategori' => 'Basic user - Waystage A2', 'range' => '225 - 545', 'detail' => 'Can understand sentences and frequently used expressions related to areas of most immediate relevance (e.g. very basic personal and family information, shopping, local geography, employment). Can communicate in simple and routine tasks requiring a simple and direct exchange of information on familiar and routine matters. Can describe in simple terms aspects of his/her background, immediate environment and matters in areas of immediate need.'];
        } elseif ($totalSkor >= 0 && $totalSkor <= 220) {
            return ['kategori' => 'Basic user - Breakthrough A1', 'range' => '0 - 220', 'detail' => 'Can understand and use familiar everyday expressions and very basic phrases aimed at the satisfaction of needs of a concrete type. Can introduce him/herself and others and can ask and answer questions about personal details such as where he/she lives, people he/she knows and things he/she has. Can interact in a simple way provided the other person talks slowly and clearly and is prepared to help.'];
        }
    }
}
