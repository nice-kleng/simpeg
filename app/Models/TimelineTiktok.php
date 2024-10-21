<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class TimelineTiktok extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_timeline_tiktok',
        'tanggal',
        'tipe_konten',
        'jenis_konten',
        'produk',
        'hook_konten',
        'copywriting',
        'jam_upload',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->kd_timeline_tiktok = self::generateKdTimelineTiktok();
        });
    }

    protected static function generateKdTimelineTiktok()
    {
        $prefix = 'TT' . date('Ymd');
        $latestNumber = self::where('kd_timeline_tiktok', 'like', $prefix . '%')
            ->max(DB::raw('CAST(SUBSTRING(kd_timeline_tiktok, -5) AS UNSIGNED)'));

        $newNumber = ($latestNumber ?? 0) + 1;
        $newKdTimelineTiktok = $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newKdTimelineTiktok;
    }


    public function getRouteKeyName()
    {
        return 'kd_timeline_tiktok';
    }

    public function pics(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'timeline_tik_tok_user', 'timeline_tiktok_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Get the report for the timeline TikTok.
     */
    public function report(): HasOne
    {
        return $this->hasOne(ReportTikTok::class, 'timeline_tiktok_kd', 'kd_timeline_tiktok');
    }
}
