@extends('layouts.admin')

@section('title', 'Analisa')

@section('content')
    <div class="container-app">
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Analisa</h1>
                <p class="mt-2 text-base text-[#555555]">Statistik penjualan tiket dan pendapatan.</p>
            </div>
            <div class="flex gap-2">
                <form action="{{ route('admin.analisa.index') }}" method="GET" class="flex gap-1">
                    <button type="submit" name="period" value="7days" class="rounded-[var(--radius-sm)] px-3 py-1.5 text-sm font-semibold transition-colors @if($period === '7days') bg-[#ff750f] text-white @else bg-white text-[#1a1a1a] hover:bg-[#faf9f8] @endif">7 Hari</button>
                    <button type="submit" name="period" value="30days" class="rounded-[var(--radius-sm)] px-3 py-1.5 text-sm font-semibold transition-colors @if($period === '30days') bg-[#ff750f] text-white @else bg-white text-[#1a1a1a] hover:bg-[#faf9f8] @endif">30 Hari</button>
                </form>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="card p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Total Pendapatan</p>
                <p class="mt-2 text-3xl font-extrabold text-brand">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-text-muted">Selama {{ $days }} hari terakhir</p>
            </div>
            <div class="card p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Total Tiket Terjual</p>
                <p class="mt-2 text-3xl font-extrabold text-text">{{ $totalTickets }}</p>
                <p class="mt-1 text-xs text-text-muted">Booking CONFIRMED</p>
            </div>
            <div class="card p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Rata-rata/Tiket</p>
                <p class="mt-2 text-3xl font-extrabold text-text">Rp {{ number_format($avgTicket, 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-text-muted">Per tiket terjual</p>
            </div>
            <div class="card p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Periode</p>
                <p class="mt-2 text-3xl font-extrabold text-text">{{ $days }} Hari</p>
                <p class="mt-1 text-xs text-text-muted">{{ now()->subDays($days)->format('d M Y') }} – {{ now()->format('d M Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 mt-8 lg:grid-cols-2">
            {{-- Daily Revenue Chart --}}
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h2 class="text-lg font-bold">Pendapatan Harian</h2>
                    <p class="mt-1 text-sm text-[#555555]">Total pendapatan per hari berdasarkan status CONFIRMED.</p>

                    {{-- Bar Chart --}}
                    <div class="mt-6 flex items-end gap-1 overflow-x-auto pb-2" style="height: 200px;">
                        @foreach ($dailyRevenue as $date => $revenue)
                            @php
                                $maxRevenue = max($dailyRevenue);
                                $height = $maxRevenue > 0 ? ($revenue / $maxRevenue) * 100 : 0;
                                $label = \Carbon\Carbon::parse($date)->format('d M');
                            @endphp
                            <div class="flex min-w-[28px] flex-1 flex-col items-center" title="{{ $label }}: Rp {{ number_format($revenue, 0, ',', '.') }}">
                                <div class="w-full rounded-t bg-[#ff750f] transition-all duration-300 hover:opacity-80" style="height: {{ $height }}%; min-height: {{ $revenue > 0 ? '4px' : '0px' }};"></div>
                                <span class="mt-1 truncate text-[10px] text-text-muted">{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Ticket Sales Chart --}}
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h2 class="text-lg font-bold">Penjualan Tiket</h2>
                    <p class="mt-1 text-sm text-[#555555]">Jumlah tiket terjual per hari berdasarkan status CONFIRMED.</p>

                    {{-- Bar Chart --}}
                    <div class="mt-6 flex items-end gap-1 overflow-x-auto pb-2" style="height: 200px;">
                        @foreach ($dailyTicketCount as $date => $count)
                            @php
                                $maxCount = max($dailyTicketCount);
                                $height = $maxCount > 0 ? ($count / $maxCount) * 100 : 0;
                                $label = \Carbon\Carbon::parse($date)->format('d M');
                            @endphp
                            <div class="flex min-w-[28px] flex-1 flex-col items-center" title="{{ $label }}: {{ $count }} tiket">
                                <div class="w-full rounded-t bg-[#1a1a1a] transition-all duration-300 hover:opacity-80" style="height: {{ $height }}%; min-height: {{ $count > 0 ? '4px' : '0px' }};"></div>
                                <span class="mt-1 truncate text-[10px] text-text-muted">{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 mt-8 lg:grid-cols-2">
            {{-- Revenue by Service --}}
            <div class="card">
                <div class="card-body">
                    <h2 class="text-lg font-bold">Pendapatan per Layanan</h2>
                    @if ($revenueByService->isEmpty())
                        <p class="mt-4 text-sm text-[#555555]">Belum ada data.</p>
                    @else
                        <div class="mt-4 space-y-3">
                            @foreach ($revenueByService as $item)
                                @php
                                    $label = match($item->service_category) {
                                        'antibu' => 'ANTIBU',
                                        'satset' => 'SATSET',
                                        'biasane' => 'BIASANE',
                                        default => $item->service_category,
                                    };
                                    $percentage = $totalRevenue > 0 ? ($item->revenue / $totalRevenue) * 100 : 0;
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="font-semibold text-text">{{ $label }}</span>
                                        <span class="text-text-muted">Rp {{ number_format($item->revenue, 0, ',', '.') }} ({{ $item->ticket_count }} tiket)</span>
                                    </div>
                                    <div class="mt-1 h-2 rounded-full bg-border">
                                        <div class="h-full rounded-full bg-[#ff750f]" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Revenue by Class --}}
            <div class="card">
                <div class="card-body">
                    <h2 class="text-lg font-bold">Pendapatan per Kelas</h2>
                    @if ($revenueByClass->isEmpty())
                        <p class="mt-4 text-sm text-[#555555]">Belum ada data.</p>
                    @else
                        <div class="mt-4 space-y-3">
                            @foreach ($revenueByClass as $item)
                                @php
                                    $percentage = $totalRevenue > 0 ? ($item->revenue / $totalRevenue) * 100 : 0;
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="font-semibold text-text">{{ $item->class_name }}</span>
                                        <span class="text-text-muted">Rp {{ number_format($item->revenue, 0, ',', '.') }} ({{ $item->ticket_count }} tiket)</span>
                                    </div>
                                    <div class="mt-1 h-2 rounded-full bg-border">
                                        <div class="h-full rounded-full bg-[#ff750f]" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Top Routes --}}
        <div class="card mt-8 overflow-hidden">
            <div class="card-body">
                <h2 class="text-lg font-bold">Rute Terlaris</h2>
                @if ($topRoutes->isEmpty())
                    <p class="mt-4 text-sm text-[#555555]">Belum ada data.</p>
                @else
                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full min-w-[500px] text-left text-sm">
                            <thead>
                                <tr class="border-b border-[#e6e6e6] text-xs uppercase tracking-wider text-[#555555]">
                                    <th class="py-3 px-4 font-semibold">Rute</th>
                                    <th class="py-3 px-4 font-semibold">Tiket Terjual</th>
                                    <th class="py-3 px-4 font-semibold">Total Pendapatan</th>
                                    <th class="py-3 px-4 font-semibold">% Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topRoutes as $route)
                                    @php
                                        $percentage = $totalRevenue > 0 ? ($route->revenue / $totalRevenue) * 100 : 0;
                                    @endphp
                                    <tr class="border-b border-[#e6e6e6] last:border-0">
                                        <td class="py-3 px-4 font-semibold">{{ $route->origin_name }} → {{ $route->destination_name }}</td>
                                        <td class="py-3 px-4">{{ $route->ticket_count }}</td>
                                        <td class="py-3 px-4 font-bold">Rp {{ number_format($route->revenue, 0, ',', '.') }}</td>
                                        <td class="py-3 px-4">{{ number_format($percentage, 1) }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
