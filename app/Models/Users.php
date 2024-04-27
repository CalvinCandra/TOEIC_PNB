<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id_users';
    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    // relasi petugas
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'id_users', 'id_users');
    }

    // relasi peserta
    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class, 'id_users', 'id_users');
    }
}
