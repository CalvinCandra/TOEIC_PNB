<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SelfStudyAttempt extends Model
{
    use HasFactory;

    protected $table = 'self_study_attempts';
    protected $primaryKey = 'id_attempt';
    protected $fillable = [
        'id_peserta', 'id_bank', 'id_part', 'attempt_number',
        'jumlah_benar', 'jumlah_salah', 'skor', 'durasi_detik',
    ];

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', 'id_peserta');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(BankSoal::class, 'id_bank', 'id_bank');
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class, 'id_part', 'id_part');
    }
}
