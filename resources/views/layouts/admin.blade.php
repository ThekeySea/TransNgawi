<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | TransNgawi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .admin-layout { display: flex; height: 100vh; overflow: hidden; }
        .admin-sidebar { width: 16rem; flex-shrink: 0; overflow-y: hidden; display: flex; flex-direction: column; border-right: 1px solid #e6e6e6; background: #fff; }
        .admin-main { flex: 1 1 0%; min-height: 0; overflow-y: auto; padding: 2.5rem 0; }
    </style>
</head>
<body class="bg-[#faf9f8] text-[#1a1a1a] antialiased">

    <div class="admin-layout">
        {{-- Sidebar --}}
        <aside class="admin-sidebar">
            {{-- Logo --}}
            <div class="flex items-center gap-2.5 border-b border-[#e6e6e6] px-5 py-4">
                <div class="flex h-9 w-9 items-center justify-center rounded-[var(--radius-md)] bg-[#ff750f] text-sm font-bold text-white">TN</div>
                <p class="text-lg font-bold tracking-tight">TransNgawi <span class="font-semibold text-[#555555]">Admin</span></p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 py-4" aria-label="Navigasi admin">
                <div class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-[#555555]">Menu</div>

                <a href="{{ route('admin.dashboard') }}" class="mx-3 flex items-center gap-3 rounded-[var(--radius-sm)] px-3 py-2.5 text-sm font-semibold transition-colors @if(request()->routeIs('admin.dashboard')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                    Dasbor
                </a>

                <a href="{{ route('admin.locations.index') }}" class="mx-3 flex items-center gap-3 rounded-[var(--radius-sm)] px-3 py-2.5 text-sm font-semibold transition-colors @if(request()->routeIs('admin.locations.*')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Lokasi
                </a>

                <a href="{{ route('admin.routes.index') }}" class="mx-3 flex items-center gap-3 rounded-[var(--radius-sm)] px-3 py-2.5 text-sm font-semibold transition-colors @if(request()->routeIs('admin.routes.*')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Rute
                </a>

                <a href="{{ route('admin.buses.index') }}" class="mx-3 flex items-center gap-3 rounded-[var(--radius-sm)] px-3 py-2.5 text-sm font-semibold transition-colors @if(request()->routeIs('admin.buses.*')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Bus
                </a>

                <a href="{{ route('admin.trips.index') }}" class="mx-3 flex items-center gap-3 rounded-[var(--radius-sm)] px-3 py-2.5 text-sm font-semibold transition-colors @if(request()->routeIs('admin.trips.*')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Trip
                </a>

                <a href="{{ route('admin.transactions.index') }}" class="mx-3 flex items-center gap-3 rounded-[var(--radius-sm)] px-3 py-2.5 text-sm font-semibold transition-colors @if(request()->routeIs('admin.transactions.*')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Transaksi
                </a>

                <a href="{{ route('admin.analisa.index') }}" class="mx-3 flex items-center gap-3 rounded-[var(--radius-sm)] px-3 py-2.5 text-sm font-semibold transition-colors @if(request()->routeIs('admin.analisa.*')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Analisa
                </a>

                <a href="{{ route('admin.help.index') }}" class="mx-3 relative flex items-center gap-3 rounded-[var(--radius-sm)] px-3 py-2.5 text-sm font-semibold transition-colors @if(request()->routeIs('admin.help.*')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Bantuan
                    @php
                        $pendingHelpCount = \App\Models\SupportSession::where('status', 'WAITING')->count();
                    @endphp
                    @if ($pendingHelpCount > 0)
                        <span class="absolute right-3 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-500 px-1.5 text-[10px] font-bold text-white">{{ $pendingHelpCount }}</span>
                    @endif
                </a>
            </nav>

            {{-- User Info --}}
            <div class="border-t border-[#e6e6e6] px-4 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#ff750f]/10 text-sm font-bold text-[#ff750f]">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-text">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-text-muted">Admin</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-[var(--radius-sm)] p-1.5 text-[#555555] transition-colors hover:bg-[#ff750f]/10 hover:text-[#ff750f]">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="admin-main">
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
    </div>

    @stack('scripts')
</body>
</html>
