@extends('layouts.admin')

@section('title', 'Dasbor')

@section('content')
    <div class="container-app">
        <div class="mb-8 max-w-2xl">
            <h1 class="text-3xl font-bold tracking-tight">Dasbor Admin</h1>
            <p class="mt-2 text-base text-[#555555]">Kelola lokasi, bus, dan trip TransNgawi.</p>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="card p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Lokasi</p>
                <p class="mt-2 text-4xl font-extrabold">{{ $locationCount }}</p>
                <a href="{{ route('admin.locations.index') }}" class="mt-4 inline-block text-sm font-semibold text-[#ff750f] hover:underline">Kelola lokasi &rarr;</a>
            </div>
            <div class="card p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Bus</p>
                <p class="mt-2 text-4xl font-extrabold">{{ $busCount }}</p>
                <a href="{{ route('admin.buses.index') }}" class="mt-4 inline-block text-sm font-semibold text-[#ff750f] hover:underline">Kelola bus &rarr;</a>
            </div>
            <div class="card p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#555555]">Trip</p>
                <p class="mt-2 text-4xl font-extrabold">{{ $tripCount }}</p>
                <a href="{{ route('admin.trips.index') }}" class="mt-4 inline-block text-sm font-semibold text-[#ff750f] hover:underline">Kelola trip &rarr;</a>
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
