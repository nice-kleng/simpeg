<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_product',
        'nama_product',
        'stock',
    ];

    public function getRouteKeyName()
    {
        return 'kd_product';
    }
}
