@extends('layouts.public')

@section('title', 'Produk Preloved - Preloved Market')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-zinc-950">Produk Preloved</h1>
                <p class="mt-2 text-sm text-zinc-500">Cari berdasarkan judul, kategori, atau kondisi barang.</p>
            </div>
        </div>

        @include('products.partials.filters', ['categories' => $categories, 'conditions' => $conditions])

        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="rounded-md border border-dashed border-zinc-300 bg-white p-8 text-center text-sm text-zinc-500 sm:col-span-2 lg:col-span-4">
                    Produk tidak ditemukan.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
@endsection
