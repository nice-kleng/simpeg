<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TimelineInstagram extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_timelineig',
        'tanggal',
        'jenis_project',
        'status',
        'format',
        'jenis_konten',
        'produk',
        'head_term',
        'core_topic',
        'subtopic',
        'copywriting',
        'notes',
        'refrensi',
    ];

    public function getRouteKeyName()
    {
        return 'kd_timelineig';
    }

    // Tambahkan metode relasi berikut
    public function pics(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'timeline_instagram_user', 'timeline_instagram_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Get the report for the timeline Instagram.
     */
    public function report(): HasOne
    {
        return $this->hasOne(ReportTimelineInstagram::class, 'timeline_instagram_kd', 'kd_timelineig');
    }
}
