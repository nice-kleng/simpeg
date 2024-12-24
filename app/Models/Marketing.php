<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    use HasFactory;

    protected $fillable = ['sumber_marketing_id', 'nama', 'maps', 'rating', 'alamat', 'no_hp', 'brand', 'label', 'tanggal', 'status_prospek', 'akun_id'];

    public function getRatingAttribute()
    {
        $ratingLabel = [
            '0' => 'Not Rated',
            '1' => 'Minat & Mampu',
            '2' => 'Minat Tidak Mampu',
            '3' => 'Tidak Minat Mampu',
            '4' => 'Tidak Minat Tidak Mampu'
        ];

        return $ratingLabel[$this->attributes['rating']] ?? 'Unknown';
    }

    public function sumberMarketing()
    {
        return $this->belongsTo(SumberMarketing::class);
    }

    public function pics()
    {
        return $this->belongsToMany(User::class, 'marketing_users', 'marketing_id', 'user_id');
    }

    public function picSign()
    {
        return $this->belongsToMany(User::class, 'follow_up_marketuser', 'marketing_id', 'user_id');
    }

    public function followUp()
    {
        return $this->hasMany(FollowUpMarketing::class);
    }
}
