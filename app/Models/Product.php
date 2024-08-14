<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan konvensi Laravel
    protected $table = 'products';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'foto',
        'price',
        'stock',
        'status',
        'category',
    ];
}
