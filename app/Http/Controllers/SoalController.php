<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Soal;
use App\Models\Status;
use App\Models\Peserta;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use App\Models\JawabanPeserta;
use App\Http\Controllers\SoalController;
use Illuminate\Support\Facades\Redirect;

class SoalController extends Controller
{
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

        // get data soal berdasarkan kategori reading dan bank soal
        $soalReading = Soal::where('kategori', 'Reading')->where('id_bank', $getBank->id_bank)->first();

        // set waktu awal quiz menggunakan Carbon
        $quizStartTime = Carbon::now();
        $quizEndTime = $quizStartTime->copy()->addMilliseconds(60 * 60 * 1000); // Menambahkan 60 menit ke waktu awal dengan milliseconds

        // kirim dalam bentuk session
        $request->session()->put('quizEndTime', $quizEndTime);

        return redirect("/SoalReading" . "/" . $soalReading->token_soal);
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

        // berdasarkan nomor_soal dan bank soal
        $soalReading = Soal::where('kategori', 'Reading')
            ->where('token_soal', $token)
            ->where('id_bank', $getBank->id_bank)
            ->first();

        // get data soal keseluruhan berdasarkan kategori dan id_bank
        $soal = Soal::where('kategori', 'Reading')->where('id_bank', $getBank->id_bank)->get();

        // Periksa apakah waktu sudah habis menggunakan Carbon
        $currentTime = Carbon::now(); // get waktu sekarang
        $quizEndTime = $request->session()->get('quizEndTime'); // ambil waktu akhir, yang dikirim sebelumnya
        $remainingTime = $currentTime->diffInSeconds($quizEndTime); // hitung selisih

        // kirim waktu ke blade agar bisa dikondisikan
        $request->session()->put('waktu', $remainingTime);

        return view('peserta.Soal.Readingtest', compact(['soalReading', 'soal']));
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

            // get data peserta
            $peserta = Peserta::where('id_users', auth()->user()->id)->first();
            $user = $peserta->id_peserta;

            // get id_soal pada form
            $idSoal = $request->id_soal;

            // get jawaban peserta
            $jawaban = $request->jawaban;

            if ($request->tombol == 'next') {
                // insert data kedalam database
                JawabanPeserta::create([
                    'id_peserta' => $user,
                    'id_soal' => $idSoal,
                    'jawaban' => $jawaban,
                ]);

                // get data soal berdasarkan id_soal dan id_bank
                $soal = Soal::where('id_soal', $idSoal)->where('id_bank', $getBank->id_bank)->first();
                // memilih soal selanjutnya
                $soalReading = Soal::where('nomor_soal', $soal->nomor_soal + 1)->where('kategori', 'Reading')->where('id_bank', $getBank->id_bank)->first();

                return redirect("/SoalReading" . "/" . $soalReading->token_soal);
            } else {
                // insert data kedalam database
                JawabanPeserta::create([
                    'id_peserta' => $user,
                    'id_soal' => $idSoal,
                    'jawaban' => $jawaban,
                ]);

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

        // menghapus data sebelumnya di database
        JawabanPeserta::where('id_peserta', $peserta->id_peserta)->delete();

        // kirim nilai dalam bentuk session
        $request->session()->put('benarReading', $JumlahBenar);
        $request->session()->put('salahReading', $Jumlahsalah);

        //hapus ession waktu sebelumnya
        $request->session()->forget('waktu');
        $request->session()->forget('quizEndTime');

        return redirect('/Listening');
    }

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

    // function get data soal untuk yang pertama
    public function GetListening(Request $request)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        // get data bank
        $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();

        // get data soal berdasarkan kategori listening dan id_bank
        $soalListening = Soal::with('audio')->where('kategori', 'Listening')->where('id_bank', $getBank->id_bank)->first();

        // set waktu awal quiz menggunakan Carbon
        $quizStartTime = Carbon::now();
        $quizEndTime = $quizStartTime->copy()->addMilliseconds(60 * 60 * 1000); // Menambahkan 60 menit ke waktu awal dengan milliseconds

        // kirim dalam bentuk session
        $request->session()->put('quizEndTime', $quizEndTime);

