# Preloved Market

Preloved Market adalah website marketplace barang preloved yang dibangun dengan Laravel 13, Blade, Tailwind CSS, Vite, dan MySQL. Aplikasi ini menyediakan pengalaman jual-beli preloved dengan fitur user, penjual, dan admin.

## Ringkasan

- Platform jual beli barang preloved.
- Sistem autentikasi lengkap: register, login, logout.
- Role `admin` dan `user`.
- Profil penjual wajib sebelum membuat produk.
- CRUD produk preloved dengan status `available` / `sold`.
- Kategori produk, filter, dan detail produk.
- Order sederhana dengan pilihan ekspedisi.
- Dashboard untuk user dan admin.

## Fitur Utama

- Authentication: register, login, logout, middleware `auth`.
- Role dan otorisasi: admin dan user.
- Penjual: buat dan kelola profil toko.
- Produk: tambah, edit, hapus produk, upload gambar.
- Kategori: kategori produk terstruktur.
- Pembelian: buat pesanan dari halaman detail produk.
- Order: simpan data alamat, ekspedisi, status pengiriman, status pembayaran.
- Admin: kelola pengguna, produk, order, update role, dan update status.

## Akun Contoh (Seeded)

| Role    | Email             | Password |
| ------- | ----------------- | -------- |
| Admin   | admin@example.com | password |
| Penjual | user@example.com  | password |
| Pembeli | buyer@example.com | password |

## Struktur Rute Utama

| URL                                  | Fungsi                             |
| ------------------------------------ | ---------------------------------- |
| `/`                                  | Homepage produk terbaru            |
| `/products`                          | Daftar semua produk                |
| `/categories/{category:slug}`        | Produk berdasarkan kategori        |
| `/products/{product:slug}`           | Detail produk dan form order       |
| `/dashboard`                         | Dashboard user login               |
| `/dashboard/products`                | Daftar produk milik user           |
| `/dashboard/products/create`         | Tambah produk baru                 |
| `/dashboard/products/{product}/edit` | Edit produk milik user             |
| `/dashboard/seller-profile`          | Edit profil penjual                |
| `/dashboard/orders`                  | Order pembeli yang dibuat user     |
| `/dashboard/sales`                   | Penjualan seller / status kirim    |
| `/admin`                             | Dashboard admin                    |
| `/admin/products`                    | Kelola semua produk                |
| `/admin/users`                       | Kelola semua user                  |
| `/admin/orders`                      | Kelola order dan status pengiriman |

## Instalasi Lokal

1. Clone repository:

```bash
git clone <repo-url>
cd prelovemarket
```

2. Install dependensi PHP:

```bash
composer install
```

3. Salin file environment dan buat key:

```bash
copy .env.example .env
php artisan key:generate
```

4. Install dependensi JavaScript:

```bash
npm install
```

5. Sesuaikan pengaturan database di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prelovemarket
DB_USERNAME=root
DB_PASSWORD=
```

6. Jalankan migrasi dan seed data:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

7. Jalankan aplikasi:

```bash
npm run build
php artisan serve
```

Atau untuk development dengan hot reload:

```bash
npm run dev
```

## Teknologi

- Laravel 13
- PHP 8.3
- Blade templates
- Tailwind CSS
- Vite
- MySQL
- Alpine.js
- Laravel Breeze (auth)

## Database dan Model Utama

- `User`: pengguna dengan role `admin` atau `user`.
- `SellerProfile`: profil penjual, wajib untuk membuat produk.
- `Category`: kategori produk.
- `Product`: produk preloved dengan status, kondisi, dan gambar.
- `Order`: pesanan pembeli dengan alamat, ekspedisi, dan status pengiriman.

## Testing

Jalankan test suite Laravel:

```bash
php artisan test
```

## Tips Penggunaan

- Pastikan `php artisan storage:link` sudah dijalankan agar upload gambar dapat diakses.
- Gunakan akun seeded untuk login cepat.
- Admin bisa mengelola user, produk, dan order.
- User biasa harus membuat profil penjual sebelum menambahkan produk.

## Catatan Deploy

Untuk produksi, lakukan optimasi:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Atur variabel lingkungan terutama `APP_URL`, `DB_*`, `SESSION_DRIVER`, dan `FILESYSTEM_DISK`.
