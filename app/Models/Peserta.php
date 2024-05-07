<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';
    protected $primaryKey = 'id_peserta';
    protected $fillable = [
        'nama_peserta',
        'kelamin',
        'jurusan',
        'id_users',
        'created_at',
        'update_at',
    ];

    // pengerjaan 
    public function pengerjaan(): BelongsTo
    {
        return $this->belongsTo(Pengerjaan::class, 'id_peserta', 'id_peserta');
    }
}
