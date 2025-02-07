<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanMitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'jawaban',
        'pertanyaan_id',
        'jadwal_kunjungan_id',
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }

    public function jadwalKunjungan()
    {
        return $this->belongsTo(JadwalKunjungan::class);
    }
}