        return redirect("/SoalListening" . "/" . $soalListening->token_soal);
    }

    // function get data soal berdasarkan nomor
    public function SoalListening(Request $request, $token)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        // get data bank
        $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();

        // berdasarkan token_soal dan bank soal
        $soalListening = Soal::with('audio')
            ->where('kategori', 'Listening')
            ->where('token_soal', $token)
            ->where('id_bank', $getBank->id_bank)
            ->first();


        // get data soal berdasarkan kategori listening dan id_bank
        $soal = Soal::with('audio')->where('kategori', 'Listening')->where('id_bank', $getBank->id_bank)->get();

        // Periksa apakah waktu sudah habis menggunakan Carbon
        $currentTime = Carbon::now(); // get waktu sekarang
        $quizEndTime = $request->session()->get('quizEndTime'); // ambil waktu akhir, yang dikirim sebelumnya
        $remainingTime = $currentTime->diffInSeconds($quizEndTime); // hitung selisih

        // kirim waktu ke blade agar bisa dikondisikan
        $request->session()->put('waktu', $remainingTime);

        return view('peserta.Soal.Listeningtest', compact(['soalListening', 'soal']));
    }

    // proses menjawab untuk reading
    public function ProsesJawabListening(Request $request)
    {
        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        if ($request->ismethod('post')) {
            // get data bank
            $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();

            // get data peserta
            $peserta = Peserta::where('id_users', auth()->user()->id)->first();
            $user = $peserta->id_peserta;

            // get id_soal pada form
            $idSoal = $request->id_soal;

            // get jawaban peserta
            $jawaban = $request->jawaban;

            if ($request->tombol == 'next') {
                // insert data kedalam database
                JawabanPeserta::create([
                    'id_peserta' => $user,
                    'id_soal' => $idSoal,
                    'jawaban' => $jawaban,
                ]);


                // get data soal berdasarkan id_soal dan id_bank
                $soal = Soal::where('id_soal', $idSoal)->where('id_bank', $getBank->id_bank)->first();
                // memilih soal selanjutnya
                $soalListening = Soal::where('nomor_soal', $soal->nomor_soal + 1)->where('kategori', 'Listening')->where('id_bank', $getBank->id_bank)->first();

                return redirect("/SoalListening" . "/" . $soalListening->token_soal);
            } else {
                // insert data kedalam database
                JawabanPeserta::create([
                    'id_peserta' => $user,
                    'id_soal' => $idSoal,
                    'jawaban' => $jawaban,
                ]);

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

        // put data listening
        $request->session()->put('benarListening', $JumlahBenar);
        $request->session()->put('salahListening', $Jumlahsalah);

        // put again data reading
        $request->session()->put('benarReading', $request->session()->get('benarReading'));
        $request->session()->put('salahReading', $request->session()->get('salahReading'));

        // ubah status peserta menjadi sudah selesai
        Status::where('id_peserta', $peserta->id_peserta)->update([
            'status_pengerjaan' => 'Sudah'
        ]);

        // menghapus data sebelumnya di database
        JawabanPeserta::where('id_peserta', $peserta->id_peserta)->delete();
        //hapus ession waktu sebelumnya
        $request->session()->forget('waktu');
        $request->session()->forget('quizEndTime');


        return redirect('/Result');
    }

    // function testing penilaian
    // public function Result(Request $request){
    //     // pengecekan session
    //     if($request->session()->get('bank') == null){
    //         return redirect('/DashboardSoal');
    //     }

    //     $Readingbenar = $request->session()->get('benarReading');
    //     $Readingsalah = $request->session()->get('salahReading');
    //     $Listeningbenar = $request->session()->get('benarListening');
    //     $Listeningsalah = $request->session()->get('salahListening');
    //     return view('peserta.Result', compact(['Readingbenar', 'Readingsalah', 'Listeningbenar', 'Listeningsalah']));
    // }

    // penghancur session
    public function destory(Request $request)
    {
        $request->session()->forget('benarReading');
        $request->session()->forget('salahReading');
        $request->session()->forget('benarListening');
        $request->session()->forget('salahListening');
        $request->session()->forget('bank');
        $request->session()->forget('email_sent');
        return redirect('/DashboardSoal');
    }
}
