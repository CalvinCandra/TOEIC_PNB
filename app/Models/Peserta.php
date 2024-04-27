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
        'jenis_kelamin',
        'alamat',
        'id_users',
    ];

    // relasi users
    public function users(): HasOne
    {
        return $this->hasOne(Users::class, 'id_users', 'id_users');
    }

    // relasi pengerjaan
    public function pengerjaan(): BelongsTo
    {
        return $this->belongsTo(Pengerjaan::class, 'id_peserta', 'id_peserta');
    }
}
