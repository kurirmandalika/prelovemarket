<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profil Penjual</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-md border border-gray-200 bg-white p-6 shadow-sm">
                <form action="{{ route('dashboard.seller-profile.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="shop_name" class="block text-sm font-medium text-gray-700">Nama Toko</label>
                        <input id="shop_name" type="text" name="shop_name" value="{{ old('shop_name', $profile->shop_name ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                        @error('shop_name')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone', $profile->phone ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                        @error('phone')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Toko</label>
                        <textarea id="address" name="address" rows="3" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>{{ old('address', $profile->address ?? '') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Toko</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('description', $profile->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Simpan Profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
