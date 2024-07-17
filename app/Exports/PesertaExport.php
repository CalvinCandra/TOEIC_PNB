<?php

namespace App\Exports;

use App\Models\Peserta;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PesertaExport implements FromCollection, WithHeadings
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
            DB::raw("CASE WHEN peserta.kelamin = 'L' THEN 'Man' ELSE 'Female' END As kelamin"),
            'peserta.jurusan',
            'peserta.skor_listening',
            'peserta.skor_reading',
        )->get();
    }

    public function headings(): array
    {
        return ["Name", "Email", "NIM", "Gender", "Major", "Skor Listening", "Skor Reading"];
    }
}
