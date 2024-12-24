<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUpMarketing extends Model
{
    use HasFactory;

    protected $fillable = ['marketing_id', 'status', 'keterangan', 'followup', 'tanggal'];

    public function getStatusAttribute()
    {
        $statusLabel = [
            '1' => 'Follow Up',
            '2' => 'Ditolak',
            '3' => 'Join'
        ];

        return $statusLabel[$this->attributes['status']] ?? 'Unknown';
    }

    public function marketing()
    {
        return $this->belongsTo(Marketing::class);
    }
}
