<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // bigIncrements / bigint unsigned
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('produk_id')->constrained('produks')->cascadeOnDelete();
            $table->tinyInteger('rating')->unsigned();
            $table->longText('komentar')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
            $table->index(['produk_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
