@php
    $isEdit = $product !== null;
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Judul Produk</label>
        <input id="title" type="text" name="title" value="{{ old('title', $product->title ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>
        @error('title')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select id="category_id" name="category_id" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id ?? '') === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="condition" class="block text-sm font-medium text-gray-700">Kondisi</label>
            <select id="condition" name="condition" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                <option value="">Pilih kondisi</option>
                @foreach ($conditions as $value => $label)
                    <option value="{{ $value }}" @selected(old('condition', $product->condition ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('condition')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
            <input id="price" type="number" min="1000" step="1000" name="price" value="{{ old('price', $product->price ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            @error('price')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="location" class="block text-sm font-medium text-gray-700">Lokasi</label>
            <input id="location" type="text" name="location" value="{{ old('location', $product->location ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            @error('location')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    @if ($isEdit)
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $product->status) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea id="description" name="description" rows="5" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-emerald-600 focus:ring-emerald-600" required>{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
        <input id="image" type="file" name="image" accept="image/png,image/jpeg,image/webp" class="mt-1 w-full rounded-md border border-gray-300 p-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-emerald-700" @required(! $isEdit)>
        <p class="mt-1 text-xs text-gray-500">Format jpg, jpeg, png, atau webp. Maksimal 2MB.</p>
        @error('image')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror

        @if ($isEdit && $product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->title }}" class="mt-3 h-28 w-28 rounded-md object-cover">
        @endif
    </div>

    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
        <a href="{{ route('dashboard.products.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50">Batal</a>
        <button type="submit" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Produk' }}</button>
    </div>
</form>
