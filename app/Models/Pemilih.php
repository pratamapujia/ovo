<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Kandidat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pemilih extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'voters';
    protected $fillable = ['nama_pemilih', 'nis', 'kelas_id', 'kandidat_id', 'token', 'status', 'password'];

    protected $hidden = [
        'token',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kandidat(): BelongsTo
    {
        return $this->belongsTo(Kandidat::class);
    }
}
