@extends('layouts.public')

@section('title', $category->name.' - Preloved Market')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase text-emerald-700">Kategori</p>
                <h1 class="mt-2 text-3xl font-bold text-zinc-950">{{ $category->name }}</h1>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">Semua produk</a>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="rounded-md border border-dashed border-zinc-300 bg-white p-8 text-center text-sm text-zinc-500 sm:col-span-2 lg:col-span-4">
                    Belum ada produk tersedia pada kategori ini.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
@endsection
