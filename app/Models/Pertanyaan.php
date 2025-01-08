<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $fillable  = ['pertanyaan'];

    public function jadwal()
    {
        return $this->belongsTo(JadwalKunjungan::class);
    }
}
