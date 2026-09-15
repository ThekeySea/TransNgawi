@extends('layouts.admin')

@section('title', 'Refund')

@section('content')
    <div class="container-app">
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Refund</h1>
                <p class="mt-2 text-base text-[#555555]">Daftar seluruh pengembalian dana dari pembatalan perjalanan.</p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card mb-6 p-4">
            <form action="{{ route('admin.refunds.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
                <div class="min-w-[200px]">
                    <label class="input-label">Tipe Refund</label>
                    <select name="type" class="select">
                        <option value="">Semua Tipe</option>
                        <option value="TRIP_CANCELLATION" {{ $activeType === 'TRIP_CANCELLATION' ? 'selected' : '' }}>Pembatalan Armada (Refund 100%)</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">Filter</button>
            </form>
        </div>

        {{-- Table --}}
        <div class="card overflow-hidden">
            @if ($refunds->isEmpty())
                <div class="flex flex-col items-center justify-center px-6 py-16 text-center">
                    <p class="text-sm text-[#555555]">Belum ada data refund.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#e6e6e6] text-xs uppercase tracking-wider text-[#555555]">
                                <th class="py-3 px-4 font-semibold">Kode Booking</th>
                                <th class="py-3 px-4 font-semibold">Penumpang</th>
                                <th class="py-3 px-4 font-semibold">Rute</th>
                                <th class="py-3 px-4 font-semibold">Total Bayar</th>
                                <th class="py-3 px-4 font-semibold">Refund</th>
                                <th class="py-3 px-4 font-semibold">Tipe</th>
                                <th class="py-3 px-4 font-semibold">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($refunds as $refund)
                                <tr class="border-b border-[#e6e6e6] last:border-0 hover:bg-[#faf9f8]">
                                    <td class="py-3 px-4 font-bold">{{ $refund->booking->code ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        <p class="font-semibold">{{ $refund->booking->passenger_name ?? '-' }}</p>
                                        <p class="text-xs text-[#555555]">{{ $refund->booking->passenger_email ?? '' }}</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ $refund->booking->trip->route->origin->name ?? '-' }} → {{ $refund->booking->trip->route->destination->name ?? '-' }}
                                        <p class="text-xs text-[#555555]">{{ $refund->booking->trip->departs_at?->format('d M Y') ?? '' }}</p>
                                    </td>
                                    <td class="py-3 px-4 font-bold">Rp {{ number_format($refund->booking->total ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4">
                                        <span class="font-bold text-red-600">Rp {{ number_format($refund->refund_amount, 0, ',', '.') }}</span>
                                        <span class="ml-1 text-xs text-[#555555]">({{ $refund->refund_percentage }}%)</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if ($refund->type === 'TRIP_CANCELLATION')
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">
                                                Pembatalan Armada
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-neutral-100 px-2.5 py-0.5 text-xs font-semibold text-neutral-600">
                                                {{ $refund->type }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-xs text-[#555555]">{{ $refund->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-[#e6e6e6] px-4 py-3">
                    {{ $refunds->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
