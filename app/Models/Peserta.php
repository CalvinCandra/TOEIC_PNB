<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';
    protected $primaryKey = 'id_peserta';
    protected $fillable = [
        'nama_peserta',
        'nim',
        'token',
        'jurusan',
        'sesi',
        'status',
        'benar_listening',
        'benar_reading',
        'skor_listening',
        'skor_reading',
        'id_users',
        'created_at',
        'update_at',
    ];

    // users
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_users');
    }
}
