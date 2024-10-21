<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'status_mitra',
        'kota_wilayah',
        'fb',
        'ig',
        'marketplace',
        'no_hp',
        'upline',
        'bulan',
        'note_1',
        'note_2',
        'tanggal',
    ];

    public function upline()
    {
        return $this->belongsTo(Mitra::class, 'upline', 'id');
    }

    public function downline()
    {
        return $this->hasMany(Mitra::class, 'upline', 'id');
    }
}
