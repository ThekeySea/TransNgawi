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

        {{-- Filter --}}
        <div class="mb-4 flex flex-wrap gap-2">
            <a href="{{ route('admin.trips.index') }}" class="rounded-full px-3 py-1.5 text-xs font-semibold transition-all {{ !$activeService ? 'bg-[#ff750f] text-white' : 'bg-[#e6e6e6] text-[#555555] hover:bg-[#ff750f]/10' }}">Semua</a>
            @foreach (\App\Enums\ServiceCategory::cases() as $service)
                <a href="{{ route('admin.trips.index', ['service' => $service->value]) }}" class="rounded-full px-3 py-1.5 text-xs font-semibold transition-all {{ $activeService === $service->value ? 'bg-[#ff750f] text-white' : 'bg-[#e6e6e6] text-[#555555] hover:bg-[#ff750f]/10' }}">{{ $service->name }}</a>
            @endforeach
        </div>

        <div class="card overflow-hidden">
            @if ($trips->isEmpty())
                <p class="p-6 text-sm text-[#555555] md:p-8">Belum ada trip. Buat trip pertama lewat wizard 5 langkah.</p>
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
                                <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trips as $trip)
                                <tr class="border-b border-[#e6e6e6] last:border-0">
                                    <td class="px-6 py-3 font-semibold">{{ $trip->route->origin->name }} &rarr; {{ $trip->route->destination->name }}</td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold
                                            @if($trip->route->service_category->value === 'antibu') bg-blue-100 text-blue-700
                                            @elseif($trip->route->service_category->value === 'satset') bg-amber-100 text-amber-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ strtoupper($trip->route->service_category->name) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">{{ $trip->bus->plate_number }}</td>
                                    <td class="px-6 py-3">{{ $trip->departs_at?->format('d M Y H:i') ?? '-' }}</td>
                                    <td class="px-6 py-3">{{ $trip->fares_count }} kelas</td>
                                    <td class="px-6 py-3">{{ $trip->seats_count }} kursi</td>
                                    <td class="px-6 py-3">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.trips.edit', $trip) }}" class="btn-secondary px-3 py-1.5 text-xs">Ubah</a>
                                            <form method="POST" action="{{ route('admin.trips.destroy', $trip) }}" onsubmit="return confirm('Hapus trip ini? Kursi yang sudah terjual tidak akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-secondary px-3 py-1.5 text-xs">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
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
