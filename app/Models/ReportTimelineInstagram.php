<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportTimelineInstagram extends Model
{
    use HasFactory;
    protected $fillable = [
        'timeline_instagram_kd',
        'jangkauan',
        'interaksi',
        'aktivitas',
        'impresi',
        'like',
        'comment',
        'share',
        'save',
        'pengikut',
        'bukan_pengikut',
        // 'pengikut_baru',
        'profile',
        'beranda',
        'jelajahi',
        'lainnya',
        'tagar',
        'jumlah_pemutaran',
        'waktu_tonton',
        'rata',
        'link_konten',
    ];
    /**
     * Get the timeline Instagram associated with the report.
     */
    public function timelineInstagram(): BelongsTo
    {
        return $this->belongsTo(TimelineInstagram::class, 'timeline_instagram_kd', 'kd_timelineig');
    }
}
