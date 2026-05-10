@extends('layouts.public')

@section('title', 'Produk Preloved - Preloved Market')
@section('meta_description', 'Jelajahi katalog produk preloved terkurasi dari berbagai kategori dan kondisi di Preloved Market.')

@section('content')
    <section class="border-b border-zinc-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
            <div class="grid gap-5 lg:grid-cols-[1fr_auto] lg:items-end">
                <div>
                    <p class="text-xs font-extrabold uppercase text-emerald-700 sm:text-sm">Katalog marketplace</p>
                    <h1 class="mt-2 text-2xl font-extrabold text-zinc-950 sm:text-4xl">Produk Preloved</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-zinc-500">
                        Temukan barang layak pakai dari penjual lokal, lengkap dengan kategori, kondisi, lokasi, dan harga yang mudah dibandingkan.
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-2 sm:gap-3 lg:min-w-[24rem]">
                    <div class="rounded-md bg-zinc-950 p-3 text-white sm:p-4">
                        <p class="text-xl font-extrabold sm:text-2xl">{{ $products->total() }}</p>
                        <p class="mt-1 text-xs font-semibold text-zinc-300">Produk tersedia</p>
                    </div>
                    <div class="rounded-md bg-emerald-50 p-3 sm:p-4">
                        <p class="text-xl font-extrabold text-emerald-800 sm:text-2xl">{{ $categories->count() }}</p>
                        <p class="mt-1 text-xs font-semibold text-emerald-700">Kategori</p>
                    </div>
                    <div class="rounded-md bg-amber-50 p-3 sm:p-4">
                        <p class="text-xl font-extrabold text-amber-800 sm:text-2xl">{{ count($conditions) }}</p>
                        <p class="mt-1 text-xs font-semibold text-amber-700">Kondisi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
        @include('products.partials.filters', ['categories' => $categories, 'conditions' => $conditions])

        <div class="mt-8 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-extrabold text-zinc-950">Hasil Pencarian</h2>
                <p class="mt-1 text-sm font-medium text-zinc-500">
                    @if (request()->hasAny(['search', 'category', 'condition']))
                        Menampilkan produk sesuai filter aktif.
                    @else
                        Semua produk yang masih tersedia.
                    @endif
                </p>
            </div>
        </div>

        <div class="mt-5 grid gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-4">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="rounded-md border border-dashed border-zinc-300 bg-white p-8 text-center text-sm font-semibold text-zinc-500 sm:col-span-2 lg:col-span-4">
                    Produk tidak ditemukan. Coba kata kunci atau filter lain.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
@endsection
