@extends('layouts.admin')

@section('title', 'Dasbor')

@section('content')
    <div class="container-app">
        <div class="mb-8 max-w-2xl">
            <h1 class="text-3xl font-bold tracking-tight">Dasbor Admin</h1>
            <p class="mt-2 text-base text-[#555555]">Kelola lokasi, bus, trip, transaksi, dan bantuan TransNgawi.</p>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="card p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Lokasi</p>
                <p class="mt-2 text-4xl font-extrabold">{{ $locationCount }}</p>
                <a href="{{ route('admin.locations.index') }}" class="mt-4 inline-block text-sm font-semibold text-[#ff750f] hover:underline">Kelola lokasi &rarr;</a>
            </div>
            <div class="card p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Bus</p>
                <p class="mt-2 text-4xl font-extrabold">{{ $busCount }}</p>
                <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold">
                    <span class="rounded-full bg-green-100 px-2 py-0.5 text-green-700">{{ $idleBusCount }} Tersedia</span>
                    <span class="rounded-full bg-blue-100 px-2 py-0.5 text-blue-700">{{ $activeBusCount }} Aktif</span>
                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-amber-700">{{ $maintenanceBusCount }} Perawatan</span>
                </div>
                <div class="mt-3 flex flex-wrap gap-3">
                    <a href="{{ route('admin.buses.index') }}" class="text-sm font-semibold text-[#ff750f] hover:underline">Kelola bus &rarr;</a>
                    @if ($openIssueCount > 0)
                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-bold text-red-700">{{ $openIssueCount }} masalah terbuka</span>
                    @endif
                </div>
            </div>
            <div class="card p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Trip</p>
                <p class="mt-2 text-4xl font-extrabold">{{ $tripCount }}</p>
                <a href="{{ route('admin.trips.index') }}" class="mt-4 inline-block text-sm font-semibold text-[#ff750f] hover:underline">Kelola trip &rarr;</a>
            </div>

            {{-- Transaksi --}}
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Transaksi</p>
                    @if ($pendingTransactionCount > 0)
                        <span class="flex h-6 min-w-[24px] items-center justify-center rounded-full bg-amber-100 px-2 text-xs font-bold text-amber-700">
                            {{ $pendingTransactionCount }}
                        </span>
                    @endif
                </div>
                <p class="mt-2 text-4xl font-extrabold">{{ $transactionCount }}</p>
                <a href="{{ route('admin.transactions.index') }}" class="mt-4 inline-block text-sm font-semibold text-[#ff750f] hover:underline">Kelola transaksi &rarr;</a>
            </div>

            {{-- Bantuan --}}
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Bantuan</p>
                    @if ($pendingHelpCount > 0)
                        <span class="flex h-6 min-w-[24px] items-center justify-center rounded-full bg-red-100 px-2 text-xs font-bold text-red-700">
                            {{ $pendingHelpCount }}
                        </span>
                    @endif
                </div>
                <p class="mt-2 text-4xl font-extrabold">{{ $pendingHelpCount }}</p>
                <a href="{{ route('admin.help.index') }}" class="mt-4 inline-block text-sm font-semibold text-[#ff750f] hover:underline">Kelola bantuan &rarr;</a>
            </div>

            {{-- Analisa --}}
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Analisa</p>
                    <span class="flex h-6 min-w-[24px] items-center justify-center rounded-full bg-green-100 px-2 text-xs font-bold text-green-700">Aktif</span>
                </div>
                <p class="mt-2 text-4xl font-extrabold">Lihat</p>
                <a href="{{ route('admin.analisa.index') }}" class="mt-4 inline-block text-sm font-semibold text-[#ff750f] hover:underline">Buka Analisa &rarr;</a>
            </div>
        </div>

        <div class="card mt-8 p-6 md:p-8">
            <div class="mb-4 flex items-center justify-between gap-4">
                <h2 class="text-xl font-bold">Trip Terbaru</h2>
                <a href="{{ route('admin.trips.create', ['step' => 1]) }}" class="btn-primary">Buat Trip</a>
            </div>

            @if ($recentTrips->isEmpty())
                <p class="text-sm text-[#555555]">Belum ada trip. Buat trip pertama lewat wizard 4 langkah.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#e6e6e6] text-xs uppercase tracking-wider text-[#555555]">
                                <th class="py-3 pr-4 font-semibold">Rute</th>
                                <th class="py-3 pr-4 font-semibold">Layanan</th>
                                <th class="py-3 pr-4 font-semibold">Bus</th>
                                <th class="py-3 font-semibold">Berangkat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentTrips as $trip)
                                <tr class="border-b border-[#e6e6e6] last:border-0">
                                    <td class="py-3 pr-4 font-semibold">{{ $trip->route->origin->name }} &rarr; {{ $trip->route->destination->name }}</td>
                                    <td class="py-3 pr-4">{{ $trip->route->service_category->name }}</td>
                                    <td class="py-3 pr-4">{{ $trip->bus->plate_number }}</td>
                                    <td class="py-3">{{ $trip->departs_at?->format('d M Y H:i') ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
