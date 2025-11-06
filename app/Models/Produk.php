<?php

// app/Models/Produk.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'harga', 'stok', 'foto', 'kategori_id', 'deskripsi', 'transaction_count'];

    protected $casts = [
        'harga' => 'integer',
        'stok' => 'integer',
        'transaction_count' => 'integer',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relationship example: Produk hasMany TransactionItems (adjust names to your schema)
    public function transactionItems()
    {
        return $this->hasMany(\App\Models\TransactionItem::class, 'produk_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Hitung rata-rata rating
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // Hitung total ulasan
    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    // Contoh jumlah terjual (kalau kamu punya kolom “terjual” di DB)
    public function getSoldCountAttribute()
    {
        return $this->attributes['terjual'] ?? rand(100, 800); // fallback sementara
    }
}

