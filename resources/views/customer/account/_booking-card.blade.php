@php
    $isPast = $booking->trip->departs_at->isPast();
    $isCancelled = in_array($booking->status, ['CANCELLED', 'CANCELLED_BY_ADMIN']);
    $isTripCompleted = $booking->trip->status?->value === 'COMPLETED';
    $canCancel = ! $isCancelled && ! $isTripCompleted && in_array($booking->status, ['CONFIRMED', 'WAITING_VERIFICATION', 'HELD']);
    $statusLabel = match($booking->status) {
        'CONFIRMED' => $isPast ? 'Selesai' : 'Terkonfirmasi',
        'WAITING_VERIFICATION' => 'Menunggu Verifikasi',
        'HELD' => 'Ditahan',
        'EXPIRED' => 'Kadaluarsa',
        'CANCELLED' => 'Dibatalkan (Refund 100%)',
        'CANCELLED_BY_ADMIN' => 'Dibatalkan (Refund 100%)',
        default => $booking->status,
    };
    $statusColor = match($booking->status) {
        'CONFIRMED' => $isPast ? 'bg-[#555555]/10 text-[#555555]' : 'bg-green-100 text-green-700',
        'WAITING_VERIFICATION' => 'bg-amber-100 text-amber-700',
        'HELD' => 'bg-blue-100 text-blue-700',
        'EXPIRED' => 'bg-red-100 text-red-700',
        'CANCELLED' => 'bg-red-100 text-red-700',
        'CANCELLED_BY_ADMIN' => 'bg-red-100 text-red-700',
        default => 'bg-[#e6e6e6] text-[#555555]',
    };
    $seatList = $booking->seats->pluck('seat_code')->implode(', ');
@endphp

