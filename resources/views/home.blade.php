@extends('layouts.public')

@section('title', 'Preloved Market')

@section('content')
    <section class="border-b border-zinc-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[1fr_22rem] lg:px-8">
            <div class="space-y-6">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase text-emerald-700">Marketplace preloved</p>
                    <h1 class="mt-3 text-4xl font-bold leading-tight text-zinc-950 sm:text-5xl">Preloved Market</h1>
                    <p class="mt-4 text-base leading-7 text-zinc-600">
                        Temukan pakaian, perabotan, elektronik, buku, dan barang preloved lain dari penjual yang sudah melengkapi profil toko.
                    </p>
                </div>

                <form action="{{ route('products.index') }}" method="GET" class="grid gap-3 rounded-md border border-zinc-200 bg-zinc-50 p-3 sm:grid-cols-[1fr_auto]">
                    <input type="search" name="search" placeholder="Cari jaket denim, meja kopi, headphone..." class="w-full rounded-md border-zinc-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
                    <button type="submit" class="rounded-md bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Cari Produk</button>
                </form>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-md border border-zinc-200 bg-white p-4">
                        <p class="text-2xl font-bold text-zinc-950">{{ $products->count() }}+</p>
                        <p class="mt-1 text-sm text-zinc-500">Produk terbaru</p>
                    </div>
                    <div class="rounded-md border border-zinc-200 bg-white p-4">
                        <p class="text-2xl font-bold text-zinc-950">{{ $categories->count() }}</p>
                        <p class="mt-1 text-sm text-zinc-500">Kategori aktif</p>
                    </div>
                    <div class="rounded-md border border-zinc-200 bg-white p-4">
                        <p class="text-2xl font-bold text-zinc-950">Web</p>
                        <p class="mt-1 text-sm text-zinc-500">Auth, dashboard, admin</p>
                    </div>
                </div>
            </div>

            <aside class="rounded-md border border-zinc-200 bg-zinc-50 p-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-zinc-950">Kategori</h2>
                    <a href="{{ route('products.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">Semua</a>
                </div>
                <div class="mt-4 space-y-2">
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.show', $category) }}" class="flex items-center justify-between rounded-md bg-white px-3 py-2 text-sm hover:bg-emerald-50">
                            <span class="font-medium text-zinc-700">{{ $category->name }}</span>
                            <span class="rounded-full bg-zinc-100 px-2 py-0.5 text-xs text-zinc-500">{{ $category->products_count }}</span>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-zinc-950">Produk Terbaru</h2>
                <p class="mt-1 text-sm text-zinc-500">Barang preloved yang masih tersedia dan siap dibeli.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">Lihat semua produk</a>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="rounded-md border border-dashed border-zinc-300 bg-white p-8 text-center text-sm text-zinc-500 sm:col-span-2 lg:col-span-4">
                    Belum ada produk tersedia.
                </div>
            @endforelse
        </div>
    </section>
@endsection
