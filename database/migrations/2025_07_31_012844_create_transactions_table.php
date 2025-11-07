<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('alamat');
            $table->string('telepon', 15);
            $table->string('metode_pembayaran');
            $table->decimal('total', 15, 2)->default(0);
            $table->enum('status', ['pending', 'dikirim', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('shipping_note')->nullable(); // ✅ WAJIB nullable
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
