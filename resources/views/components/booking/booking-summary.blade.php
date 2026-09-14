@props(['booking'])

<aside class="card sticky top-24">
    <div class="card-body">
        <h3 class="text-lg font-bold text-text">Ringkasan Pemesanan</h3>

        <dl class="mt-4 space-y-3 text-sm">
            <div class="flex justify-between">
                <dt class="text-text-muted">Rute</dt>
                <dd class="font-semibold text-text">{{ $booking['origin'] }} → {{ $booking['destination'] }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-text-muted">Tanggal</dt>
                <dd class="font-semibold text-text">{{ $booking['departure_date'] ?? '' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-text-muted">Waktu</dt>
                <dd class="font-semibold text-text">{{ $booking['departure_time'] ?? '' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-text-muted">Kelas</dt>
                <dd class="font-semibold text-text">{{ $booking['class'] ?? '' }}</dd>
            </div>
            @if (! empty($booking['seats']))
                <div class="flex justify-between">
                    <dt class="text-text-muted">Kursi</dt>
                    <dd class="font-semibold text-text">{{ implode(', ', $booking['seats']) }}</dd>
                </div>
            @endif
            @if (! empty($booking['passengers']))
                <div class="flex justify-between">
                    <dt class="text-text-muted">Penumpang</dt>
                    <dd class="font-semibold text-text">{{ $booking['passengers'] }} orang</dd>
                </div>
            @endif
        </dl>

        @if (! empty($booking['total']))
            <div class="mt-6 border-t border-border pt-4">
                <div class="flex items-center justify-between">
                    <span class="text-base font-semibold text-text">Total</span>
                    <span class="text-xl font-bold text-brand">Rp {{ number_format($booking['total'], 0, ',', '.') }}</span>
                </div>
            </div>
        @endif

        {{ $slot }}
    </div>
</aside>
