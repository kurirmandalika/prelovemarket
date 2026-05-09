@extends('layouts.public')

@section('title', $product->title.' - Preloved Market')
@section('meta_description', $product->title.' preloved '.$product->conditionLabel().' di '.$product->location.' seharga '.$product->formattedPrice().'.')

@section('content')
    @php
        $sellerName = $product->user->sellerProfile->shop_name ?? $product->user->name;
        $canOrder = auth()->check() && auth()->id() !== $product->user_id && $product->status === 'available';
        $conditionClasses = [
            'new' => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
            'like_new' => 'bg-sky-50 text-sky-800 ring-sky-200',
            'good' => 'bg-amber-50 text-amber-800 ring-amber-200',
            'fair' => 'bg-zinc-100 text-zinc-700 ring-zinc-200',
        ];
    @endphp

    <section class="border-b border-zinc-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-2 text-sm font-bold text-zinc-500">
                <a href="{{ route('home') }}" class="transition hover:text-emerald-700">Home</a>
                <span>/</span>
                <a href="{{ route('products.index') }}" class="transition hover:text-emerald-700">Produk</a>
                <span>/</span>
                <a href="{{ route('categories.show', $product->category) }}" class="transition hover:text-emerald-700">{{ $product->category->name }}</a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="space-y-5">
                <div class="overflow-hidden rounded-md border border-zinc-200 bg-white shadow-sm">
                    <div class="relative aspect-[4/3] bg-zinc-100">
                        <x-product-image :product="$product" loading="eager" class="h-full w-full object-cover" />
                        <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                            <span class="rounded-full px-3 py-1 text-xs font-extrabold ring-1 {{ $conditionClasses[$product->condition] ?? 'bg-zinc-100 text-zinc-700 ring-zinc-200' }}">{{ $product->conditionLabel() }}</span>
                            <span class="rounded-full px-3 py-1 text-xs font-extrabold {{ $product->status === 'available' ? 'bg-emerald-600 text-white' : 'bg-zinc-900 text-white' }}">{{ $product->statusLabel() }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-md border border-zinc-200 bg-white p-4 shadow-sm">
                        <p class="text-xs font-extrabold uppercase text-zinc-500">Kategori</p>
                        <p class="mt-2 text-sm font-extrabold text-zinc-950">{{ $product->category->name }}</p>
                    </div>
                    <div class="rounded-md border border-zinc-200 bg-white p-4 shadow-sm">
                        <p class="text-xs font-extrabold uppercase text-zinc-500">Lokasi</p>
                        <p class="mt-2 text-sm font-extrabold text-zinc-950">{{ $product->location }}</p>
                    </div>
                    <div class="rounded-md border border-zinc-200 bg-white p-4 shadow-sm">
                        <p class="text-xs font-extrabold uppercase text-zinc-500">Penjual</p>
                        <p class="mt-2 truncate text-sm font-extrabold text-zinc-950">{{ $sellerName }}</p>
                    </div>
                </div>

                <div class="rounded-md border border-zinc-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-extrabold text-zinc-950">Deskripsi Produk</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-zinc-600">{{ $product->description }}</p>
                </div>
            </div>

            <div class="space-y-5">
                <div class="rounded-md border border-zinc-200 bg-white p-5 shadow-sm lg:sticky lg:top-28">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('categories.show', $product->category) }}" class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-extrabold text-zinc-700 ring-1 ring-zinc-200">{{ $product->category->name }}</a>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-800 ring-1 ring-emerald-200">Siap dikirim</span>
                    </div>

                    <h1 class="mt-4 text-3xl font-extrabold leading-tight text-zinc-950 sm:text-4xl">{{ $product->title }}</h1>
                    <p class="mt-4 text-3xl font-extrabold text-emerald-700">{{ $product->formattedPrice() }}</p>
                    <p class="mt-3 text-sm font-medium leading-6 text-zinc-500">Produk preloved dari {{ $sellerName }} di {{ $product->location }}.</p>

                    <div class="mt-5 rounded-md bg-zinc-50 p-4">
                        <h2 class="text-sm font-extrabold text-zinc-950">Penjual</h2>
                        <div class="mt-3 space-y-1 text-sm font-medium text-zinc-600">
                            <p class="font-extrabold text-zinc-950">{{ $sellerName }}</p>
                            @if ($product->user->sellerProfile)
                                <p>{{ $product->user->sellerProfile->phone }}</p>
                                <p>{{ $product->user->sellerProfile->address }}</p>
                            @else
                                <p>Profil toko belum dilengkapi.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5 border-t border-zinc-100 pt-5">
                        <h2 class="text-sm font-extrabold text-zinc-950">Pesan Produk</h2>

                        @guest
                            <p class="mt-2 text-sm leading-6 text-zinc-600">Login untuk membuat pesanan dan memilih ekspedisi pengiriman.</p>
                            <a href="{{ route('login') }}" class="mt-4 inline-flex w-full items-center justify-center rounded-md bg-zinc-950 px-4 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-700">Login untuk Membeli</a>
                        @else
                            @if ($canOrder)
                                <form action="{{ route('orders.store', $product) }}" method="POST" class="mt-4 space-y-4">
                                    @csrf

                                    <div>
                                        <label for="shipping_address" class="block text-sm font-bold text-zinc-700">Alamat Pengiriman</label>
                                        <textarea id="shipping_address" name="shipping_address" rows="3" class="mt-1 w-full rounded-md border-zinc-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>{{ old('shipping_address') }}</textarea>
                                        @error('shipping_address')
                                            <p class="mt-1 text-sm font-semibold text-rose-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="expedition" class="block text-sm font-bold text-zinc-700">Ekspedisi</label>
                                        <select id="expedition" name="expedition" class="mt-1 w-full rounded-md border-zinc-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                                            @foreach (\App\Models\Order::EXPEDITIONS as $value => $label)
                                                <option value="{{ $value }}" @selected(old('expedition') === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('expedition')
                                            <p class="mt-1 text-sm font-semibold text-rose-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="notes" class="block text-sm font-bold text-zinc-700">Catatan</label>
                                        <textarea id="notes" name="notes" rows="2" class="mt-1 w-full rounded-md border-zinc-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <p class="mt-1 text-sm font-semibold text-rose-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="submit" class="w-full rounded-md bg-emerald-700 px-4 py-3 text-sm font-extrabold text-white shadow-sm transition hover:bg-emerald-800">Buat Pesanan</button>
                                </form>
                            @elseif (auth()->id() === $product->user_id)
                                <p class="mt-2 text-sm leading-6 text-zinc-600">Ini produk milikmu. Kelola produk dari dashboard penjual.</p>
                                <a href="{{ route('dashboard.products.edit', $product) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-md bg-zinc-950 px-4 py-3 text-sm font-extrabold text-white transition hover:bg-zinc-800">Edit Produk</a>
                            @else
                                <p class="mt-2 text-sm leading-6 text-zinc-600">Produk ini sudah terjual.</p>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-12 border-t border-zinc-200 pt-10">
                <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-extrabold uppercase text-emerald-700">Masih satu kategori</p>
                        <h2 class="mt-2 text-2xl font-extrabold text-zinc-950">Produk Serupa</h2>
                    </div>
                    <a href="{{ route('categories.show', $product->category) }}" class="text-sm font-extrabold text-emerald-700 transition hover:text-emerald-900">Lihat kategori</a>
                </div>
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedProducts as $relatedProduct)
                        <x-product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
