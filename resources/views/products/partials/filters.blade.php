<form action="{{ route('products.index') }}" method="GET" class="grid gap-3 rounded-md border border-zinc-200 bg-white p-4 md:grid-cols-[1.4fr_1fr_1fr_auto]">
    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="rounded-md border-zinc-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">

    <select name="category" class="rounded-md border-zinc-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
        <option value="">Semua kategori</option>
        @foreach ($categories as $category)
            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
        @endforeach
    </select>

    <select name="condition" class="rounded-md border-zinc-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
        <option value="">Semua kondisi</option>
        @foreach ($conditions as $value => $label)
            <option value="{{ $value }}" @selected(request('condition') === $value)>{{ $label }}</option>
        @endforeach
    </select>

    <div class="flex gap-2">
        <button type="submit" class="flex-1 rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800 md:flex-none">Filter</button>
        <a href="{{ route('products.index') }}" class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 hover:bg-zinc-50">Reset</a>
    </div>
</form>
