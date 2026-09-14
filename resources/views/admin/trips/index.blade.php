@extends('layouts.admin')

@section('title', 'Trip')

@section('content')
    <div class="container-app">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div class="max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight">Trip</h1>
                <p class="mt-2 text-base text-[#555555]">Jadwal perjalanan beserta harga dan kursi yang digenerate dari template bus.</p>
            </div>
            <a href="{{ route('admin.trips.create', ['step' => 1]) }}" class="btn-primary">Buat Trip</a>
        </div>

        <div class="card overflow-hidden">
            @if ($trips->isEmpty())
                <p class="p-6 text-sm text-[#555555] md:p-8">Belum ada trip. Buat trip pertama lewat wizard 4 langkah.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[760px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#e6e6e6] text-xs uppercase tracking-wider text-[#555555]">
                                <th class="px-6 py-3 font-semibold">Rute</th>
                                <th class="px-6 py-3 font-semibold">Layanan</th>
                                <th class="px-6 py-3 font-semibold">Bus</th>
                                <th class="px-6 py-3 font-semibold">Berangkat</th>
                                <th class="px-6 py-3 font-semibold">Harga</th>
                                <th class="px-6 py-3 font-semibold">Kursi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trips as $trip)
                                <tr class="border-b border-[#e6e6e6] last:border-0">
                                    <td class="px-6 py-3 font-semibold">{{ $trip->route->origin->name }} &rarr; {{ $trip->route->destination->name }}</td>
                                    <td class="px-6 py-3">{{ $trip->route->service_category->name }}</td>
                                    <td class="px-6 py-3">{{ $trip->bus->plate_number }}</td>
                                    <td class="px-6 py-3">{{ $trip->departs_at?->format('d M Y H:i') ?? '-' }}</td>
                                    <td class="px-6 py-3">{{ $trip->fares_count }} kelas</td>
                                    <td class="px-6 py-3">{{ $trip->seats_count }} kursi</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-[#e6e6e6] px-6 py-4">
                    {{ $trips->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
