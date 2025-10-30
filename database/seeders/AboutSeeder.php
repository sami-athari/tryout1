<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('abouts')->insert([
            [
                'title' => 'Tentang Kami',
                'description' => 'Di era digital yang serba cepat ini, kami percaya bahwa membaca bukan hanya sekadar hobi atau cara untuk mengisi waktu luang — melainkan bagian penting dari gaya hidup modern yang penuh makna. Membaca membantu kita berpikir lebih luas, memahami dunia lebih dalam, dan menumbuhkan empati terhadap sesama. Karena itu, Seilmu hadir bukan hanya sebagai tempat untuk mencari buku, tetapi sebagai ruang untuk menumbuhkan kecintaan pada pengetahuan.

Kami berkomitmen untuk menghadirkan buku dalam format yang praktis, nyaman, dan selalu relevan dengan perkembangan zaman. Dengan desain yang bersih dan pengalaman pengguna yang intuitif, Seilmu memungkinkan siapa pun untuk menikmati bacaan di mana saja dan kapan saja, tanpa batasan ruang maupun waktu.

Koleksi kami mencakup berbagai kategori — mulai dari buku pelajaran yang menunjang pendidikan, novel inspiratif yang menggugah emosi, hingga bacaan populer yang ringan namun penuh wawasan. Kami ingin memastikan setiap pembaca, baik pelajar, mahasiswa, maupun profesional, dapat menemukan sesuatu yang sesuai dengan minat dan kebutuhannya.

Lebih dari sekadar platform, Seilmu adalah gerakan kecil untuk menjaga budaya membaca di tengah derasnya arus digital. Kami percaya, kemajuan teknologi seharusnya tidak menjauhkan kita dari buku, melainkan membawa kita lebih dekat kepada ilmu dan inspirasi. Dengan setiap halaman yang kamu buka, kamu sedang melangkah menuju versi terbaik dari dirimu — karena ilmu tidak hanya untuk diketahui, tapi juga untuk dihidupi.',
                'mission' => 'Misi kami sederhana namun bermakna: menyediakan akses literasi yang inklusif bagi semua orang. Kami berkomitmen untuk menghadirkan sumber daya digital berkualitas, memperluas jangkauan bacaan, serta mendukung kegiatan belajar mandiri. Kami ingin membangun ekosistem pembelajaran yang dinamis dan kolaboratif, di mana setiap pengguna dapat menemukan inspirasi, memperluas wawasan, dan mengembangkan diri mereka sesuai dengan minat dan passion yang dimiliki.',
                'why' => 'Kami percaya bahwa membaca adalah investasi terbaik bagi masa depan. Melalui buku, seseorang dapat menjelajahi dunia tanpa harus beranjak dari tempat duduknya. Namun sayangnya, masih banyak orang yang kesulitan mengakses bacaan karena keterbatasan waktu, jarak, atau biaya. Karena itulah kami hadir — untuk menjembatani kesenjangan tersebut dengan menghadirkan platform yang mudah diakses, modern, dan penuh manfaat. Kami ingin setiap pengguna merasakan bahwa membaca bukan lagi kewajiban, melainkan pengalaman yang menyenangkan dan bermakna.',
                'tagline' => 'Buka Halaman, Buka Wawasan. Temukan Pengetahuan Tanpa Batas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
