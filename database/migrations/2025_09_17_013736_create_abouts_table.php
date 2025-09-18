<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
    $table->id();
    $table->string('title')->nullable();
    $table->longText('description')->nullable();
    $table->longText('mission')->nullable();
    $table->longText('why')->nullable();
    $table->longText('tagline')->nullable();
    $table->string('image')->nullable();
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('abouts');
    }
};
