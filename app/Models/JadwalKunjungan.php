<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKunjungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_id',
        'tanggal',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function pic()
    {
        return $this->belongsToMany(User::class, 'jadwal_kunjungan_pic', 'jadwal_kunjungan_id', 'pic_id');
    }

    public function pertanyaan()
    {
        return $this->belongsToMany(Pertanyaan::class, 'jawaban_mitras')
            ->withPivot('jawaban')
            ->withTimestamps();
    }

    public function jawabanMitra()
    {
        return $this->hasMany(JawabanMitra::class);
    }
}
