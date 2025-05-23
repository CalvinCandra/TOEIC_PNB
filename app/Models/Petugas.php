<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    protected $fillable = [
        'nama_petugas',
        'token',
        'id_users',
        'created_at',
        'update_at',
    ];

    // users
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_users');
    }
}
