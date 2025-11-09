<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'alamat',
        'telepon',
        'metode_pembayaran',
        'total',
        'status',
        'shipping_note',
    ];



    public function user()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}

    public function items()
{
    return $this->hasMany(\App\Models\TransactionItem::class, 'transaction_id');
}

    // TransactionItem.php
public function produk() {
    return $this->belongsTo(Produk::class, 'produk_id');
}



}
