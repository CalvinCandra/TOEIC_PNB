<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Suara extends Model
{
    use HasFactory;

    protected $table = 'suara';
    protected $primaryKey = 'id_suara   ';
    protected $fillable = [
        'suara',
    ];

    // relasi soal
    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class, 'id_suara', 'id_suara');
    }


}
