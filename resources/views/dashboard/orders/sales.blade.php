<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Penjualan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Order</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Pembeli</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Ekspedisi</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Pengiriman</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="px-4 py-4">
                                        <p class="font-semibold text-gray-900">{{ $order->product_title }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->order_number }}</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="font-medium text-gray-900">{{ $order->buyer->name }}</p>
                                        <p class="max-w-xs truncate text-xs text-gray-500">{{ $order->shipping_address }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-gray-600">{{ $order->expeditionLabel() }}</td>
                                    <td class="px-4 py-4">
                                        <form action="{{ route('dashboard.sales.shipping.update', $order) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="shipping_status" class="w-44 rounded-md border-gray-300 text-xs focus:border-emerald-600 focus:ring-emerald-600">
                                                @foreach ($shippingStatuses as $value => $label)
                                                    <option value="{{ $value }}" @selected($order->shipping_status === $value)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="rounded-md bg-gray-900 px-3 py-2 text-xs font-semibold text-white hover:bg-gray-800">Update</button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-4 text-right font-semibold text-gray-900">{{ $order->formattedTotal() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-gray-500">Belum ada penjualan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
