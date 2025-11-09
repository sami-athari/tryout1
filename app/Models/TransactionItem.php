<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = ['transaction_id', 'produk_id', 'jumlah', 'harga'];

      public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function produk()
{
    return $this->belongsTo(\App\Models\Produk::class, 'produk_id');
}


     public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
