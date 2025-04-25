<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Part;
use App\Models\Soal;
use App\Models\Nilai;
use App\Models\Peserta;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use App\Models\JawabanPeserta;
use App\Http\Controllers\SoalController;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class SoalController extends Controller
{
    // ============================================================================================= LISTENING
    // function menampikan aturan
    public function Listening(Request $request)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        return view("peserta.Soal.ListeningAturan");
    }

    // function get data part untuk yang pertama
    public function GetListening(Request $request)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        // get data bank
        $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();

        // kirim dalam bentuk session
        $request->session()->put(
            'waktu_akhir',
            Carbon::today()->format('Y-m-d') . ' ' . $getBank->waktu_akhir
        );

        // get data soal berdasarkan kategori listening dan id_bank
        $PartListening = Part::where('kategori', 'Listening')->where('id_bank', $getBank->id_bank)->first();

        // set waktu awal quiz menggunakan Carbon
        $quizStartTime = Carbon::now();
        // (m * d * md)
        $quizEndTime = $quizStartTime->copy()->addMilliseconds(45 * 60 * 1000); // Menambahkan 45 menit ke waktu awal dengan milliseconds

        // kirim dalam bentuk session
        $request->session()->put('quizEndTime', $quizEndTime);

        // get data peserta
        $peserta = Peserta::where('id_users', auth()->user()->id)->first();

        // ubah status peserta menjadi sudah selesai
        Peserta::where('id_peserta', $peserta->id_peserta)->update([
            'status' => 'Sudah'
        ]);

        return redirect("/SoalListening" . "/" . $PartListening->token_part);
    }

    // function get data part berdasarkan nomor
    public function SoalListening(Request $request, $token)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        // get data bank
        $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();

        // get data part berdasarkan token
        $part = Part::with(['audio','gambar'])->where('kategori', 'Listening')->where('token_part', $token)->first();

        // get all data Part berdasarkan id_bank
        $GetAllPart = Part::where('kategori', 'Listening')->where('id_bank', $getBank->id_bank)->get();

        // berdasarkan token_soal dan bank soal
        $soalListening = Soal::with('audio','gambar')
            ->join('bank_soal', 'bank_soal.id_bank' ,'=', 'soal.id_bank')
            ->join('part', 'part.id_bank' ,'=', 'bank_soal.id_bank')
            ->where('part.kategori', 'Listening')
            ->where('soal.kategori', 'Listening')
            ->where('part.token_part', $token)
            ->where('part.id_bank', $getBank->id_bank)
            ->whereBetween('soal.nomor_soal', [$part->dari_nomor, $part->sampai_nomor])
            ->select('soal.*')
            ->get();

        // Periksa apakah waktu sudah habis menggunakan Carbon
        $currentTime = Carbon::now(); // get waktu sekarang
        $quizEndTime = $request->session()->get('quizEndTime'); // ambil waktu akhir, yang dikirim sebelumnya
        $remainingTime = $currentTime->diffInSeconds($quizEndTime); // hitung selisih

        // kirim waktu ke blade agar bisa dikondisikan
        $request->session()->put('waktu', $remainingTime);

        return view('peserta.Soal.Listeningtest', compact(['soalListening', 'part', 'GetAllPart']));
    }

    // proses menjawab untuk listening
    public function ProsesJawabListening(Request $request)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        if ($request->ismethod('post')) {
            // get data bank
            $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();
		
        if (!$getBank) {
            $request->session()->forget('bank');
            $request->session()->forget('waktu');
            $request->session()->forget('quizEndTime');
            Alert::error("Information", "Waktu habis atau token tidak valid. Jawaban tidak terkumpul.");

            return redirect('/DashboardSoal')->with('error', 'Waktu habis atau token tidak valid. Jawaban tidak terkumpul.');
        }

            // get data peserta
            $peserta = Peserta::where('id_users', auth()->user()->id)->first();
            $user = $peserta->id_peserta;

            // get id_soal pada form
            $idSoal = $request->id_soal;

            // get jawaban peserta
            $jawaban = $request->jawaban;

            foreach ($request->id_soal as $idSoal) {
                // get jawaban user
                $jawaban = $request->jawaban[$idSoal] ?? 'N'; // jika tidak menjawab
    
                // insert data kedalam database
                JawabanPeserta::create([
                    'id_peserta' => $user,
                    'id_soal' => $idSoal,
                    'jawaban' => $jawaban,
                ]);
            }

            if ($request->tombol == 'next') {

                // get data part berdasarkan id_part dan id_bank
                $part = Part::where('id_part', $request->id_part)->where('id_bank', $getBank->id_bank)->first();

                // memilih part selanjutnya
                $PartNext = Part::where('tanda', $part->tanda+1)->where('kategori', 'Listening')->where('id_bank', $getBank->id_bank)->first();

                return redirect("/SoalListening" . "/" . $PartNext->token_part);
            } else {
                //hapus ession waktu sebelumnya
                $request->session()->forget('waktu');
                $request->session()->forget('quizEndTime');

                return redirect()->route('nilaiListening');
            }
        }
    }

    public function GetNilaiListening(Request $request)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        // get data bank
        $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();
	
        if (!$getBank) {
            $request->session()->forget('bank');
            $request->session()->forget('waktu');
            $request->session()->forget('quizEndTime');
            Alert::error("Information", "Waktu habis atau token tidak valid. Jawaban tidak terkumpul.");
            return redirect('/DashboardSoal')->with('error', 'Waktu habis atau token tidak valid. Jawaban tidak terkumpul.');
        }


        // get data peserta
        $peserta = Peserta::where('id_users', auth()->user()->id)->first();

        // mengambil data jawaban yang diinput berdasarkan id_peserta, kategori soal, dan bank soal
        $getJawaban = JawabanPeserta::join('soal', 'soal.id_soal', '=', 'jawaban_peserta.id_soal')
            ->join('peserta', 'peserta.id_peserta', '=', 'jawaban_peserta.id_peserta')
            ->where('soal.kategori', 'Listening')
            ->where('peserta.id_peserta', $peserta->id_peserta)
            ->where('soal.id_bank', $getBank->id_bank)
            ->get();

        // get data soal berdasarkan kategori dan bank soal
        $soalListening = Soal::where('kategori', 'Listening')
            ->where('id_bank', $getBank->id_bank)
            ->get();

        // variabel buat nilai
        $Benar = 0;
        $Salah = 0;

        // ngecek jawaban
        foreach ($soalListening as $soal) {
            foreach ($getJawaban as $userJawaban) {
                if ($soal->id_soal == $userJawaban->id_soal) {
                    if ($soal->kunci_jawaban === $userJawaban->jawaban) {
                        $Benar++;
                    } else {
                        $Salah++;
                    }
                }
            }
        }

        $JumlahBenar = $Benar;
        $Jumlahsalah = $Salah;

        // Mencocokkan nilai benar dengan skala nilai di database
        $nilaiListening = Nilai::where('jawaban_benar', $JumlahBenar)->first();

        // Jika tidak ditemukan, default skor ke 0
        $skorListening = $nilaiListening ? $nilaiListening->skor_listening : 0;

        // update database
        $peserta->update([
            'benar_listening' => $JumlahBenar,
            'skor_listening' => $skorListening,
        ]);

        // menghapus data sebelumnya di database
        JawabanPeserta::where('id_peserta', $peserta->id_peserta)->delete();
        
        // put data listening
        $request->session()->put('benarListening', $JumlahBenar);
        $request->session()->put('salahListening', $Jumlahsalah);

        //hapus session waktu sebelumnya
        $request->session()->forget('waktu');
        $request->session()->forget('quizEndTime');

        return redirect('/Reading');
    }

    // =========================================================================================== READING
    // menampikan aturan
    public function Reading(Request $request)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        return view("peserta.Soal.ReadingAturan");
    }

    // get data soal untuk yang pertama
    public function GetReading(Request $request)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        // get data bank
        $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();
        if (!$getBank) {
            $request->session()->forget('bank');
            $request->session()->forget('waktu');
            $request->session()->forget('quizEndTime');
            Alert::error("Information", "Waktu habis atau token tidak valid. Jawaban tidak terkumpul.");
            return redirect('/DashboardSoal')->with('error', 'Waktu habis atau token tidak valid. Jawaban tidak terkumpul.');
        }

         // kirim dalam bentuk session
         $request->session()->put(
            'waktu_akhir',
            Carbon::today()->format('Y-m-d') . ' ' . $getBank->waktu_akhir
        );


        // get data soal berdasarkan kategori listening dan id_bank
        $PartListening = Part::where('kategori', 'Reading')->where('id_bank', $getBank->id_bank)->first();

        // set waktu awal quiz menggunakan Carbon
        $quizStartTime = Carbon::now();
        //(m * d * md)
        $quizEndTime = $quizStartTime->copy()->addMilliseconds(75 * 60 * 1000); // Menambahkan 75 menit ke waktu awal dengan milliseconds

        // kirim dalam bentuk session
        $request->session()->put('quizEndTime', $quizEndTime);

        return redirect("/SoalReading" . "/" . $PartListening->token_part);
    }

    // get data soal berdasarkan nomor
    public function SoalReading(Request $request, $token)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        // get data bank
        $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();
        if (!$getBank) {
            $request->session()->forget('bank');
            $request->session()->forget('waktu');
            $request->session()->forget('quizEndTime');
            Alert::error("Information", "Waktu habis atau token tidak valid. Jawaban tidak terkumpul.");
            return redirect('/DashboardSoal')->with('error', 'Waktu habis atau token tidak valid. Jawaban tidak terkumpul.');
        }


        // get data part berdasarkan token
        $part = Part::with(['audio','gambar'])->where('kategori', 'Reading')->where('token_part', $token)->first();

        // get all data Part berdasarkan id_bank
        $GetAllPart = Part::where('kategori', 'Reading')->where('id_bank', $getBank->id_bank)->get();

        // berdasarkan token_soal dan bank soal
        $soalReading = Soal::with('audio','gambar')
            ->join('bank_soal', 'bank_soal.id_bank' ,'=', 'soal.id_bank')
            ->join('part', 'part.id_bank' ,'=', 'bank_soal.id_bank')
            ->where('part.kategori', 'Reading')
            ->where('soal.kategori', 'Reading')
            ->where('part.token_part', $token)
            ->where('part.id_bank', $getBank->id_bank)
            ->whereBetween('soal.nomor_soal', [$part->dari_nomor, $part->sampai_nomor])
            ->select('soal.*')
            ->get();

        // Periksa apakah waktu sudah habis menggunakan Carbon
        $currentTime = Carbon::now(); // get waktu sekarang
        $quizEndTime = $request->session()->get('quizEndTime'); // ambil waktu akhir, yang dikirim sebelumnya
        $remainingTime = $currentTime->diffInSeconds($quizEndTime); // hitung selisih

        // kirim waktu ke blade agar bisa dikondisikan
        $request->session()->put('waktu', $remainingTime);

        return view('peserta.Soal.Readingtest', compact(['soalReading', 'part', 'GetAllPart']));
    }

    // proses menjawab untuk reading
    public function ProsesJawabReading(Request $request)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        if ($request->ismethod('post')) {
            // get data bank
            $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();
	    if (!$getBank) {
            		$request->session()->forget('bank');
            		$request->session()->forget('waktu');
            		$request->session()->forget('quizEndTime');
	    	Alert::error("Information", "Waktu habis atau token tidak valid. Jawaban tidak terkumpul.");
           	 return redirect('/DashboardSoal')->with('error', 'Waktu habis atau token tidak valid. Jawaban tidak terkumpul.');
        	}


            // get data peserta
            $peserta = Peserta::where('id_users', auth()->user()->id)->first();
            $user = $peserta->id_peserta;

            // get id_soal pada form
            $idSoal = $request->id_soal;

            // get jawaban peserta
            $jawaban = $request->jawaban;

            foreach ($request->id_soal as $idSoal) {
                // get jawaban user
                $jawaban = $request->jawaban[$idSoal] ?? 'N'; // jika tidak menjawab
    
                // insert data kedalam database
                JawabanPeserta::create([
                    'id_peserta' => $user,
                    'id_soal' => $idSoal,
                    'jawaban' => $jawaban,
                ]);
            }

            if ($request->tombol == 'next') {
                
                // get data part berdasarkan id_part dan id_bank
                $part = Part::where('id_part', $request->id_part)->where('id_bank', $getBank->id_bank)->first();

                // memilih part selanjutnya
                $PartNext = Part::where('tanda', $part->tanda+1)->where('kategori', 'Reading')->where('id_bank', $getBank->id_bank)->first();

                return redirect("/SoalReading" . "/" . $PartNext->token_part);
            } else {
                //hapus ession waktu sebelumnya
                $request->session()->forget('waktu');
                $request->session()->forget('quizEndTime');
                
                return redirect()->route('nilaiReading');
            }
        }
    }

    public function GetNilaiReading(Request $request)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        // get data bank
        $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();
	if (!$getBank) {
            		$request->session()->forget('bank');
            		$request->session()->forget('waktu');
            		$request->session()->forget('quizEndTime');
	    	Alert::error("Information", "Waktu habis atau token tidak valid. Jawaban tidak terkumpul.");
           	 return redirect('/DashboardSoal')->with('error', 'Waktu habis atau token tidak valid. Jawaban tidak terkumpul.');
        	}


        // get data peserta
        $peserta = Peserta::where('id_users', auth()->user()->id)->first();

        // mengambil data jawaban yang diinput berdasarkan id_peserta, kategori soal
        $getJawaban = JawabanPeserta::where('id_peserta', $peserta->id_peserta)->get();

        // get data soal berdasarkan kategori dan bank soal
        $soalReading = Soal::where('kategori', 'Reading')
            ->where('id_bank', $getBank->id_bank)
            ->get();

        // variabel buat nilai
        $Benar = 0;
        $Salah = 0;

        foreach ($soalReading as $soal) {
            foreach ($getJawaban as $userJawaban) {
                if ($soal->id_soal == $userJawaban->id_soal) {
                    if ($soal->kunci_jawaban === $userJawaban->jawaban) {
                        $Benar++;
                    } else {
                        $Salah++;
                    }
                }
            }
        }

        $JumlahBenar = $Benar;
        $Jumlahsalah = $Salah;

        // Mencocokkan nilai benar dengan skala nilai di database
        $nilaiReading = Nilai::where('jawaban_benar', $JumlahBenar)->first();

        // Jika tidak ditemukan, default skor ke 0
        $skorReading = $nilaiReading ? $nilaiReading->skor_reading : 0;

        // update database
        $peserta->update([
            'benar_reading' => $JumlahBenar,
            'skor_reading' => $skorReading,
        ]);

        // menghapus data sebelumnya di database
        JawabanPeserta::where('id_peserta', $peserta->id_peserta)->delete();

        // kirim nilai dalam bentuk session
        $request->session()->put('benarReading', $JumlahBenar);
        $request->session()->put('salahReading', $Jumlahsalah);

        //hapus ession waktu sebelumnya
        $request->session()->forget('waktu');
        $request->session()->forget('quizEndTime');

        return redirect('/Result');
    }

    // penghancur session
    public function destory(Request $request)
    {
        $request->session()->forget('benarReading');
        $request->session()->forget('salahReading');
        $request->session()->forget('benarListening');
        $request->session()->forget('salahListening');
        $request->session()->forget('bank');
        $request->session()->forget('email_sent');
        $request->session()->forget('email_sent');
        $request->session()->forget('quizEndTime');
        return redirect('/DashboardSoal');
    }

    
}
