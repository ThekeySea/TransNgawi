@extends('layouts.customer')

@section('title', 'Review Pemesanan')

@section('content')
    <section class="section-spacing bg-surface" x-data="checkoutTimer('{{ $booking->hold_expires_at->toIso8601String() }}')">
        <div class="container-app">
            {{-- Countdown Banner --}}
            <div class="mb-6 rounded-[var(--radius-md)] border border-amber-200 bg-amber-50 p-4" x-show="remaining > 0">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">Kursi Anda ditahan selama 15 menit</p>
                        <p class="text-xs text-amber-600">Selesaikan pemesanan sebelum waktu habis. Sisa: <span class="font-bold" x-text="formatted"></span></p>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h1 class="text-2xl font-bold text-text sm:text-3xl">Review Pemesanan</h1>
                <p class="mt-2 text-sm text-text-muted">Periksa detail pemesanan Anda sebelum melanjutkan ke pembayaran.</p>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <dl class="space-y-4 text-sm">
                                <div class="flex justify-between border-b border-border pb-3">
                                    <dt class="text-text-muted">Kode Booking</dt>
                                    <dd class="font-bold text-text">{{ $booking->code }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-border pb-3">
                                    <dt class="text-text-muted">Rute</dt>
                                    <dd class="font-semibold text-text">{{ $booking->trip->route->origin->name }} → {{ $booking->trip->route->destination->name }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-border pb-3">
                                    <dt class="text-text-muted">Tanggal</dt>
                                    <dd class="font-semibold text-text">{{ $booking->trip->departs_at->format('d M Y') }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-border pb-3">
                                    <dt class="text-text-muted">Waktu</dt>
                                    <dd class="font-semibold text-text">{{ $booking->trip->departs_at->format('H:i') }} – {{ $booking->trip->arrives_at->format('H:i') }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-border pb-3">
                                    <dt class="text-text-muted">Kursi</dt>
                                    <dd class="font-semibold text-text">{{ $booking->seats->pluck('seat_code')->implode(', ') }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-border pb-3">
                                    <dt class="text-text-muted">Penumpang</dt>
                                    <dd class="font-semibold text-text">{{ $booking->passenger_name }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-border pb-3">
                                    <dt class="text-text-muted">Email</dt>
                                    <dd class="font-semibold text-text">{{ $booking->passenger_email }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-border pb-3">
                                    <dt class="text-text-muted">Telepon</dt>
                                    <dd class="font-semibold text-text">{{ $booking->passenger_phone }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <x-booking.booking-summary :booking="[
                        'origin' => $booking->trip->route->origin->name,
                        'destination' => $booking->trip->route->destination->name,
                        'departure_date' => $booking->trip->departs_at->format('d M Y'),
                        'departure_time' => $booking->trip->departs_at->format('H:i'),
                        'class' => $booking->trip->bus->model_type->value,
                        'seats' => $booking->seats->pluck('seat_code')->toArray(),
                        'total' => $booking->total,
                    ]">
                        <form action="{{ route('booking.payment', $booking) }}" method="GET">
                            <button type="submit" class="btn-primary mt-4 w-full">
                                Lanjut ke Pembayaran
                            </button>
                        </form>
                    </x-booking.booking-summary>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        function checkoutTimer(expiresAt) {
            return {
                expires: new Date(expiresAt).getTime(),
                remaining: 0,
                formatted: '',
                init() {
                    this.update();
                    setInterval(() => this.update(), 1000);
                },
                update() {
                    const now = Date.now();
                    this.remaining = Math.max(0, Math.floor((this.expires - now) / 1000));
                    const minutes = Math.floor(this.remaining / 60);
                    const seconds = this.remaining % 60;
                    this.formatted = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                    if (this.remaining <= 0) {
                        window.location.href = '{{ route("booking.seats", $booking->trip_id) }}';
                    }
                }
            }
        }
    </script>
    @endpush
@endsection
