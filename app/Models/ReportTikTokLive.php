<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTikTokLive extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_report_tiktok_live',
        'tanggal',
        'judul',
        'waktu_mulai',
        'durasi',
        'total_tayangan',
        'penonton_unik',
        'rata_menonton',
        'jumlah_penonton_teratas',
        'pengikut',
        'penonton_lainnya',
        'pengikut_baru',
        'penonton_berkomentar',
        'suka',
        'berbagi',
    ];

    public function getRouteKeyName()
    {
        return 'kd_report_tiktok_live';
    }

    public function pics()
    {
        return $this->belongsToMany(User::class, 'report_tik_tok_live_user', 'report_tiktok_live_id', 'user_id')->withTimestamps();
    }
}
