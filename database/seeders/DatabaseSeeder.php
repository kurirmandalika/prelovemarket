<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Preloved Market',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $seller = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Wahyu Andhyka',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        $buyer = User::updateOrCreate(
            ['email' => 'buyer@example.com'],
            [
                'name' => 'Nadia Pembeli',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        SellerProfile::updateOrCreate(
            ['user_id' => $seller->id],
            [
                'shop_name' => 'Wahyu Thrift Corner',
                'slug' => 'wahyu-thrift-corner',
                'phone' => '081234567890',
                'address' => 'Jl. Sudirman No. 12, Jakarta Selatan',
                'description' => 'Koleksi preloved terkurasi, bersih, dan siap pakai.',
            ]
        );

        $categories = collect([
            'Pakaian',
            'Perabotan',
            'Elektronik',
            'Buku',
            'Sepatu',
            'Aksesoris',
            'Mainan',
            'Perlengkapan Bayi',
        ])->mapWithKeys(function (string $name) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );

            return [$name => $category];
        });

        $products = collect([
            [
                'category' => 'Pakaian',
                'title' => 'Jaket Denim Oversize',
                'slug' => 'jaket-denim-oversize',
                'description' => 'Jaket denim preloved warna biru medium, bahan tebal, jahitan masih rapi, cocok untuk gaya kasual harian.',
                'price' => 185000,
                'condition' => 'like_new',
                'location' => 'Jakarta Selatan',
            ],
            [
                'category' => 'Perabotan',
                'title' => 'Meja Kopi Minimalis Kayu',
                'slug' => 'meja-kopi-minimalis-kayu',
                'description' => 'Meja kopi ukuran compact dengan permukaan kayu solid. Ada sedikit bekas pemakaian normal di bagian kaki.',
                'price' => 275000,
                'condition' => 'good',
                'location' => 'Depok',
            ],
            [
                'category' => 'Elektronik',
                'title' => 'Headphone Bluetooth Hitam',
                'slug' => 'headphone-bluetooth-hitam',
                'description' => 'Headphone bluetooth dengan suara jernih, baterai awet, lengkap kabel charger dan pouch bawaan.',
                'price' => 225000,
                'condition' => 'good',
                'location' => 'Tangerang',
            ],
            [
                'category' => 'Buku',
                'title' => 'Novel Fiksi Koleksi 5 Buku',
                'slug' => 'novel-fiksi-koleksi-5-buku',
                'description' => 'Paket lima novel fiksi populer. Cover masih bagus, beberapa halaman memiliki catatan kecil pensil.',
                'price' => 120000,
                'condition' => 'fair',
                'location' => 'Bekasi',
            ],
            [
                'category' => 'Sepatu',
                'title' => 'Sneakers Putih Size 42',
                'slug' => 'sneakers-putih-size-42',
                'description' => 'Sneakers putih size 42, sol masih tebal, sudah dicuci bersih dan siap digunakan kembali.',
                'price' => 210000,
                'condition' => 'like_new',
                'location' => 'Jakarta Timur',
            ],
            [
                'category' => 'Aksesoris',
                'title' => 'Tas Selempang Kanvas',
                'slug' => 'tas-selempang-kanvas',
                'description' => 'Tas selempang kanvas warna hijau army, kompartemen banyak, zipper lancar, tali bisa disesuaikan.',
                'price' => 95000,
                'condition' => 'good',
                'location' => 'Bogor',
            ],
        ])->map(function (array $item) use ($seller, $categories) {
            return Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'user_id' => $seller->id,
                    'category_id' => $categories[$item['category']]->id,
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'condition' => $item['condition'],
                    'location' => $item['location'],
                    'image' => null,
                    'status' => 'available',
                ]
            );
        });

        $soldProduct = $products->first();
        $soldProduct->update(['status' => 'sold']);

        Order::updateOrCreate(
            ['order_number' => 'PM-SAMPLE-ORDER'],
            [
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'product_id' => $soldProduct->id,
                'product_title' => $soldProduct->title,
                'product_image' => $soldProduct->image,
                'total_price' => $soldProduct->price,
                'shipping_address' => 'Jl. Melati No. 8, Bandung, Jawa Barat',
                'expedition' => 'jne',
                'shipping_status' => 'shipped',
                'payment_status' => 'paid',
                'status' => 'processing',
                'notes' => 'Contoh transaksi untuk panel monitoring admin.',
            ]
        );
    }
}
