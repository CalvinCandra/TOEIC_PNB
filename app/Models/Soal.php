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
        'id_gambar',
        'id_audio',
        'id_petugas',
        'created_at',
        'update_at',
    ];

    // petugas
    public function petugas(): HasOne
    {
        return $this->hasOne(Petugas::class, 'id_petugas', 'id_petugas');
    }

    // gambar
    public function gambar(): HasOne
    {
        return $this->hasOne(Gambar::class, 'id_gambar', 'id_gambar');
    }

    // audio
    public function audio(): HasOne
    {
        return $this->hasOne(Audio::class, 'id_audio', 'id_audio');
    }

    // bank
    public function bank(): HasOne
    {
        return $this->hasOne(BankSoal::class, 'id_bank', 'id_bank');
    }

    // kategori
    public function kategori(): HasOne
    {
        return $this->hasOne(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
