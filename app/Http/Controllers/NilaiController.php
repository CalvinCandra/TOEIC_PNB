<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Peserta;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    // function untuk penilaian
    public function Result(Request $request)
    {
        // Pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        $Readingbenar = $request->session()->get('benarReading');
        $Listeningbenar = $request->session()->get('benarListening');

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

        return view('result1', compact('peserta', 'skorReading', 'skorListening', 'totalSkor', 'kategori', 'rangeSkor', 'detail'));
    }

    // function untuk penentu kategori berdasarkan total skor
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
        }
    }
}
