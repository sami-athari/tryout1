<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'foto',
    ];

    // Relasi ke Buku
    public function bukus()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
