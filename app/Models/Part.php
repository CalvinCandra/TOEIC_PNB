<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

     // bank
     public function bank(): HasOne
     {
         return $this->hasOne(BankSoal::class, 'id_bank', 'id_bank');
     }

     // gambar
     public function gambar(): HasOne
     {
         return $this->hasOne(Gambar::class, 'id_gambar', 'id_gambar');
     }

     // gambar
     public function gambar1(): HasOne
     {
         return $this->hasOne(Gambar::class, 'id_gambar', 'id_gambar_1');
     }

     // gambar
     public function gambar2(): HasOne
     {
         return $this->hasOne(Gambar::class, 'id_gambar', 'id_gambar_2');
     }

     // audio
     public function audio(): HasOne
     {
         return $this->hasOne(Audio::class, 'id_audio', 'id_audio');
     }
}
