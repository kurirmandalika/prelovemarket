<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('meta_description', 'Preloved Market adalah marketplace barang preloved terkurasi untuk jual beli produk layak pakai dengan pengalaman yang rapi dan terpercaya.')">

        <title>@yield('title', config('app.name', 'Preloved Market'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-50 font-sans text-zinc-950 antialiased">
        <div class="flex min-h-screen flex-col">
            <header class="sticky top-0 z-40 border-b border-zinc-200/80 bg-white/95 backdrop-blur-xl">
                <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                    <div class="flex items-center justify-between gap-4">
                        <a href="{{ route('home') }}" class="group inline-flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-md bg-zinc-950 text-sm font-extrabold text-white shadow-sm shadow-emerald-900/20 transition group-hover:bg-emerald-700">PM</span>
                            <span class="leading-tight">
                                <span class="block text-base font-extrabold text-zinc-950">Preloved Market</span>
                                <span class="block text-xs font-medium text-zinc-500">Curated second-life goods</span>
                            </span>
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex rounded-md border border-zinc-200 px-3 py-2 text-xs font-bold text-zinc-700 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-800 lg:hidden">Dashboard</a>
                        @else
                            <a href="{{ route('products.index') }}" class="inline-flex rounded-md border border-zinc-200 px-3 py-2 text-xs font-bold text-zinc-700 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-800 lg:hidden">Belanja</a>
                        @endauth
                    </div>

                    <nav class="flex flex-wrap items-center gap-2 text-sm font-bold">
                        <a href="{{ route('home') }}" class="rounded-md px-3.5 py-2 transition {{ request()->routeIs('home') ? 'bg-zinc-950 text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950' }}">Home</a>
                        <a href="{{ route('products.index') }}" class="rounded-md px-3.5 py-2 transition {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'bg-zinc-950 text-white shadow-sm' : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950' }}">Produk</a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-md px-3.5 py-2 text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-950">Dashboard</a>
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="rounded-md bg-amber-400 px-3.5 py-2 text-zinc-950 shadow-sm transition hover:bg-amber-300">Admin</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="rounded-md px-3.5 py-2 text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-950">Login</a>
                            <a href="{{ route('register') }}" class="rounded-md bg-emerald-700 px-4 py-2 text-white shadow-sm shadow-emerald-900/20 transition hover:bg-emerald-800">Mulai Jual</a>
                        @endauth
                    </nav>
                </div>
            </header>

            @if (session('success') || session('error'))
                <div class="mx-auto w-full max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            @endif

            <main class="flex-1">
                @yield('content')
            </main>

            <footer class="mt-16 bg-zinc-950 text-white">
                <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-[1.2fr_0.8fr_0.8fr] lg:px-8">
                    <div>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-md bg-emerald-500 text-sm font-extrabold text-zinc-950">PM</span>
                            <span class="text-base font-extrabold">Preloved Market</span>
                        </a>
                        <p class="mt-4 max-w-md text-sm leading-6 text-zinc-300">
                            Marketplace preloved untuk menemukan barang berkualitas, menjual koleksi yang masih layak, dan memberi setiap produk kesempatan kedua.
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-bold text-white">Marketplace</p>
                        <div class="mt-4 space-y-2 text-sm text-zinc-300">
                            <a href="{{ route('products.index') }}" class="block transition hover:text-emerald-300">Jelajah Produk</a>
                            @guest
                                <a href="{{ route('register') }}" class="block transition hover:text-emerald-300">Buka Toko</a>
                                <a href="{{ route('login') }}" class="block transition hover:text-emerald-300">Login</a>
                            @else
                                <a href="{{ route('dashboard.products.create') }}" class="block transition hover:text-emerald-300">Tambah Produk</a>
                                <a href="{{ route('dashboard.orders.index') }}" class="block transition hover:text-emerald-300">Pesanan Saya</a>
                            @endguest
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-bold text-white">Standar Toko</p>
                        <div class="mt-4 space-y-2 text-sm text-zinc-300">
                            <p>Foto produk jelas</p>
                            <p>Kondisi ditulis jujur</p>
                            <p>Pengiriman terpantau</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-white/10">
                    <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-xs font-medium text-zinc-400 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                        <p>&copy; {{ date('Y') }} Preloved Market. All rights reserved.</p>
                        <p>Built for thoughtful resale and better closets.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
