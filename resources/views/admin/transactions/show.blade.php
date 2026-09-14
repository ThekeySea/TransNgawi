@extends('layouts.admin')

@section('title', 'Detail Transaksi — ' . $booking->code)

@section('content')
    <div class="container-app">
        <div class="mb-6">
            <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-[#ff750f] hover:underline">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Transaksi
            </a>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-[var(--radius-sm)] border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            {{-- Main --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Status & Actions --}}
                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <h1 class="text-2xl font-bold">Transaksi {{ $booking->code }}</h1>
                                <p class="mt-1 text-sm text-[#555555]">
                                    Dibuat {{ $booking->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
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
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $badgeClass }}">
                                {{ $booking->status }}
                            </span>
                        </div>

                        @if (in_array($booking->status, ['WAITING_VERIFICATION']))
                            <div class="mt-6 flex gap-3">
                                <form action="{{ route('admin.transactions.approve', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-[var(--radius-sm)] bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition-all hover:bg-green-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Setujui Pembayaran
                                    </button>
                                </form>
                                <form action="{{ route('admin.transactions.reject', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-[var(--radius-sm)] border border-red-300 bg-white px-5 py-2.5 text-sm font-semibold text-red-600 transition-all hover:bg-red-50">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if ($booking->status === 'CONFIRMED')
                            <div class="mt-6 flex gap-3">
                                <a href="{{ route('invoice.view', $booking->code) }}" target="_blank" class="inline-flex items-center gap-2 rounded-[var(--radius-sm)] border border-[#e6e6e6] bg-white px-5 py-2.5 text-sm font-semibold text-[#1a1a1a] transition-all hover:bg-[#faf9f8]">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Invoice
                                </a>
                                <a href="{{ route('invoice.download', $booking->code) }}" class="inline-flex items-center gap-2 rounded-[var(--radius-sm)] bg-[#ff750f] px-5 py-2.5 text-sm font-semibold text-white transition-all hover:bg-[#e66a0e]">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Unduh Invoice PDF
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Trip Info --}}
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-bold">Informasi Perjalanan</h3>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Rute</dt>
                                <dd class="font-semibold">{{ $booking->trip->route->origin->name }} → {{ $booking->trip->route->destination->name }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Tanggal</dt>
                                <dd class="font-semibold">{{ $booking->trip->departs_at->format('d M Y') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Waktu</dt>
                                <dd class="font-semibold">{{ $booking->trip->departs_at->format('H:i') }} – {{ $booking->trip->arrives_at->format('H:i') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Layanan</dt>
                                <dd class="font-semibold">{{ $booking->trip->route->service_category->label() }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Kelas</dt>
                                <dd class="font-semibold">{{ $booking->trip->bus->model_type->value }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Bus</dt>
                                <dd class="font-semibold">{{ $booking->trip->bus->plate_number }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Passenger --}}
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-lg font-bold">Penumpang & Kursi</h3>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Nama</dt>
                                <dd class="font-semibold">{{ $booking->passenger_name }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Email</dt>
                                <dd class="font-semibold">{{ $booking->passenger_email }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Telepon</dt>
                                <dd class="font-semibold">{{ $booking->passenger_phone }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Kursi</dt>
                                <dd class="font-semibold">{{ $booking->seats->pluck('seat_code')->implode(', ') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Catatan Pembayaran</dt>
                                <dd class="font-semibold">{{ $booking->payment_note ?: '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="card sticky top-24">
                    <div class="card-body">
                        <h3 class="text-lg font-bold">Ringkasan Pembayaran</h3>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-[#555555]">Subtotal</dt>
                                <dd class="font-semibold">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between border-t border-[#e6e6e6] pt-3">
                                <dt class="text-base font-semibold">Total</dt>
                                <dd class="text-xl font-bold text-[#ff750f]">Rp {{ number_format($booking->total, 0, ',', '.') }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-[#555555]">Status</span>
                                <span class="font-semibold">{{ $booking->status }}</span>
                            </div>
                            @if ($booking->paid_at)
                                <div class="flex justify-between">
                                    <span class="text-[#555555]">Dibayar</span>
                                    <span class="font-semibold">{{ $booking->paid_at->format('d M Y H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
