<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    use HasFactory;

    protected $table = 'kandidats';
    protected $fillable = ['nama_kandidat', 'nomor_urut', 'visi', 'misi', 'foto_kandidat'];
}
