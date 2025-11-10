<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Produk;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan semua seeder.
     */
    public function run(): void
    {
        // Buat 1 kategori dulu
        $kategori = Kategori::create([
            'nama' => 'Buku Bacaan',
            'deskripsi' => 'Kategori berisi berbagai jenis buku bacaan populer, edukatif, dan inspiratif.',
            'foto' => 'images/book.jpg.jpg',
        ]);

        // Daftar produk yang akan dimasukkan
        $produkData = [
            ['nama' => 'Laskar Pelangi', 'harga' => 85000, 'deskripsi' => 'Novel inspiratif karya Andrea Hirata yang menceritakan perjuangan anak-anak Belitung.', 'foto' => 'images/book.jpg'],
            ['nama' => 'Bumi Manusia', 'harga' => 95000, 'deskripsi' => 'Karya Pramoedya Ananta Toer yang mengisahkan perjuangan sosial dan cinta di masa kolonial.', 'foto' => 'images/book.jpg'],
            ['nama' => 'Dilan 1990', 'harga' => 70000, 'deskripsi' => 'Kisah remaja romantis Bandung yang ditulis oleh Pidi Baiq.', 'foto' => 'images/book.jpg'],
            ['nama' => 'Negeri 5 Menara', 'harga' => 80000, 'deskripsi' => 'Perjalanan inspiratif enam santri di pesantren dan perjuangan mereka meraih mimpi.', 'foto' => 'images/book.jpg'],
            ['nama' => 'Hujan', 'harga' => 90000, 'deskripsi' => 'Novel penuh makna karya Tere Liye yang menggambarkan kehilangan, cinta, dan bencana.', 'foto' => 'images/book.jpg'],
            ['nama' => 'Pulang', 'harga' => 88000, 'deskripsi' => 'Kisah perjalanan hidup seorang anak dalam dunia gelap hingga menemukan arti pulang.', 'foto' => 'images/book.jpg'],
            ['nama' => 'Critical Eleven', 'harga' => 99000, 'deskripsi' => 'Novel romantis yang mengeksplorasi cinta, kehilangan, dan proses penyembuhan.', 'foto' => 'images/book.jpg'],
            ['nama' => 'Rindu', 'harga' => 89000, 'deskripsi' => 'Karya Tere Liye tentang perjalanan spiritual jamaah haji di tengah konflik batin.', 'foto' => 'images/book.jpg'],
            ['nama' => 'Filosofi Teras', 'harga' => 75000, 'deskripsi' => 'Buku pengantar filsafat Stoikisme untuk menghadapi kehidupan modern.', 'foto' => 'images/book.jpg'],
            ['nama' => 'Atomic Habits', 'harga' => 120000, 'deskripsi' => 'Buku self-improvement karya James Clear tentang kebiasaan kecil yang berdampak besar.', 'foto' => 'images/book.jpg'],
        ];

        // Tambahkan produk-produk yang terhubung dengan kategori di atas
        foreach ($produkData as $produk) {
            Produk::create([
                'kategori_id' => $kategori->id,
                'nama' => $produk['nama'],
                'harga' => $produk['harga'],
                'deskripsi' => $produk['deskripsi'],
                'foto' => $produk['foto'],
            ]);
        }
    }
}
