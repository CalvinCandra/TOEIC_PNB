<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $fillable = [
        'kategori',
        'created_at',
        'update_at',
    ];

    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class, 'id_kategori', 'id_kategori');
    }
}
