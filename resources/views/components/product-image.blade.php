@props([
    'product',
    'class' => 'h-full w-full object-cover',
    'loading' => 'lazy',
])

@php
    $fallbackImages = [
        'pakaian' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=1000&q=80',
        'perabotan' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=1000&q=80',
        'elektronik' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1000&q=80',
        'buku' => 'https://images.unsplash.com/photo-1519682337058-a94d519337bc?auto=format&fit=crop&w=1000&q=80',
        'sepatu' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1000&q=80',
        'aksesoris' => 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&w=1000&q=80',
        'mainan' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?auto=format&fit=crop&w=1000&q=80',
        'perlengkapan-bayi' => 'https://images.unsplash.com/photo-1519689680058-324335c77eba?auto=format&fit=crop&w=1000&q=80',
        'default' => 'https://images.unsplash.com/photo-1483985988355-763728e1935?auto=format&fit=crop&w=1000&q=80',
    ];

    $categorySlug = $product->category->slug ?? 'default';
    $imageUrl = $product->image
        ? asset('storage/'.$product->image)
        : ($fallbackImages[$categorySlug] ?? $fallbackImages['default']);
@endphp

<img
    src="{{ $imageUrl }}"
    alt="{{ $product->title }}"
    loading="{{ $loading }}"
    class="{{ $class }}"
>
