@extends('layouts.admin')

@section('title', 'Bus')

@section('content')
    <div class="container-app">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div class="max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight">Bus</h1>
                <p class="mt-2 text-base text-[#555555]">Model menentukan template kursi trip: BIASANE 40 kursi, ANTIBU/SATSET 30 kursi. Bus hanya bisa ditugaskan ke trip baru saat berstatus Tersedia (IDLE).</p>
            </div>
            <a href="{{ route('admin.buses.create') }}" class="btn-primary">Tambah Bus</a>
        </div>

        <div class="card overflow-hidden">
            @if ($buses->isEmpty())
                <p class="p-6 text-sm text-[#555555] md:p-8">Belum ada bus. Tambahkan bus pertama.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[760px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#e6e6e6] text-xs uppercase tracking-wider text-[#555555]">
                                <th class="px-6 py-3 font-semibold">Pelat</th>
                                <th class="px-6 py-3 font-semibold">Model</th>
                                <th class="px-6 py-3 font-semibold">Status</th>
                                <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buses as $bus)
                                <tr class="border-b border-[#e6e6e6] last:border-0">
                                    <td class="px-6 py-3 font-semibold">{{ $bus->plate_number }}</td>
                                    <td class="px-6 py-3">{{ $bus->model_type->label() }}</td>
                                    <td class="px-6 py-3">
                                        @php
                                            $color = match($bus->status) {
                                                \App\Enums\BusStatus::IDLE => 'green',
                                                \App\Enums\BusStatus::ACTIVE => 'blue',
                                                \App\Enums\BusStatus::MAINTENANCE => 'amber',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold bg-{{ $color }}-100 text-{{ $color }}-700">
                                            {{ $bus->status->label() }}
                                        </span>
                                        @if ($bus->status === \App\Enums\BusStatus::ACTIVE && isset($bus->upcomingTrip) && $bus->upcomingTrip)
                                            <span class="ml-1 text-[10px] text-[#555555]" title="{{ $bus->upcomingTrip->route->origin->name ?? '' }} → {{ $bus->upcomingTrip->route->destination->name ?? '' }} ({{ $bus->upcomingTrip->departs_at?->format('d M Y H:i') ?? '' }})">
                                                🚌 Trip #{{ $bus->upcomingTrip->id }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="flex justify-end gap-2">
                                            {{-- Quick status change --}}
                                            <form method="POST" action="{{ route('admin.buses.update-status', $bus) }}" class="inline-flex">
                                                @csrf
                                                @method('PATCH')
                                                @php
                                                    $hasUpcomingTrips = $bus->status === \App\Enums\BusStatus::ACTIVE
                                                        && isset($bus->upcomingTrip) && $bus->upcomingTrip;
                                                @endphp
                                                <select name="status" onchange="this.form.submit()" class="rounded-[var(--radius-sm)] border border-[#e6e6e6] bg-white px-2 py-1 text-xs font-semibold focus:border-[#ff750f] focus:outline-none focus:ring-2 focus:ring-[#ff750f]/20">
                                                    @foreach (\App\Enums\BusStatus::cases() as $status)
                                                        @php
                                                            $disabled = $status === \App\Enums\BusStatus::IDLE && $hasUpcomingTrips;
                                                        @endphp
                                                        <option value="{{ $status->value }}" @selected($bus->status === $status) @disabled($disabled)>
                                                            {{ $status->label() }}{{ $disabled ? ' (ada trip)' : '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                            <a href="{{ route('admin.buses.edit', $bus) }}" class="btn-secondary px-3 py-1.5 text-xs">Ubah</a>
                                            <form method="POST" action="{{ route('admin.buses.destroy', $bus) }}" onsubmit="return confirm('Hapus bus ini?')">
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
                    {{ $buses->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
