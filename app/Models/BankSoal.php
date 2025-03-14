<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankSoal extends Model
{
    use HasFactory;

    protected $table = 'bank_soal';
    protected $primaryKey = 'id_bank';
    protected $fillable = [
        'bank',
        'sesi_bank',
        'created_at',
        'updated_at',
    ];

    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class, 'id_bank', 'id_bank');
    }

     // part
     public function part(): BelongsTo
     {
         return $this->belongsTo(Part::class, 'id_bank', 'id_bank');
     }
}
