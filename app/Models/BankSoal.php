<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankSoal extends Model
{
    use HasFactory;

    protected $table = 'bank_soal';
    protected $primaryKey = 'id_bank';
    protected $fillable = [
        'bank',
        'sesi_bank',
        'waktu_mulai',
        'waktu_akhir',
        'mode',
        'created_at',
        'updated_at',
    ];

    public function scopeForToeic($query)
    {
        return $query->where('mode', 'toeic');
    }

    public function scopeForSelfStudy($query)
    {
        return $query->where('mode', 'self_study');
    }

    public function selfStudyAttempts()
    {
        return $this->hasMany(\App\Models\SelfStudyAttempt::class, 'id_bank', 'id_bank');
    }

    public function soal(): HasMany
    {
        return $this->hasMany(Soal::class, 'id_bank', 'id_bank');
    }

    public function part(): HasMany
    {
        return $this->hasMany(Part::class, 'id_bank', 'id_bank');
    }
}
