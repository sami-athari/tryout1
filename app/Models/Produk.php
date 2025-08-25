<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi
    protected $fillable = [
        'kategori_id',
        'nama',
        'harga',
        'stok',
        'deskripsi',
        'foto',
    ];

    // Relasi ke kategori
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function transactionItems()
{
    return $this->hasMany(TransactionItem::class,'produk_id');
}
}
