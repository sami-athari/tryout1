<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionItemsTable extends Migration
{
    public function up()
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('produk_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah');
            $table->decimal('harga', 15, 2); // harga satuan saat transaksi
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction_items');
    }
}
