@extends('layouts.public')

@section('title', 'Preloved Market - Marketplace Preloved Terkurasi')
@section('meta_description', 'Temukan pakaian, perabotan, elektronik, buku, sepatu, dan barang preloved berkualitas dari penjual tepercaya di Preloved Market.')

@section('content')
    <section
        class="relative overflow-hidden bg-zinc-950 text-white"
        style="background-image: linear-gradient(90deg, rgba(9, 9, 11, 0.92) 0%, rgba(9, 9, 11, 0.76) 46%, rgba(9, 9, 11, 0.35) 100%), url('https://images.unsplash.com/photo-1483985988355-763728e1935?auto=format&fit=crop&w=1800&q=85'); background-position: center; background-size: cover;"
    >
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-16 lg:px-8 lg:py-20">
            <div class="max-w-3xl">
                <p class="text-xs font-extrabold uppercase text-emerald-300 sm:text-sm">Marketplace preloved terkurasi</p>
                <h1 class="mt-3 text-3xl font-extrabold leading-tight text-white sm:mt-4 sm:text-5xl lg:text-6xl">Preloved Market</h1>
                <p class="mt-4 max-w-2xl text-sm leading-6 text-zinc-100 sm:mt-5 sm:text-lg sm:leading-7">
                    Beli barang second berkualitas dengan tampilan produk yang jelas, kondisi transparan, dan alur pemesanan yang rapi dari penjual lokal.
                </p>

                <div class="mt-6 grid gap-3 sm:mt-8 sm:flex sm:flex-row">
                    <a href="{{ route('products.index') }}" class="inline-flex min-h-12 items-center justify-center rounded-md bg-emerald-500 px-5 py-3 text-sm font-extrabold text-zinc-950 shadow-lg shadow-emerald-950/30 transition hover:bg-emerald-400">
                        Jelajah Produk
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex min-h-12 items-center justify-center rounded-md border border-white/40 bg-white/10 px-5 py-3 text-sm font-extrabold text-white backdrop-blur transition hover:border-white hover:bg-white/20">
                            Buka Toko Sekarang
                        </a>
                    @else
                        <a href="{{ route('dashboard.products.create') }}" class="inline-flex min-h-12 items-center justify-center rounded-md border border-white/40 bg-white/10 px-5 py-3 text-sm font-extrabold text-white backdrop-blur transition hover:border-white hover:bg-white/20">
                            Tambah Produk
                        </a>
                    @endguest
                </div>

                <div class="mt-8 grid max-w-2xl grid-cols-3 gap-2 sm:mt-10 sm:gap-3">
                    <div class="rounded-md bg-white/10 p-3 backdrop-blur sm:border-l-2 sm:border-emerald-400 sm:bg-transparent sm:pl-4">
                        <p class="text-xl font-extrabold sm:text-2xl">{{ $products->count() }}+</p>
                        <p class="mt-1 text-xs font-medium text-zinc-200 sm:text-sm">Pilihan</p>
                    </div>
                    <div class="rounded-md bg-white/10 p-3 backdrop-blur sm:border-l-2 sm:border-amber-300 sm:bg-transparent sm:pl-4">
                        <p class="text-xl font-extrabold sm:text-2xl">{{ $categories->count() }}</p>
                        <p class="mt-1 text-xs font-medium text-zinc-200 sm:text-sm">Kategori</p>
                    </div>
                    <div class="rounded-md bg-white/10 p-3 backdrop-blur sm:border-l-2 sm:border-sky-300 sm:bg-transparent sm:pl-4">
                        <p class="text-xl font-extrabold sm:text-2xl">24/7</p>
                        <p class="mt-1 text-xs font-medium text-zinc-200 sm:text-sm">Online</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-zinc-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-4 px-4 py-5 sm:px-6 sm:py-6 lg:grid-cols-[1.2fr_0.8fr] lg:px-8">
            <form action="{{ route('products.index') }}" method="GET" class="grid gap-3 sm:grid-cols-[1fr_auto]">
                <label for="home-search" class="sr-only">Cari produk preloved</label>
                <input id="home-search" type="search" name="search" placeholder="Cari jaket denim, meja kopi, headphone..." class="h-12 w-full rounded-md border-zinc-300 text-sm font-medium shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                <button type="submit" class="h-12 rounded-md bg-zinc-950 px-6 text-sm font-extrabold text-white shadow-sm transition hover:bg-emerald-700">Cari Produk</button>
            </form>

            <div class="grid gap-2 text-center sm:grid-cols-3 sm:gap-3">
                <div class="rounded-md bg-zinc-50 p-3">
                    <p class="text-sm font-extrabold text-zinc-950">Kurasi</p>
                    <p class="mt-1 text-xs font-medium text-zinc-500">Kondisi jelas</p>
                </div>
                <div class="rounded-md bg-emerald-50 p-3">
                    <p class="text-sm font-extrabold text-emerald-800">Lokal</p>
                    <p class="mt-1 text-xs font-medium text-emerald-700">Penjual dekat</p>
                </div>
                <div class="rounded-md bg-amber-50 p-3">
                    <p class="text-sm font-extrabold text-amber-800">Rapi</p>
                    <p class="mt-1 text-xs font-medium text-amber-700">Alur order</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-extrabold uppercase text-emerald-700">Jelajah cepat</p>
                <h2 class="mt-2 text-2xl font-extrabold text-zinc-950 sm:text-3xl">Kategori Favorit</h2>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-extrabold text-emerald-700 transition hover:text-emerald-900">Semua produk</a>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="group flex items-center justify-between rounded-md border border-zinc-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-lg hover:shadow-zinc-200">
                    <span>
                        <span class="block text-base font-extrabold text-zinc-950 transition group-hover:text-emerald-700">{{ $category->name }}</span>
                        <span class="mt-1 block text-sm font-medium text-zinc-500">{{ $category->products_count }} produk tersedia</span>
                    </span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-md bg-zinc-950 text-sm font-extrabold text-white transition group-hover:bg-emerald-600">
                        {{ strtoupper(substr($category->name, 0, 1)) }}
                    </span>
                </a>
            @empty
                <div class="rounded-md border border-dashed border-zinc-300 bg-white p-8 text-center text-sm font-semibold text-zinc-500 sm:col-span-2 lg:col-span-4">
                    Belum ada kategori tersedia.
                </div>
            @endforelse
        </div>
    </section>

    <section class="border-y border-zinc-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-extrabold uppercase text-emerald-700">Etalase terbaru</p>
                    <h2 class="mt-2 text-2xl font-extrabold text-zinc-950 sm:text-3xl">Produk Preloved Pilihan</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-zinc-500">Barang masih tersedia, siap masuk wishlist, dan bisa langsung dipesan dari halaman detail.</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm font-extrabold text-emerald-700 transition hover:text-emerald-900">Lihat semua produk</a>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="rounded-md border border-dashed border-zinc-300 bg-zinc-50 p-8 text-center text-sm font-semibold text-zinc-500 sm:col-span-2 lg:col-span-4">
                        Belum ada produk tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="grid gap-6 rounded-md bg-zinc-950 px-5 py-7 text-white sm:gap-8 sm:px-8 sm:py-8 lg:grid-cols-[1fr_auto] lg:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase text-amber-300">Untuk penjual</p>
                <h2 class="mt-3 text-2xl font-extrabold sm:text-3xl">Ubah barang yang jarang dipakai jadi etalase profesional.</h2>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-zinc-300">Tambahkan foto, kondisi, harga, lokasi, dan biarkan pembeli melakukan pemesanan dengan data pengiriman yang tersusun.</p>
            </div>
            @guest
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-500 px-5 py-3 text-sm font-extrabold text-zinc-950 transition hover:bg-emerald-400">Daftar Penjual</a>
            @else
                <a href="{{ route('dashboard.products.create') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-500 px-5 py-3 text-sm font-extrabold text-zinc-950 transition hover:bg-emerald-400">Tambah Produk</a>
            @endguest
        </div>
    </section>
@endsection
