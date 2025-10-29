<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produkData = [
            [
                'kategori_id' => 1,
                'nama' => 'Keyboard Mechanical RGB',
                'harga' => 550000,
                'deskripsi' => 'Keyboard mechanical dengan lampu RGB dan switch blue clicky.',
                'foto' => 'keyboard_rgb.jpg',
            ],
            [
                'kategori_id' => 1,
                'nama' => 'Mouse Wireless Logitech M331',
                'harga' => 250000,
                'deskripsi' => 'Mouse wireless dengan desain ergonomis dan daya tahan baterai hingga 12 bulan.',
                'foto' => 'mouse_wireless.jpg',
            ],
            [
                'kategori_id' => 2,
                'nama' => 'Headset Gaming Rexus HX20',
                'harga' => 375000,
                'deskripsi' => 'Headset gaming dengan bass kuat dan mikrofon fleksibel.',
                'foto' => 'headset_rexus.jpg',
            ],
            [
                'kategori_id' => 2,
                'nama' => 'Monitor Samsung 24 Inch',
                'harga' => 1450000,
                'deskripsi' => 'Monitor LED full HD 24 inch dengan refresh rate 75Hz.',
                'foto' => 'monitor_samsung.jpg',
            ],
            [
                'kategori_id' => 3,
                'nama' => 'Flashdisk Sandisk 64GB',
                'harga' => 120000,
                'deskripsi' => 'Flashdisk USB 3.0 cepat dan aman.',
                'foto' => 'flashdisk_sandisk.jpg',
            ],
            [
                'kategori_id' => 3,
                'nama' => 'Harddisk Eksternal Seagate 1TB',
                'harga' => 780000,
                'deskripsi' => 'Penyimpanan eksternal berkapasitas besar dan kecepatan tinggi.',
                'foto' => 'hdd_seagate.jpg',
            ],
            [
                'kategori_id' => 4,
                'nama' => 'Laptop Asus VivoBook 14',
                'harga' => 6850000,
                'deskripsi' => 'Laptop ringan dengan prosesor Intel i3 dan RAM 8GB.',
                'foto' => 'laptop_asus.jpg',
            ],
            [
                'kategori_id' => 4,
                'nama' => 'Laptop Acer Aspire 5',
                'harga' => 7250000,
                'deskripsi' => 'Laptop dengan performa tangguh dan desain modern.',
                'foto' => 'laptop_acer.jpg',
            ],
            [
                'kategori_id' => 5,
                'nama' => 'Kabel HDMI 2 Meter',
                'harga' => 50000,
                'deskripsi' => 'Kabel HDMI berkualitas tinggi dengan panjang 2 meter.',
                'foto' => 'kabel_hdmi.jpg',
            ],
            [
                'kategori_id' => 5,
                'nama' => 'Adaptor Charger Laptop Universal',
                'harga' => 95000,
                'deskripsi' => 'Adaptor universal untuk berbagai tipe laptop.',
                'foto' => 'adaptor_laptop.jpg',
            ],
            [
                'kategori_id' => 1,
                'nama' => 'Keyboard Wireless Logitech K380',
                'harga' => 465000,
                'deskripsi' => 'Keyboard portable dengan konektivitas Bluetooth.',
                'foto' => 'keyboard_logitech.jpg',
            ],
            [
                'kategori_id' => 2,
                'nama' => 'Speaker Bluetooth JBL GO 3',
                'harga' => 700000,
                'deskripsi' => 'Speaker mini dengan suara jernih dan tahan air.',
                'foto' => 'jbl_go3.jpg',
            ],
            [
                'kategori_id' => 3,
                'nama' => 'MicroSD 128GB Samsung EVO Plus',
                'harga' => 180000,
                'deskripsi' => 'MicroSD cepat untuk smartphone dan kamera.',
                'foto' => 'microsd_samsung.jpg',
            ],
            [
                'kategori_id' => 4,
                'nama' => 'Laptop Lenovo ThinkPad E14',
                'harga' => 9500000,
                'deskripsi' => 'Laptop bisnis tangguh dengan build quality premium.',
                'foto' => 'lenovo_e14.jpg',
            ],
            [
                'kategori_id' => 2,
                'nama' => 'Headphone Sony WH-CH520',
                'harga' => 899000,
                'deskripsi' => 'Headphone wireless dengan daya tahan baterai hingga 50 jam.',
                'foto' => 'sony_headphone.jpg',
            ],
            [
                'kategori_id' => 3,
                'nama' => 'Powerbank Anker 20000mAh',
                'harga' => 499000,
                'deskripsi' => 'Powerbank besar dengan fast charging 18W.',
                'foto' => 'powerbank_anker.jpg',
            ],
            [
                'kategori_id' => 5,
                'nama' => 'Cooling Pad Laptop Deepcool N200',
                'harga' => 155000,
                'deskripsi' => 'Pendingin laptop dengan kipas besar dan lampu biru.',
                'foto' => 'coolingpad.jpg',
            ],
            [
                'kategori_id' => 1,
                'nama' => 'Mousepad XXL Gaming Edition',
                'harga' => 65000,
                'deskripsi' => 'Permukaan halus dan ukuran besar untuk gamer.',
                'foto' => 'mousepad_xxl.jpg',
            ],
            [
                'kategori_id' => 4,
                'nama' => 'Laptop HP Pavilion 15',
                'harga' => 8350000,
                'deskripsi' => 'Laptop multimedia dengan performa solid dan layar jernih.',
                'foto' => 'hp_pavilion.jpg',
            ],
            [
                'kategori_id' => 2,
                'nama' => 'Webcam Logitech C270',
                'harga' => 325000,
                'deskripsi' => 'Webcam HD 720p cocok untuk meeting online.',
                'foto' => 'webcam_logitech.jpg',
            ],
        ];

        foreach ($produkData as $data) {
            Produk::create($data);
        }
    }
}
