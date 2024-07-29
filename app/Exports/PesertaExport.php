<?php

namespace App\Exports;

use App\Models\Peserta;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PesertaExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Peserta::join('users','users.id','=','peserta.id_users')
        ->select(
            'peserta.nama_peserta',
            'users.email',
            'peserta.nim',
            DB::raw("CASE WHEN peserta.kelamin = 'L' THEN 'Male' ELSE 'Female' END As kelamin"),
            'peserta.jurusan',
            'peserta.benar_listening',
            'peserta.skor_listening',
            'peserta.benar_reading',
            'peserta.skor_reading',
        )->get();
    }

    public function headings(): array
    {
        return ["Name", "Email", "NIM", "Gender", "Major", "Correct Listening", "Score Listening", "Correct Reading", "Score Reading"];
    }
}
