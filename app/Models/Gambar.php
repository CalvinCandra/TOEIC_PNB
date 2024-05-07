<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gambar extends Model
{
    use HasFactory;

    protected $table = 'gambar';
    protected $primaryKey = 'id_gambar';
    protected $fillable = [
        'gambar',
        'created_at',
        'update_at',
    ];

    // soal
    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class, 'id_gambar', 'id_gambar');
    }
}
