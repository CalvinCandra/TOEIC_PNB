<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'created_at',
        'update_at',
    ];

    // soal
    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class, 'id_petugas', 'id_petugas');
    }
}
