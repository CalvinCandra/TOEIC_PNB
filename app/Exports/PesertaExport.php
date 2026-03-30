<?php

namespace App\Exports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PesertaExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $sesi;

    // Terima parameter sesi dari controller
    public function __construct($sesi = null)
    {
        $this->sesi = $sesi;
    }

    public function collection()
    {
        $query = Peserta::join('users', 'users.id', '=', 'peserta.id_users')
            ->select(
                'peserta.nama_peserta',
                'users.email',
                'peserta.nim',
                'peserta.jurusan',
                'peserta.sesi',
                'peserta.benar_listening',
                'peserta.skor_listening',
                'peserta.benar_reading',
                'peserta.skor_reading',
            );

        // Jika ada filter sesi, tambahkan kondisi WHERE
        if (!empty($this->sesi)) {
            if($this->sesi == 'Sesione'){
                $query->where('peserta.sesi', 'Session 1');
            }elseif($this->sesi == 'Sesitwo'){
                $query->where('peserta.sesi', 'Session 2');
            }
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ["Name", "Email", "NIM", "Major", "Session", "Correct Listening", "Score Listening", "Correct Reading", "Score Reading"];
    }
}
