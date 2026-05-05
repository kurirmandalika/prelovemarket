@props(['product'])

@php
    $conditionClasses = [
        'new' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'like_new' => 'bg-sky-50 text-sky-700 ring-sky-200',
        'good' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'fair' => 'bg-zinc-100 text-zinc-700 ring-zinc-200',
    ];
    $statusClasses = $product->status === 'available'
        ? 'bg-emerald-600 text-white'
        : 'bg-zinc-700 text-white';
    $sellerName = $product->user->sellerProfile->shop_name ?? $product->user->name;
@endphp

<article class="overflow-hidden rounded-md border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="aspect-[4/3] bg-zinc-100">
            @if ($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->title }}" class="h-full w-full object-cover">
            @else
                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-emerald-100 via-white to-amber-100">
                    <span class="flex h-16 w-16 items-center justify-center rounded-md bg-white/80 text-2xl font-bold text-emerald-800 shadow-sm">
                        {{ strtoupper(substr($product->title, 0, 1)) }}
                    </span>
                </div>
            @endif
        </div>
    </a>

    <div class="space-y-3 p-4">
        <div class="flex flex-wrap gap-2">
            <span class="rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $conditionClasses[$product->condition] ?? 'bg-zinc-100 text-zinc-700 ring-zinc-200' }}">
                {{ $product->conditionLabel() }}
            </span>
            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                {{ $product->statusLabel() }}
            </span>
        </div>

        <div>
            <a href="{{ route('products.show', $product) }}" class="line-clamp-2 text-base font-semibold text-zinc-950 hover:text-emerald-700">
                {{ $product->title }}
            </a>
            <p class="mt-1 text-sm text-zinc-500">{{ $product->category->name }} · {{ $product->location }}</p>
        </div>

        <div class="flex items-end justify-between gap-3">
            <p class="text-lg font-bold text-emerald-700">{{ $product->formattedPrice() }}</p>
            <p class="max-w-[9rem] truncate text-right text-xs text-zinc-500">{{ $sellerName }}</p>
        </div>
    </div>
</article>
