<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'akun_id');
    }

    public function timelineInstagrams(): BelongsToMany
    {
        return $this->belongsToMany(TimelineInstagram::class, 'timeline_instagram_user', 'user_id', 'timeline_instagram_id')
            ->withTimestamps();
    }

    public function timelineTikToks(): BelongsToMany
    {
        return $this->belongsToMany(TimelineTiktok::class, 'timeline_tik_tok_user', 'user_id', 'timeline_tiktok_id')
            ->withTimestamps();
    }

    public function reportTikTokLives(): BelongsToMany
    {
        return $this->belongsToMany(ReportTikTokLive::class, 'report_tik_tok_live_user', 'user_id', 'report_tiktok_live_id')->withTimestamps();
    }
}
