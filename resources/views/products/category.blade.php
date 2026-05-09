@extends('layouts.public')

@section('title', $category->name.' - Preloved Market')
@section('meta_description', 'Jelajahi produk preloved kategori '.$category->name.' yang masih tersedia di Preloved Market.')

@section('content')
    <section class="border-b border-zinc-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-extrabold uppercase text-emerald-700">Kategori</p>
                    <h1 class="mt-2 text-3xl font-extrabold text-zinc-950 sm:text-4xl">{{ $category->name }}</h1>
                    <p class="mt-3 text-sm font-medium text-zinc-500">{{ $products->total() }} produk tersedia dalam kategori ini.</p>
                </div>
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm font-extrabold text-zinc-700 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-800">Semua produk</a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="rounded-md border border-dashed border-zinc-300 bg-white p-8 text-center text-sm font-semibold text-zinc-500 sm:col-span-2 lg:col-span-4">
                    Belum ada produk tersedia pada kategori ini.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
@endsection
