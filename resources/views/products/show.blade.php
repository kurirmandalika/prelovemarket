@extends('layouts.public')

@section('title', $product->title.' - Preloved Market')

@section('content')
    @php
        $sellerName = $product->user->sellerProfile->shop_name ?? $product->user->name;
        $canOrder = auth()->check() && auth()->id() !== $product->user_id && $product->status === 'available';
    @endphp

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="overflow-hidden rounded-md border border-zinc-200 bg-white">
                <div class="aspect-[4/3] bg-zinc-100">
                    @if ($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->title }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-emerald-100 via-white to-amber-100">
                            <span class="flex h-24 w-24 items-center justify-center rounded-md bg-white/80 text-4xl font-bold text-emerald-800 shadow-sm">
                                {{ strtoupper(substr($product->title, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <div class="flex flex-wrap gap-2">
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">{{ $product->conditionLabel() }}</span>
                        <span class="rounded-full bg-zinc-900 px-3 py-1 text-xs font-semibold text-white">{{ $product->statusLabel() }}</span>
                        <a href="{{ route('categories.show', $product->category) }}" class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-700 ring-1 ring-zinc-200">{{ $product->category->name }}</a>
                    </div>

                    <h1 class="mt-4 text-3xl font-bold leading-tight text-zinc-950">{{ $product->title }}</h1>
                    <p class="mt-3 text-3xl font-bold text-emerald-700">{{ $product->formattedPrice() }}</p>
                    <p class="mt-3 text-sm text-zinc-500">Lokasi: {{ $product->location }}</p>
                </div>

                <div class="rounded-md border border-zinc-200 bg-white p-5">
                    <h2 class="text-base font-semibold text-zinc-950">Deskripsi</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-zinc-600">{{ $product->description }}</p>
                </div>

                <div class="rounded-md border border-zinc-200 bg-white p-5">
                    <h2 class="text-base font-semibold text-zinc-950">Penjual</h2>
                    <div class="mt-3 space-y-1 text-sm text-zinc-600">
                        <p class="font-semibold text-zinc-950">{{ $sellerName }}</p>
                        @if ($product->user->sellerProfile)
                            <p>{{ $product->user->sellerProfile->phone }}</p>
                            <p>{{ $product->user->sellerProfile->address }}</p>
                        @endif
                    </div>
                </div>

                <div class="rounded-md border border-zinc-200 bg-white p-5">
                    <h2 class="text-base font-semibold text-zinc-950">Beli Produk</h2>

                    @guest
                        <p class="mt-3 text-sm text-zinc-600">Login untuk membeli dan memilih ekspedisi pengiriman.</p>
                        <a href="{{ route('login') }}" class="mt-4 inline-flex rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Login</a>
                    @else
                        @if ($canOrder)
                            <form action="{{ route('orders.store', $product) }}" method="POST" class="mt-4 space-y-4">
                                @csrf

                                <div>
                                    <label for="shipping_address" class="block text-sm font-medium text-zinc-700">Alamat Pengiriman</label>
                                    <textarea id="shipping_address" name="shipping_address" rows="3" class="mt-1 w-full rounded-md border-zinc-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="expedition" class="block text-sm font-medium text-zinc-700">Ekspedisi</label>
                                    <select id="expedition" name="expedition" class="mt-1 w-full rounded-md border-zinc-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                                        @foreach (\App\Models\Order::EXPEDITIONS as $value => $label)
                                            <option value="{{ $value }}" @selected(old('expedition') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('expedition')
                                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-zinc-700">Catatan</label>
                                    <textarea id="notes" name="notes" rows="2" class="mt-1 w-full rounded-md border-zinc-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="w-full rounded-md bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Buat Pesanan</button>
                            </form>
                        @elseif (auth()->id() === $product->user_id)
                            <p class="mt-3 text-sm text-zinc-600">Ini produk milikmu. Kelola produk dari dashboard penjual.</p>
                            <a href="{{ route('dashboard.products.edit', $product) }}" class="mt-4 inline-flex rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800">Edit Produk</a>
                        @else
                            <p class="mt-3 text-sm text-zinc-600">Produk ini sudah terjual.</p>
                        @endif
                    @endguest
                </div>
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-zinc-950">Produk Serupa</h2>
                <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedProducts as $relatedProduct)
                        <x-product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
