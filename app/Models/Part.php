<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Part extends Model
{
    use HasFactory;

    protected $table = 'part';
    protected $primaryKey = 'id_part';
    protected $fillable = [
        'part',
        'petunjuk',
        'multi_user',
        'dari_nomor',
        'sampai_nomor',
        'kategori',
        'token_part',
        'tanda',
        'id_bank',
        'id_gambar',
        'id_audio',
        'created_at',
        'updated_at',
    ];

     public function bank(): BelongsTo
    {
        return $this->belongsTo(BankSoal::class, 'id_bank', 'id_bank');
    }

    public function gambar(): BelongsTo
    {
        return $this->belongsTo(Gambar::class, 'id_gambar', 'id_gambar');
    }

    public function gambar1(): HasOne
    {
        return $this->hasOne(Gambar::class, 'id_gambar', 'id_gambar');
    }

    public function gambar2(): HasOne
    {
        return $this->hasOne(Gambar::class, 'id_gambar', 'id_gambar');
    }

    public function audio(): BelongsTo
    {
        return $this->belongsTo(Audio::class, 'id_audio', 'id_audio');
    }
}
