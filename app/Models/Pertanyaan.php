<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $fillable  = ['pertanyaan'];

    public function jadwalKunjungan()
    {
        return $this->belongsToMany(JadwalKunjungan::class, 'jawaban_mitras')
            ->withPivot('jawaban')
            ->withTimestamps();
    }
}
