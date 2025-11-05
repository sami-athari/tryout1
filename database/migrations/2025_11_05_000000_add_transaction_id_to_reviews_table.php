<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionIdToReviewsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('reviews') && ! Schema::hasColumn('reviews', 'transaction_id')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->unsignedBigInteger('transaction_id')->nullable()->after('produk_id');
                // add index for faster lookups
                $table->index('transaction_id');
                // if you have transactions table, add FK (nullable so migration won't fail if transactions table absent)
                if (Schema::hasTable('transactions')) {
                    $table->foreign('transaction_id')
                          ->references('id')
                          ->on('transactions')
                          ->onDelete('cascade');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('reviews') && Schema::hasColumn('reviews', 'transaction_id')) {
            Schema::table('reviews', function (Blueprint $table) {
                // drop foreign key if exists
                if (Schema::hasTable('transactions')) {
                    $sm = Schema::getConnection()->getDoctrineSchemaManager();
                    $doctrineTable = $sm->listTableDetails($table->getTable());
                    if ($doctrineTable->hasForeignKey('reviews_transaction_id_foreign')) {
                        $table->dropForeign('reviews_transaction_id_foreign');
                    }
                }
                $table->dropIndex(['transaction_id']);
                $table->dropColumn('transaction_id');
            });
        }
    }
}
