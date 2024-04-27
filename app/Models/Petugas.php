<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    protected $fillable = [
        'nama_petugas',
        'id_users',
    ];

    // relasi soal
    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class, 'id_petugas', 'id_petugas');
    }

    // relasi users
    public function users(): HasOne
    {
        return $this->hasOne(Users::class, 'id_users', 'id_users');
    }
}
