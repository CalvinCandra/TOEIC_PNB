<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Soal extends Model
{
    use HasFactory;

    protected $table = 'soal';
    protected $primaryKey = 'id_soal';
    protected $fillable = [
        'soal',
        'jawaban_a',
        'jawaban_b',
        'jawaban_c',
        'jawaban_d',
        'kunci_jawaban',
        'id_suara',
        'id_gambar',
        'id_petugas',
    ];

    // relasi suara
    public function suara(): HasOne
    {
        return $this->hasOne(Suara::class, 'id_suara', 'id_suara');
    }
    
    // relasi gambar
    public function gambar(): HasOne
    {
        return $this->hasOne(Gambar::class, 'id_gambar', 'id_gambar');
    }

    // relasi petugas
    public function petugas(): HasOne
    {
        return $this->hasOne(Petugas::class, 'id_petugas', 'id_petugas');
    }

    // relasi pengerjaan
    public function pengerjaan(): BelongsTo
    {
        return $this->belongsTo(Pengerjaan::class, 'id_soal', 'id_soal');
    }
}
