@props(['product'])

@php
    $conditionClasses = [
        'new' => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
        'like_new' => 'bg-sky-50 text-sky-800 ring-sky-200',
        'good' => 'bg-amber-50 text-amber-800 ring-amber-200',
        'fair' => 'bg-zinc-100 text-zinc-700 ring-zinc-200',
    ];
    $statusClasses = $product->status === 'available'
        ? 'bg-emerald-600 text-white'
        : 'bg-zinc-800 text-white';
    $sellerName = $product->user->sellerProfile->shop_name ?? $product->user->name;
@endphp

<article class="group overflow-hidden rounded-md border border-zinc-200 bg-white shadow-sm shadow-zinc-200/70 transition duration-300 hover:border-emerald-200 hover:shadow-xl hover:shadow-zinc-200 sm:hover:-translate-y-1">
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="relative aspect-[16/11] overflow-hidden bg-zinc-100 sm:aspect-[4/3]">
            <x-product-image :product="$product" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-zinc-950/70 to-transparent p-3">
                <span class="inline-flex rounded-md bg-white/95 px-2.5 py-1 text-xs font-extrabold text-zinc-950 shadow-sm">
                    {{ $product->category->name }}
                </span>
            </div>
        </div>
    </a>

    <div class="space-y-3 p-3 sm:space-y-4 sm:p-4">
        <div class="flex flex-wrap gap-2">
            <span class="rounded-full px-2.5 py-1 text-xs font-bold ring-1 {{ $conditionClasses[$product->condition] ?? 'bg-zinc-100 text-zinc-700 ring-zinc-200' }}">
                {{ $product->conditionLabel() }}
            </span>
            <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $statusClasses }}">
                {{ $product->statusLabel() }}
            </span>
        </div>

        <div>
            <a href="{{ route('products.show', $product) }}" class="line-clamp-2 text-base font-extrabold leading-snug text-zinc-950 transition hover:text-emerald-700">
                {{ $product->title }}
            </a>
            <p class="mt-2 truncate text-sm font-medium text-zinc-500">{{ $product->location }} &middot; {{ $sellerName }}</p>
        </div>

        <div class="flex items-center justify-between gap-3 border-t border-zinc-100 pt-3 sm:pt-4">
            <p class="text-lg font-extrabold text-emerald-700">{{ $product->formattedPrice() }}</p>
            <a href="{{ route('products.show', $product) }}" class="rounded-md border border-zinc-200 px-3 py-2.5 text-xs font-extrabold text-zinc-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-800">
                Detail
            </a>
        </div>
    </div>
</article>
