<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products'; // Menyatakan nama tabel yang terkait dengan model ini
    protected $fillable = ['name', 'price', 'stock']; // Kolom-kolom yang dapat diisi (fillable) oleh pengguna
}
