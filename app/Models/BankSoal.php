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
        'created_at',
        'updated_at',
    ];

    public function soal(): HasMany
    {
        return $this->hasMany(Soal::class, 'id_bank', 'id_bank');
    }

    public function part(): HasMany
    {
        return $this->hasMany(Part::class, 'id_bank', 'id_bank');
    }
}
