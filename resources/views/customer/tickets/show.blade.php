@extends('layouts.customer')

@section('title', 'E-Ticket — ' . $booking->code)

@section('content')
    <section class="section-spacing bg-surface">
        <div class="container-app">
            <div class="mx-auto max-w-2xl">
                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold text-text sm:text-3xl">E-Ticket TransNgawi</h1>
                    <p class="mt-2 text-sm text-text-muted">Tunjukkan tiket ini saat boarding.</p>
                </div>

                {{-- Ticket Card --}}
                <div class="card overflow-hidden">
                    {{-- Cancellation Warning Banner --}}
                    @if ($booking->status === 'CANCELLED_BY_ADMIN')
                        <div class="bg-red-600 px-6 py-4">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white">Perjalanan Dibatalkan oleh Operator</p>
                                    <p class="mt-1 text-xs text-red-100">Mohon maaf, perjalanan ini dibatalkan karena kendala operasional. Tiket Anda otomatis diproses untuk Pengembalian Dana (Refund 100%) sebesar Rp {{ number_format($booking->total, 0, ',', '.') }}.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Header --}}
                    <div class="bg-brand px-6 py-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider opacity-80">TransNgawi</p>
                                <p class="mt-1 text-lg font-bold">{{ $booking->code }}</p>
                            </div>
                            <div class="text-right">
                                @if ($booking->status === 'CANCELLED_BY_ADMIN')
                                    <span class="inline-flex items-center rounded-full bg-white/20 px-2.5 py-0.5 text-xs font-bold text-white">DIBATALKAN (REFUND 100%)</span>
                                @else
                                    <p class="text-xs font-semibold uppercase tracking-wider opacity-80">Kelas</p>
                                    <p class="mt-1 text-lg font-bold">{{ $booking->trip->bus->model_type->value }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Route --}}
                    <div class="border-b border-border px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div class="text-center">
                                <p class="text-2xl font-extrabold text-text">{{ $booking->trip->departs_at->format('H:i') }}</p>
                                <p class="mt-1 text-sm font-semibold text-text-muted">{{ $booking->trip->route->origin->name }}</p>
                            </div>
                            <div class="flex flex-col items-center px-4">
                                <div class="h-px w-16 bg-border"></div>
                                <svg class="my-1 h-5 w-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                <div class="h-px w-16 bg-border"></div>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-extrabold text-text">{{ $booking->trip->arrives_at->format('H:i') }}</p>
                                <p class="mt-1 text-sm font-semibold text-text-muted">{{ $booking->trip->route->destination->name }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="px-6 py-5">
                        <dl class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <dt class="text-text-muted">Tanggal</dt>
                                <dd class="mt-1 font-bold text-text">{{ $booking->trip->departs_at->format('d M Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-text-muted">Layanan</dt>
                                <dd class="mt-1 font-bold text-text">{{ $booking->trip->route->service_category->label() }}</dd>
                            </div>
                            <div>
                                <dt class="text-text-muted">Bus</dt>
                                <dd class="mt-1 font-bold text-text">{{ $booking->trip->bus->plate_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-text-muted">Kursi</dt>
                                <dd class="mt-1 font-bold text-text">{{ $booking->seats->pluck('seat_code')->implode(', ') }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Passengers --}}
                    <div class="border-t border-border px-6 py-5">
                        <h3 class="text-sm font-bold text-text">Penumpang</h3>
                        <dl class="mt-3 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-text-muted">Nama</dt>
                                <dd class="font-semibold text-text">{{ $booking->passenger_name }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">Email</dt>
                                <dd class="font-semibold text-text">{{ $booking->passenger_email }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-text-muted">Telepon</dt>
                                <dd class="font-semibold text-text">{{ $booking->passenger_phone }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Payment --}}
                    <div class="border-t border-border px-6 py-5">
                        <dl class="flex items-center justify-between text-sm">
                            <div>
                                <dt class="text-text-muted">Status Pembayaran</dt>
                                <dd class="mt-1">
                                    @if ($booking->status === 'CANCELLED_BY_ADMIN')
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">
                                            Dibatalkan (Refund 100%)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800">
                                            Terkonfirmasi
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div class="text-right">
                                <dt class="text-text-muted">Total Dibayar</dt>
                                <dd class="mt-1 text-xl font-bold text-brand">Rp {{ number_format($booking->total, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Footer --}}
                    <div class="border-t border-border bg-surface px-6 py-4">
                        @if ($booking->status === 'CANCELLED_BY_ADMIN')
                            <p class="text-center text-xs text-red-600 font-semibold">
                                Perjalanan ini telah dibatalkan. Tiket tidak berlaku untuk boarding. Refund sedang diproses.
                            </p>
                        @else
                            <p class="text-center text-xs text-text-muted">
                                Datang 30 menit sebelum keberangkatan. Tunjukkan tiket ini di loket boarding.
                            </p>
                        @endif
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                    <a href="{{ route('home') }}" class="btn-secondary">Kembali ke Beranda</a>
                    <a href="{{ route('track.show', $booking->code) }}" class="btn-secondary">Lihat Detail Booking</a>
                    <a href="{{ route('invoice.download', $booking->code) }}" class="btn-primary">
                        <svg class="mr-1.5 inline h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Unduh Invoice
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
