<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportTikTok extends Model
{
    use HasFactory;

    protected $fillable = [
        'timeline_tiktok_kd',
        'views',
        'like',
        'comment',
        'share',
        'save',
        'usia_18_24',
        'usia_25_34',
        'usia_35_44',
        'usia_45_54',
        'gender_pria',
        'gender_wanita',
        'total_pemutaran',
        'rata_menonton',
        'view_utuh',
        'pengikut_baru',
        'link_konten',
    ];

    public function timeline(): BelongsTo
    {
        return $this->belongsTo(TimelineTiktok::class, 'timeline_tiktok_kd', 'kd_timeline_tiktok');
    }
}
