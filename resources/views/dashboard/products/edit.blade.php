<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Produk</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-md border border-gray-200 bg-white p-6 shadow-sm">
                @include('dashboard.products.form', [
                    'action' => route('dashboard.products.update', $product),
                    'method' => 'PUT',
                    'product' => $product,
                    'categories' => $categories,
                    'conditions' => $conditions,
                    'statuses' => $statuses,
                ])
            </div>
        </div>
    </div>
</x-app-layout>