<div class="card overflow-hidden">
    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-[#e6e6e6] px-6 py-4 md:px-8">
        <div>
            <p class="text-sm font-bold text-[#1a1a1a]">{{ $booking->code }}</p>
            <p class="mt-0.5 text-xs text-[#555555]">{{ $booking->trip->trip_code }}</p>
        </div>
        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold {{ $statusColor }}">
            {{ $statusLabel }}
        </span>
    </div>

    {{-- Route & Time --}}
    <div class="px-6 py-5 md:px-8">
        <div class="flex items-center justify-between">
            <div class="text-center">
                <p class="text-2xl font-extrabold text-[#1a1a1a]">{{ $booking->trip->departs_at->format('H:i') }}</p>
                <p class="mt-1 text-sm font-semibold text-[#555555]">{{ $booking->trip->route->origin->name }}</p>
            </div>
            <div class="flex flex-col items-center px-4">
                <div class="h-px w-16 bg-[#e6e6e6]"></div>
                <svg class="my-1 h-5 w-5 text-[#ff750f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <div class="h-px w-16 bg-[#e6e6e6]"></div>
            </div>
            <div class="text-center">
                <p class="text-2xl font-extrabold text-[#1a1a1a]">{{ $booking->trip->arrives_at->format('H:i') }}</p>
                <p class="mt-1 text-sm font-semibold text-[#555555]">{{ $booking->trip->route->destination->name }}</p>
            </div>
        </div>
    </div>

    {{-- Details --}}
    <div class="border-t border-[#e6e6e6] px-6 py-4 md:px-8">
        <dl class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-[#555555]">Tanggal</dt>
                <dd class="mt-1 font-bold text-[#1a1a1a]">{{ $booking->trip->departs_at->format('d M Y') }}</dd>
            </div>
            <div>
                <dt class="text-[#555555]">Layanan</dt>
                <dd class="mt-1 font-bold text-[#1a1a1a]">{{ $booking->trip->route->service_category->label() }}</dd>
            </div>
            <div>
                <dt class="text-[#555555]">Bus</dt>
                <dd class="mt-1 font-bold text-[#1a1a1a]">{{ $booking->trip->bus->plate_number }}</dd>
            </div>
            <div>
                <dt class="text-[#555555]">Kursi</dt>
                <dd class="mt-1 font-bold text-[#1a1a1a]">{{ $seatList }}</dd>
            </div>
        </dl>
    </div>

    {{-- Cancellation Warning Banner --}}
    @if ($isCancelled)
        <div class="bg-red-600 px-6 py-4 md:px-8">
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

    {{-- Passengers --}}
    <div class="border-t border-[#e6e6e6] px-6 py-4 md:px-8">
        <h4 class="text-sm font-bold text-[#1a1a1a]">Penumpang</h4>
        <dl class="mt-3 space-y-2 text-sm">
            <div class="flex justify-between">
                <dt class="text-[#555555]">Nama</dt>
                <dd class="font-semibold text-[#1a1a1a]">{{ $booking->passenger_name }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-[#555555]">Telepon</dt>
                <dd class="font-semibold text-[#1a1a1a]">{{ $booking->passenger_phone }}</dd>
            </div>
        </dl>
    </div>

    {{-- Total --}}
    <div class="border-t border-[#e6e6e6] px-6 py-4 md:px-8">
        <div class="flex items-center justify-between">
            <span class="text-sm font-semibold text-[#555555]">Total</span>
            <span class="text-xl font-bold text-[#ff750f]">Rp {{ number_format($booking->total, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Actions --}}
    <div class="border-t border-[#e6e6e6] bg-[#faf9f8] px-6 py-4 md:px-8">
        <div class="flex flex-wrap gap-2">
            @if ($isCancelled)
                <a href="{{ route('invoice.view', $booking->code) }}" class="btn-secondary text-xs">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Lihat Invoice
                </a>
            @elseif ($booking->status === 'CONFIRMED')
                <a href="{{ route('tickets.show', $booking->code) }}" class="btn-primary text-xs">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                    E-Ticket
                </a>
                <a href="{{ route('invoice.view', $booking->code) }}" class="btn-secondary text-xs">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Lihat Invoice
                </a>
                <a href="{{ route('invoice.download', $booking->code) }}" class="btn-secondary text-xs">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Unduh Invoice
                </a>
                @if ($canCancel)
                    <form method="POST" action="{{ route('track.cancel', $booking->code) }}" onsubmit="return confirm('Batalkan tiket ini? Pengembalian dana 100% akan diproses dalam 1-3 hari kerja.')">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1 rounded-[var(--radius-sm)] border border-red-300 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 transition-all hover:bg-red-50">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Batal Tiket
                        </button>
                    </form>
                @endif
            @elseif ($booking->status === 'WAITING_VERIFICATION')
                <a href="{{ route('booking.payment', $booking->code) }}" class="btn-primary text-xs">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Upload Bukti Pembayaran
                </a>
                <a href="{{ route('track.show', $booking->code) }}" class="btn-secondary text-xs">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Detail
                </a>
                @if ($canCancel)
                    <form method="POST" action="{{ route('track.cancel', $booking->code) }}" onsubmit="return confirm('Batalkan tiket ini? Pengembalian dana 100% akan diproses dalam 1-3 hari kerja.')">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1 rounded-[var(--radius-sm)] border border-red-300 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 transition-all hover:bg-red-50">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Batal Tiket
                        </button>
                    </form>
                @endif
            @elseif ($booking->status === 'HELD')
                <a href="{{ route('booking.review', $booking->code) }}" class="btn-primary text-xs">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Selesaikan Pemesanan
                </a>
                @if ($canCancel)
                    <form method="POST" action="{{ route('track.cancel', $booking->code) }}" onsubmit="return confirm('Batalkan tiket ini? Pengembalian dana 100% akan diproses dalam 1-3 hari kerja.')">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1 rounded-[var(--radius-sm)] border border-red-300 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 transition-all hover:bg-red-50">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Batal Tiket
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</div>
