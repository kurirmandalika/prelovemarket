<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan Saya</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-4">
                @forelse ($orders as $order)
                    <div class="rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <div class="flex gap-4">
                                <div class="h-20 w-20 overflow-hidden rounded-md bg-gray-100">
                                    @if ($order->product_image)
                                        <img src="{{ asset('storage/'.$order->product_image) }}" alt="{{ $order->product_title }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-emerald-50 text-lg font-bold text-emerald-700">{{ strtoupper(substr($order->product_title, 0, 1)) }}</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $order->product_title }}</p>
                                    <p class="mt-1 text-xs text-gray-500">{{ $order->order_number }}</p>
                                    <p class="mt-2 text-sm font-bold text-emerald-700">{{ $order->formattedTotal() }}</p>
                                </div>
                            </div>

                            <div class="grid gap-2 text-sm md:min-w-72">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-gray-500">Penjual</span>
                                    <span class="font-medium text-gray-900">{{ $order->seller->sellerProfile->shop_name ?? $order->seller->name }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-gray-500">Ekspedisi</span>
                                    <span class="font-medium text-gray-900">{{ $order->expeditionLabel() }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-gray-500">Pengiriman</span>
                                    <span class="rounded-full bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700">{{ $order->shippingStatusLabel() }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-gray-500">Order</span>
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">{{ $order->statusLabel() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-md border border-dashed border-gray-300 bg-white p-10 text-center text-sm text-gray-500">
                        Belum ada pesanan. Mulai belanja dari halaman produk.
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
