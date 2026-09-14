@extends('layouts.admin')

@section('title', 'Transaksi')

@section('content')
    <div class="container-app">
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Transaksi</h1>
                <p class="mt-2 text-base text-[#555555]">Kelola pembayaran dan verifikasi tiket.</p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card mb-6 p-4">
            <form action="{{ route('admin.transactions.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-[200px]">
                    <label class="input-label">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode, nama, atau email..." class="input">
                </div>
                <div class="min-w-[160px]">
                    <label class="input-label">Status</label>
                    <select name="status" class="select">
                        <option value="">Semua Status</option>
                        <option value="HELD" {{ request('status') === 'HELD' ? 'selected' : '' }}>Ditahan</option>
                        <option value="WAITING_VERIFICATION" {{ request('status') === 'WAITING_VERIFICATION' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="CONFIRMED" {{ request('status') === 'CONFIRMED' ? 'selected' : '' }}>Terkonfirmasi</option>
                        <option value="REJECTED" {{ request('status') === 'REJECTED' ? 'selected' : '' }}>Ditolak</option>
                        <option value="EXPIRED" {{ request('status') === 'EXPIRED' ? 'selected' : '' }}>Kadaluarsa</option>
                        <option value="CANCELLED" {{ request('status') === 'CANCELLED' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">Filter</button>
            </form>
        </div>

        {{-- Table --}}
        <div class="card overflow-hidden">
            @if ($bookings->isEmpty())
                <div class="flex flex-col items-center justify-center px-6 py-16 text-center">
                    <p class="text-sm text-[#555555]">Tidak ada transaksi ditemukan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#e6e6e6] text-xs uppercase tracking-wider text-[#555555]">
                                <th class="py-3 px-4 font-semibold">Kode</th>
                                <th class="py-3 px-4 font-semibold">Penumpang</th>
                                <th class="py-3 px-4 font-semibold">Rute</th>
                                <th class="py-3 px-4 font-semibold">Total</th>
                                <th class="py-3 px-4 font-semibold">Status</th>
                                <th class="py-3 px-4 font-semibold">Tanggal</th>
                                <th class="py-3 px-4 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr class="border-b border-[#e6e6e6] last:border-0 hover:bg-[#faf9f8]">
                                    <td class="py-3 px-4 font-bold">{{ $booking->code }}</td>
                                    <td class="py-3 px-4">
                                        <p class="font-semibold">{{ $booking->passenger_name }}</p>
                                        <p class="text-xs text-[#555555]">{{ $booking->passenger_email }}</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ $booking->trip->route->origin->name }} → {{ $booking->trip->route->destination->name }}
                                        <p class="text-xs text-[#555555]">{{ $booking->trip->departs_at->format('d M Y') }}</p>
                                    </td>
                                    <td class="py-3 px-4 font-bold">Rp {{ number_format($booking->total, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4">
                                        @php
                                            $badgeClass = match($booking->status) {
                                                'CONFIRMED' => 'bg-green-100 text-green-700',
                                                'WAITING_VERIFICATION' => 'bg-amber-100 text-amber-700',
                                                'HELD' => 'bg-blue-100 text-blue-700',
                                                'REJECTED' => 'bg-red-100 text-red-700',
                                                'EXPIRED', 'CANCELLED' => 'bg-neutral-100 text-neutral-600',
                                                default => 'bg-neutral-100 text-neutral-600',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badgeClass }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-xs text-[#555555]">{{ $booking->created_at->format('d M Y H:i') }}</td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('admin.transactions.show', $booking) }}" class="text-sm font-semibold text-[#ff750f] hover:underline">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-[#e6e6e6] px-4 py-3">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
