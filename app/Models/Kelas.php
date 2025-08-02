<?php

namespace App\Models;

use App\Models\Jurusan;
use App\Models\Pemilih;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['jurusan_id', 'nama_kelas'];
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function pemilih()
    {
        return $this->hasMany(Pemilih::class);
    }
}
