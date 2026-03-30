<?php

namespace App\Http\Controllers;

use App\Models\BankSoal;
use App\Models\JawabanPeserta;
use App\Models\Nilai;
use App\Models\Part;
use App\Models\Peserta;
use App\Models\Soal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class SoalController extends Controller
{
    // ============================================================================================= LISTENING
    // function menampikan aturan
    public function Listening(Request $request)
    {
        Log::info('[SoalController::Listening] Peserta masuk halaman aturan listening', [
            'id_users' => auth()->id(),
        ]);

        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        return view("peserta.Soal.ListeningAturan");
    }


    // function get data part untuk yang pertama
    public function GetListening(Request $request)
    {
        Log::info('[SoalController::GetListening] Peserta mulai listening', [
            'id_users' => auth()->id(),
            'bank'     => $request->session()->get('bank'),
        ]);

        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        // get data bank
        $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();

        if (!$getBank) {
            Log::warning('[SoalController::GetListening] Bank soal tidak ditemukan di session', [
                'id_users'     => auth()->id(),
                'bank_session' => $request->session()->get('bank'),
            ]);
            return redirect('/DashboardSoal');
        }

        // kirim dalam bentuk session
        $request->session()->put(
            'waktu_akhir',
            Carbon::today()->format('Y-m-d') . ' ' . $getBank->waktu_akhir
        );

        // get data soal berdasarkan kategori listening dan id_bank
        $PartListening = Part::where('kategori', 'Listening')->where('id_bank', $getBank->id_bank)->first();

        if (!$PartListening) {
            Log::warning('[SoalController::GetListening] Part listening tidak ditemukan', [
                'id_bank' => $getBank->id_bank,
            ]);
        }

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
            'status' => 'Kerjain'
        ]);

        Log::info('[SoalController::GetListening] Status peserta diubah ke Kerjain, redirect ke part pertama', [
            'id_peserta' => $peserta->id_peserta,
            'token_part' => $PartListening->token_part,
        ]);

        return redirect("/SoalListening" . "/" . $PartListening->token_part);
    }

    // function get data part berdasarkan nomor
    public function SoalListening(Request $request, $token)
    {
        Log::info('[SoalController::SoalListening] Menampilkan soal listening', [
            'id_users'   => auth()->id(),
            'token_part' => $token,
        ]);

        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        // get data bank
        $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();

        // get data part berdasarkan token
        $part = Part::with(['audio', 'gambar'])->where('kategori', 'Listening')->where('token_part', $token)->first();

        // get all data Part berdasarkan id_bank
        $GetAllPart = Part::where('kategori', 'Listening')->where('id_bank', $getBank->id_bank)->get();

        // berdasarkan token_soal dan bank soal
        $soalListening = Soal::with('audio', 'gambar')
            ->join('bank_soal', 'bank_soal.id_bank', '=', 'soal.id_bank')
            ->join('part', 'part.id_bank', '=', 'bank_soal.id_bank')
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
        Log::info('[SoalController::ProsesJawabListening] Memproses jawaban listening', [
            'id_users'    => auth()->id(),
            'id_part'     => $request->id_part,
            'tombol'      => $request->tombol,
            'jumlah_soal' => count($request->id_soal ?? []),
        ]);

        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        if ($request->ismethod('post')) {
            // get data bank
            $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();

            if (!$getBank) {
                Log::error('[SoalController::ProsesJawabListening] Bank soal tidak ditemukan', [
                    'id_users' => auth()->id(),
                ]);
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

            try {
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

                Log::info('[SoalController::ProsesJawabListening] Jawaban listening tersimpan', [
                    'id_peserta'  => $peserta->id_peserta,
                    'jumlah_soal' => count($request->id_soal ?? []),
                ]);
            } catch (\Throwable $th) {
                Log::error('[SoalController::ProsesJawabListening] Gagal simpan jawaban listening', [
                    'id_users' => auth()->id(),
                    'error'    => $th->getMessage(),
                    'file'     => $th->getFile(),
                    'line'     => $th->getLine(),
                ]);
            }

            if ($request->tombol == 'next') {

                // get data part berdasarkan id_part dan id_bank
                $part = Part::where('id_part', $request->id_part)->where('id_bank', $getBank->id_bank)->first();

                // memilih part selanjutnya
                $PartNext = Part::where('tanda', $part->tanda + 1)->where('kategori', 'Listening')->where('id_bank', $getBank->id_bank)->first();

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
        Log::info('[SoalController::GetNilaiListening] Menghitung nilai listening', [
            'id_users' => auth()->id(),
        ]);

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

        Log::info('[SoalController::GetNilaiListening] Skor listening dihitung', [
            'benar_listening' => $JumlahBenar,
            'skor_listening'  => $skorListening,
        ]);

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
        Log::info('[SoalController::Reading] Peserta masuk halaman aturan reading', [
            'id_users' => auth()->id(),
        ]);

        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        return view("peserta.Soal.ReadingAturan");
    }

    // get data soal untuk yang pertama
    public function GetReading(Request $request)
    {
        Log::info('[SoalController::GetReading] Peserta mulai reading', [
            'id_users' => auth()->id(),
            'bank'     => $request->session()->get('bank'),
        ]);

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


        if (!$getBank) {
            $request->session()->forget('bank');
            $request->session()->forget('waktu');
            $request->session()->forget('quizEndTime');
            Alert::error("Information", "Waktu habis atau token tidak valid. Jawaban tidak terkumpul.");
            return redirect('/DashboardSoal')->with('error', 'Waktu habis atau token tidak valid. Jawaban tidak terkumpul.');
        }

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
        Log::info('[SoalController::SoalReading] Menampilkan soal reading', [
            'id_users'   => auth()->id(),
            'token_part' => $token,
        ]);

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
        $part = Part::with(['audio', 'gambar', 'gambar1', 'gambar2'])->where('kategori', 'Reading')->where('token_part', $token)->first();

        // get all data Part berdasarkan id_bank
        $GetAllPart = Part::where('kategori', 'Reading')->where('id_bank', $getBank->id_bank)->get();

        // berdasarkan token_soal dan bank soal
        $soalReading = Soal::with('audio', 'gambar', 'gambar1', 'gambar2')
            ->join('bank_soal', 'bank_soal.id_bank', '=', 'soal.id_bank')
            ->join('part', 'part.id_bank', '=', 'bank_soal.id_bank')
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
        Log::info('[SoalController::ProsesJawabReading] Memproses jawaban reading', [
            'id_users'    => auth()->id(),
            'id_part'     => $request->id_part,
            'tombol'      => $request->tombol,
            'jumlah_soal' => count($request->id_soal ?? []),
        ]);

        // pengecekan session
        if ($request->session()->get('bank') == null) {
            return redirect('/DashboardSoal');
        }

        if ($request->ismethod('post')) {
            // get data bank
            $getBank = BankSoal::where('bank', $request->session()->get('bank'))->first();
            if (!$getBank) {
                Log::error('[SoalController::ProsesJawabReading] Bank soal tidak ditemukan', [
                    'id_users' => auth()->id(),
                ]);
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

            try {
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

                Log::info('[SoalController::ProsesJawabReading] Jawaban reading tersimpan', [
                    'id_peserta'  => $peserta->id_peserta,
                    'jumlah_soal' => count($request->id_soal ?? []),
                ]);
            } catch (\Throwable $th) {
                Log::error('[SoalController::ProsesJawabReading] Gagal simpan jawaban reading', [
                    'id_users' => auth()->id(),
                    'error'    => $th->getMessage(),
                    'file'     => $th->getFile(),
                    'line'     => $th->getLine(),
                ]);
            }

            if ($request->tombol == 'next') {

                // get data part berdasarkan id_part dan id_bank
                $part = Part::where('id_part', $request->id_part)->where('id_bank', $getBank->id_bank)->first();

                // memilih part selanjutnya
                $PartNext = Part::where('tanda', $part->tanda + 1)->where('kategori', 'Reading')->where('id_bank', $getBank->id_bank)->first();

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
        Log::info('[SoalController::GetNilaiReading] Menghitung nilai reading', [
            'id_users' => auth()->id(),
        ]);

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

        // ubah status peserta menjadi sudah selesai
        Peserta::where('id_peserta', $peserta->id_peserta)->update([
            'status' => 'Sudah'
        ]);

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

        Log::info('[SoalController::GetNilaiReading] Skor reading dihitung', [
            'benar_reading' => $JumlahBenar,
            'skor_reading'  => $skorReading,
        ]);

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
