<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumberMarketing extends Model
{
    use HasFactory;

    protected $fillable = ['nama_sumber_marketing', 'label'];

    public function marketings()
    {
        return $this->hasMany(Marketing::class);
    }
}
