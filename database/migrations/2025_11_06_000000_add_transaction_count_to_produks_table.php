<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionCountToProduksTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('produks') && ! Schema::hasColumn('produks', 'transaction_count')) {
            Schema::table('produks', function (Blueprint $table) {
                $table->unsignedInteger('transaction_count')->default(0)->after('stok');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('produks') && Schema::hasColumn('produks', 'transaction_count')) {
            Schema::table('produks', function (Blueprint $table) {
                $table->dropColumn('transaction_count');
            });
        }
    }
}
