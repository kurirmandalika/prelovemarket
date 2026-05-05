<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Produk</h2>
            <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-2">
                <select name="status" class="rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
                    <option value="">Semua status</option>
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">Filter</button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Produk</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Penjual</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Kategori</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($products as $product)
                                <tr>
                                    <td class="px-4 py-4">
                                        <p class="font-semibold text-gray-900">{{ $product->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $product->formattedPrice() }} · {{ $product->conditionLabel() }}</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="text-gray-900">{{ $product->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $product->user->sellerProfile->shop_name ?? 'Belum ada profil toko' }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-gray-600">{{ $product->category->name }}</td>
                                    <td class="px-4 py-4">
                                        <form action="{{ route('admin.products.status.update', $product) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="w-32 rounded-md border-gray-300 text-xs focus:border-emerald-600 focus:ring-emerald-600">
                                                @foreach ($statuses as $value => $label)
                                                    <option value="{{ $value }}" @selected($product->status === $value)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="rounded-md bg-gray-900 px-3 py-2 text-xs font-semibold text-white hover:bg-gray-800">Update</button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('products.show', $product) }}" class="rounded-md border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">Lihat</a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini sebagai admin?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-md bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-gray-500">Belum ada produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
