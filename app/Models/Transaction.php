<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [ 'user_id',
    'alamat',
    'telepon',
    'metode_pembayaran',
    'total',
    'status',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    // TransactionItem.php
public function produk() {
    return $this->belongsTo(Produk::class, 'produk_id');
}


    
}
