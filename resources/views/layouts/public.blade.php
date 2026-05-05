<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Preloved Market'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-zinc-50 font-sans text-zinc-950 antialiased">
        <header class="sticky top-0 z-40 border-b border-zinc-200 bg-white/95 backdrop-blur">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <div class="flex items-center justify-between">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-md bg-emerald-700 text-sm font-bold text-white">PM</span>
                        <span>
                            <span class="block text-base font-bold text-zinc-950">Preloved Market</span>
                            <span class="block text-xs text-zinc-500">Marketplace barang layak pakai</span>
                        </span>
                    </a>
                </div>

                <nav class="flex flex-wrap items-center gap-2 text-sm font-medium">
                    <a href="{{ route('home') }}" class="rounded-md px-3 py-2 {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700' : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950' }}">Home</a>
                    <a href="{{ route('products.index') }}" class="rounded-md px-3 py-2 {{ request()->routeIs('products.*') ? 'bg-emerald-50 text-emerald-700' : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950' }}">Produk</a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-md px-3 py-2 text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950">Dashboard</a>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="rounded-md bg-zinc-950 px-3 py-2 text-white hover:bg-zinc-800">Admin</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950">Login</a>
                        <a href="{{ route('register') }}" class="rounded-md bg-emerald-700 px-3 py-2 text-white hover:bg-emerald-800">Register</a>
                    @endauth
                </nav>
            </div>
        </header>

        @if (session('success') || session('error'))
            <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        <main>
            @yield('content')
        </main>

        <footer class="mt-16 border-t border-zinc-200 bg-white">
            <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-8 text-sm text-zinc-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <p>&copy; {{ date('Y') }} Preloved Market</p>
                <p>Jual-beli barang preloved dengan alur penjual, pembeli, dan pengiriman.</p>
            </div>
        </footer>
    </body>
</html>
