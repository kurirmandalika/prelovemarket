<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-5">
                <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Produk Saya</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $productsCount }}</p>
                </div>
                <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Tersedia</p>
                    <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $availableProductsCount }}</p>
                </div>
                <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Terjual</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $soldProductsCount }}</p>
                </div>
                <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Belanja</p>
                    <p class="mt-2 text-2xl font-bold text-sky-700">{{ $purchaseCount }}</p>
                </div>
                <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Penjualan</p>
                    <p class="mt-2 text-2xl font-bold text-amber-700">{{ $salesCount }}</p>
                </div>
            </div>

            @unless (auth()->user()->sellerProfile)
                <div class="mt-6 rounded-md border border-amber-200 bg-amber-50 p-5">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="font-semibold text-amber-900">Profil penjual belum dibuat</h3>
                            <p class="mt-1 text-sm text-amber-800">Buat profil penjual agar bisa menambahkan produk preloved.</p>
                        </div>
                        <a href="{{ route('dashboard.seller-profile.edit') }}" class="rounded-md bg-amber-700 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-800">Buat Profil</a>
                    </div>
                </div>
            @endunless

            <div class="mt-6 grid gap-6 lg:grid-cols-2">
                <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900">Pesanan Saya</h3>
                        <a href="{{ route('dashboard.orders.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">Lihat semua</a>
                    </div>
                    <div class="space-y-3">
                        @forelse ($latestPurchases as $order)
                            <div class="rounded-md bg-gray-50 p-3">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="truncate text-sm font-semibold text-gray-900">{{ $order->product_title }}</p>
                                    <span class="rounded-full bg-sky-50 px-2 py-1 text-xs font-semibold text-sky-700">{{ $order->shippingStatusLabel() }}</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">{{ $order->order_number }} · {{ $order->formattedTotal() }}</p>
                            </div>
                        @empty
                            <p class="rounded-md border border-dashed border-gray-300 p-5 text-center text-sm text-gray-500">Belum ada pesanan.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900">Penjualan Terbaru</h3>
                        <a href="{{ route('dashboard.sales.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">Lihat semua</a>
                    </div>
                    <div class="space-y-3">
                        @forelse ($latestSales as $order)
                            <div class="rounded-md bg-gray-50 p-3">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="truncate text-sm font-semibold text-gray-900">{{ $order->product_title }}</p>
                                    <span class="rounded-full bg-amber-50 px-2 py-1 text-xs font-semibold text-amber-700">{{ $order->shippingStatusLabel() }}</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">{{ $order->buyer->name }} · {{ $order->formattedTotal() }}</p>
                            </div>
                        @empty
                            <p class="rounded-md border border-dashed border-gray-300 p-5 text-center text-sm text-gray-500">Belum ada penjualan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
