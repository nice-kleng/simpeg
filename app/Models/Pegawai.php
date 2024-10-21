<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'akun_id',
        'jabatan_id',
        'nik',
        'nama',
        'wa',
        'ttl',
        'alamat',
        'jenkel',
        'foto',
    ];

    public function akun()
    {
        return $this->belongsTo(User::class, 'akun_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
