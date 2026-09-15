@extends('layouts.customer')

@section('title', 'Detail Tiket — ' . $booking->code)

@section('content')
    <section class="section-spacing bg-surface">
        <div class="container-app">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-text sm:text-3xl">Detail Tiket</h1>
                <p class="mt-2 text-sm text-text-muted">Kode booking: <strong class="text-text">{{ $booking->code }}</strong></p>
            </div>

            @if (session('status'))
                <div class="mb-6 rounded-[var(--radius-sm)] border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Cancellation Warning Banner --}}
                    @if ($booking->status === 'CANCELLED_BY_ADMIN')
                        <div class="rounded-[var(--radius-sm)] bg-red-600 p-5 text-white">
                            <div class="flex items-start gap-4">
                                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/20">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div>
                                    <p class="text-base font-bold">Perjalanan Dibatalkan oleh Operator</p>
                                    <p class="mt-1 text-sm text-red-100">Mohon maaf, perjalanan ini dibatalkan karena kendala operasional. Tiket Anda otomatis diproses untuk Pengembalian Dana (Refund 100%) sebesar <strong class="text-white">Rp {{ number_format($booking->total, 0, ',', '.') }}</strong>.</p>
                                    <div class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-bold">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                        DIBATALKAN (REFUND 100%)
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Status Banner --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="flex items-center gap-4">
                                @php
                                    $statusConfig = match($booking->status) {
                                        'CONFIRMED' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'icon' => 'text-green-600', 'label' => 'Terkonfirmasi', 'desc' => 'Pembayaran telah dikonfirmasi. Tiket Anda aktif.'],
                                        'WAITING_VERIFICATION' => ['bg' => 'bg-amber-50', 'border' => 'border-amber-200', 'icon' => 'text-amber-600', 'label' => 'Menunggu Verifikasi', 'desc' => 'Pembayaran Anda sedang diverifikasi oleh admin.'],
                                        'HELD' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'icon' => 'text-blue-600', 'label' => 'Ditahan', 'desc' => 'Kursi Anda ditahan. Selesaikan pembayaran sebelum waktu habis.'],
                                        'EXPIRED' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'icon' => 'text-red-600', 'label' => 'Kadaluarsa', 'desc' => 'Pemesanan telah kedaluwarsa.'],
                                        'CANCELLED' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'icon' => 'text-red-600', 'label' => 'Dibatalkan (Refund 100%)', 'desc' => 'Anda telah membatalkan tiket ini. Pengembalian dana 100% akan diproses dalam 1-3 hari kerja.'],
                                        'CANCELLED_BY_ADMIN' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'icon' => 'text-red-600', 'label' => 'Dibatalkan (Perjalanan Dibatalkan)', 'desc' => 'Perjalanan dibatalkan oleh admin. Seluruh pembayaran akan direfund 100%.'],
                                        default => ['bg' => 'bg-neutral-50', 'border' => 'border-neutral-200', 'icon' => 'text-neutral-600', 'label' => $booking->status, 'desc' => ''],
                                    };
                                @endphp
                                <div class="flex h-12 w-12 items-center justify-center rounded-full {{ $statusConfig['bg'] }}">
                                    @if ($booking->status === 'CONFIRMED')
                                        <svg class="h-6 w-6 {{ $statusConfig['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @elseif ($booking->status === 'WAITING_VERIFICATION')
                                        <svg class="h-6 w-6 {{ $statusConfig['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @elseif ($booking->status === 'HELD')
                                        <svg class="h-6 w-6 {{ $statusConfig['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @elseif ($booking->status === 'CANCELLED')
                                        <svg class="h-6 w-6 {{ $statusConfig['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    @elseif ($booking->status === 'CANCELLED_BY_ADMIN')
                                        <svg class="h-6 w-6 {{ $statusConfig['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    @else
                                        <svg class="h-6 w-6 {{ $statusConfig['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-text">{{ $statusConfig['label'] }}</p>
                                    <p class="text-sm text-text-muted">{{ $statusConfig['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Trip Info --}}
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-lg font-bold text-text">Informasi Perjalanan</h3>
                            <dl class="mt-4 space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-text-muted">Rute</dt>
                                    <dd class="font-semibold text-text">{{ $booking->trip->route->origin->name }} → {{ $booking->trip->route->destination->name }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-text-muted">Tanggal</dt>
                                    <dd class="font-semibold text-text">{{ $booking->trip->departs_at->format('d M Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-text-muted">Waktu</dt>
                                    <dd class="font-semibold text-text">{{ $booking->trip->departs_at->format('H:i') }} – {{ $booking->trip->arrives_at->format('H:i') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-text-muted">Layanan</dt>
                                    <dd class="font-semibold text-text">{{ $booking->trip->route->service_category->label() }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-text-muted">Kelas</dt>
                                    <dd class="font-semibold text-text">{{ $booking->trip->bus->model_type->value }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-text-muted">Bus</dt>
                                    <dd class="font-semibold text-text">{{ $booking->trip->bus->plate_number }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Passenger & Seats --}}
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-lg font-bold text-text">Penumpang & Kursi</h3>
                            <dl class="mt-4 space-y-3 text-sm">
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
                                <div class="flex justify-between">
                                    <dt class="text-text-muted">Kursi</dt>
                                    <dd class="font-semibold text-text">{{ $booking->seats->pluck('seat_code')->implode(', ') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Payment Summary --}}
                    <div class="card sticky top-24">
                        <div class="card-body">
                            <h3 class="text-lg font-bold text-text">Ringkasan Pembayaran</h3>
                            <dl class="mt-4 space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-text-muted">Subtotal</dt>
                                    <dd class="font-semibold text-text">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</dd>
                                </div>
                                <div class="flex justify-between border-t border-border pt-3">
                                    <dt class="text-base font-semibold text-text">Total</dt>
                                    <dd class="text-xl font-bold text-brand">Rp {{ number_format($booking->total, 0, ',', '.') }}</dd>
                                </div>
                            </dl>

                            @if ($booking->status === 'HELD')
                                <div class="mt-4 rounded-[var(--radius-sm)] border border-amber-200 bg-amber-50 p-3">
                                    <p class="text-xs font-semibold text-amber-800">Selesaikan pembayaran sebelum waktu habis.</p>
                                </div>
                                <a href="{{ route('booking.payment', $booking) }}" class="btn-primary mt-4 w-full">
                                    Bayar Sekarang
                                </a>
                            @endif

                            @if ($booking->status === 'WAITING_VERIFICATION')
                                <div class="mt-4 flex items-center gap-2 rounded-[var(--radius-sm)] border border-amber-200 bg-amber-50 p-3">
                                    <svg class="h-4 w-4 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-xs text-amber-700">Menunggu verifikasi admin.</p>
                                </div>
                            @endif

                            @if ($booking->status === 'CONFIRMED')
                                <a href="{{ route('tickets.show', $booking->code) }}" class="btn-primary mt-4 w-full">
                                    Lihat E-Ticket
                                </a>
                                <form method="POST" action="{{ route('track.cancel', $booking->code) }}" onsubmit="return confirm('Batalkan tiket ini? Pengembalian dana 100% akan diproses dalam 1-3 hari kerja.')" class="mt-3">
                                    @csrf
                                    <button type="submit" class="inline-flex w-full items-center justify-center gap-1.5 rounded-[var(--radius-sm)] border border-red-300 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition-all hover:bg-red-50">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Batal Tiket
                                    </button>
                                </form>
                            @endif

                            @if ($booking->status === 'CANCELLED_BY_ADMIN')
                                <a href="{{ route('invoice.view', $booking->code) }}" class="btn-secondary mt-4 w-full">
                                    Lihat Invoice (Refund)
                                </a>
                            @endif

                            @if (in_array($booking->status, ['WAITING_VERIFICATION', 'HELD']))
                                <form method="POST" action="{{ route('track.cancel', $booking->code) }}" onsubmit="return confirm('Batalkan tiket ini? Pengembalian dana 100% akan diproses dalam 1-3 hari kerja.')" class="mt-3">
                                    @csrf
                                    <button type="submit" class="inline-flex w-full items-center justify-center gap-1.5 rounded-[var(--radius-sm)] border border-red-300 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition-all hover:bg-red-50">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Batal Tiket
                                    </button>
                                </form>
                            @endif

                            <div class="mt-6 border-t border-border pt-4">
                                <a href="{{ route('my-trips.index') }}" class="text-sm font-semibold text-brand hover:underline">Lihat tiket saya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
