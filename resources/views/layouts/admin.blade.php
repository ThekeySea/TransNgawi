<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | TransNgawi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-[#faf9f8] text-[#1a1a1a] antialiased">
    <header class="border-b border-[#e6e6e6] bg-white">
        <div class="container-app flex flex-wrap items-center gap-x-8 gap-y-3 py-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                <div class="flex h-9 w-9 items-center justify-center rounded-[var(--radius-md)] bg-[#ff750f] text-sm font-bold text-white">TN</div>
                <p class="text-lg font-bold tracking-tight">TransNgawi <span class="font-semibold text-[#555555]">Admin</span></p>
            </a>

            <nav class="flex flex-wrap items-center gap-1 text-sm font-semibold" aria-label="Navigasi admin">
                <a href="{{ route('admin.dashboard') }}" class="rounded-[var(--radius-sm)] px-3 py-2 transition-colors @if(request()->routeIs('admin.dashboard')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">Dasbor</a>
                <a href="{{ route('admin.locations.index') }}" class="rounded-[var(--radius-sm)] px-3 py-2 transition-colors @if(request()->routeIs('admin.locations.*')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">Lokasi</a>
                <a href="{{ route('admin.buses.index') }}" class="rounded-[var(--radius-sm)] px-3 py-2 transition-colors @if(request()->routeIs('admin.buses.*')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">Bus</a>
                <a href="{{ route('admin.trips.index') }}" class="rounded-[var(--radius-sm)] px-3 py-2 transition-colors @if(request()->routeIs('admin.trips.*')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">Trip</a>
            </nav>

            <div class="ml-auto flex items-center gap-3 text-sm">
                <span class="hidden text-[#555555] sm:inline">{{ auth()->user()->name }}</span>
                <a href="{{ route('home') }}" class="font-semibold text-[#1a1a1a] hover:text-[#ff750f]">Lihat Situs</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="font-semibold text-[#1a1a1a] hover:text-[#ff750f]">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1 py-10">
        @if (session('status'))
            <div class="container-app mb-6">
                <div class="rounded-[var(--radius-sm)] border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700" role="status">
                    {{ session('status') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="container-app mb-6">
                <div class="rounded-[var(--radius-sm)] border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700" role="alert">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
