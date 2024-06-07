<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';
    protected $primaryKey = 'id_status';
    protected $fillable = [
        'status_pengerjaan',
        'id_peserta',
        'created_at',
        'update_at',
    ];

    // peserta
    public function peserta(): HasOne
    {
        return $this->hasOne(Peserta::class, 'id_peserta', 'id_peserta');
    }
}
