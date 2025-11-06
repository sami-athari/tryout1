<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukTransactionCountSeeder extends Seeder
{
    public function run()
    {
        // If you have factories, you can use them; otherwise update existing produks.
        // This will set random transaction_count for existing produk rows.
        Produk::chunk(100, function ($produkBatch) {
            foreach ($produkBatch as $p) {
                $p->transaction_count = rand(0, 5000);
                $p->save();
            }
        });

        // Or create a few sample produk if none exist:
        if (Produk::count() === 0) {
            Produk::factory()->count(20)->create()->each(function ($p) {
                $p->transaction_count = rand(0, 5000);
                $p->save();
            });
        }
    }
}
