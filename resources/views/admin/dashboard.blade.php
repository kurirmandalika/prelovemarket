<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-4">
                <a href="{{ route('admin.users.index') }}" class="rounded-md border border-gray-200 bg-white p-5 shadow-sm hover:bg-gray-50">
                    <p class="text-sm text-gray-500">User</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $usersCount }}</p>
                </a>
                <a href="{{ route('admin.products.index') }}" class="rounded-md border border-gray-200 bg-white p-5 shadow-sm hover:bg-gray-50">
                    <p class="text-sm text-gray-500">Produk</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $productsCount }}</p>
                </a>
                <a href="{{ route('admin.products.index', ['status' => 'available']) }}" class="rounded-md border border-gray-200 bg-white p-5 shadow-sm hover:bg-gray-50">
                    <p class="text-sm text-gray-500">Tersedia</p>
                    <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $availableProductsCount }}</p>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="rounded-md border border-gray-200 bg-white p-5 shadow-sm hover:bg-gray-50">
                    <p class="text-sm text-gray-500">Order</p>
                    <p class="mt-2 text-2xl font-bold text-sky-700">{{ $ordersCount }}</p>
                </a>
            </div>

            <div class="mt-6 rounded-md border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Aktivitas Transaksi Terbaru</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">Kelola order</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Order</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Pembeli</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Penjual</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($latestOrders as $order)
                                <tr>
                                    <td class="px-4 py-3">
                                        <p class="font-semibold text-gray-900">{{ $order->product_title }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->order_number }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $order->buyer->name }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $order->seller->name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700">{{ $order->shippingStatusLabel() }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-900">{{ $order->formattedTotal() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada aktivitas transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
