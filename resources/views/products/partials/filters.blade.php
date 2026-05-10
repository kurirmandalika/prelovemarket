<form action="{{ route('products.index') }}" method="GET" class="grid gap-3 rounded-md border border-zinc-200 bg-white p-3 shadow-sm sm:p-4 md:grid-cols-[1.4fr_1fr_1fr_auto]">
    <div>
        <label for="search" class="mb-1.5 block text-xs font-extrabold uppercase text-zinc-500">Produk</label>
        <input id="search" type="search" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="h-11 w-full rounded-md border-zinc-300 text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600">
    </div>

    <div>
        <label for="category" class="mb-1.5 block text-xs font-extrabold uppercase text-zinc-500">Kategori</label>
        <select id="category" name="category" class="h-11 w-full rounded-md border-zinc-300 text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Semua kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="condition" class="mb-1.5 block text-xs font-extrabold uppercase text-zinc-500">Kondisi</label>
        <select id="condition" name="condition" class="h-11 w-full rounded-md border-zinc-300 text-sm font-medium focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Semua kondisi</option>
            @foreach ($conditions as $value => $label)
                <option value="{{ $value }}" @selected(request('condition') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-2 items-end gap-2 md:flex">
        <button type="submit" class="h-11 rounded-md bg-zinc-950 px-4 text-sm font-extrabold text-white transition hover:bg-emerald-700 md:flex-none">Filter</button>
        <a href="{{ route('products.index') }}" class="inline-flex h-11 items-center justify-center rounded-md border border-zinc-300 px-4 text-sm font-extrabold text-zinc-700 transition hover:border-zinc-400 hover:bg-zinc-50">Reset</a>
    </div>
</form>
