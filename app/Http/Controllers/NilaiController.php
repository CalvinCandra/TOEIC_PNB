<?php

namespace App\Http\Controllers;

use App\Services\Exam\NilaiService;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function __construct(protected NilaiService $nilaiService) {}

    public function Result(Request $request)
    {
        if (! $request->session()->get('bank')) {
            return redirect('/DashboardSoal');
        }

        if ($request->session()->has('result_generated')) {
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

        set_time_limit(0);

        $data = $this->nilaiService->generateResult(
            $request->session()->all(),
            auth()->id()
        );

        if (! $data) {
            return redirect('/DashboardSoal');
        }

        $request->session()->put('result_generated', true);
        foreach ($data as $key => $value) {
            $request->session()->put($key, $value);
        }

        return view('peserta.Result', $data);
    }
}