<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengerjaan extends Model
{
    use HasFactory;

    protected $table = 'pengerjaan';
    protected $primaryKey = 'id_pengerjaan';
    protected $fillable = [
        'nilai',
        'id_peserta',
        'id_soal',
    ];

    // relasi peserta
    public function peserta(): HasOne
    {
        return $this->hasOne(Peserta::class, 'id_peserta', 'id_peserta');
    }
    
    // relasi soal
    public function soal(): HasOne
    {
        return $this->hasOne(Soal::class, 'id_soal', 'id_soal');
    }
}
