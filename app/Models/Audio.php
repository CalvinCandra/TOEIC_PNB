<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Audio extends Model
{
    use HasFactory;

    protected $table = 'audio';
    protected $primaryKey = 'id_audio';
    protected $fillable = [
        'audio',
        'created_at',
        'update_at',
    ];

    // soal
    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class, 'id_audio', 'id_audio');
    }
    
    // part
    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class, 'id_audio', 'id_audio');
    }
}
