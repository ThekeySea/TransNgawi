@extends('layouts.customer')

@section('title', 'Pilih Kursi')

@section('content')
    <section class="section-spacing bg-surface">
        <div class="container-app">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-text sm:text-3xl">Pilih Kursi</h1>
                <p class="mt-2 text-sm text-text-muted">{{ $trip->route->origin->name }} → {{ $trip->route->destination->name }} · {{ $trip->departs_at->format('d M Y H:i') }}</p>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="card-body">
                            <x-booking.seat-map
                                :seats="$seats"
                                :occupied="$occupied"
                                :seatStatuses="$seatStatuses"
                                :maxSeats="4"
                                :busModel="$busModel"
                            />
                        </div>
                    </div>

                    <x-booking.seat-legend :busModel="$busModel" />
                </div>

                <div class="lg:col-span-1">
                    <x-booking.booking-summary :booking="[
                        'origin' => $trip->route->origin->name,
                        'destination' => $trip->route->destination->name,
                        'departure_date' => $trip->departs_at->format('d M Y'),
                        'departure_time' => $trip->departs_at->format('H:i'),
                        'class' => $trip->bus->model_type->value,
                    ]">
                        <form action="{{ route('booking.seats.store', $trip) }}" method="POST">
                            @csrf
                            <input type="hidden" name="seats" id="selected-seats-input" value="">
                            <button type="submit" class="btn-primary mt-4 w-full" id="book-btn" disabled>
                                Lanjut ke Data Penumpang
                            </button>
                        </form>
                    </x-booking.booking-summary>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('selectedSeats', {
                seats: [],
                add(seatId) {
                    if (!this.seats.includes(seatId)) {
                        this.seats.push(seatId);
                    }
                },
                remove(seatId) {
                    this.seats = this.seats.filter(s => s !== seatId);
                },
                toggle(seatId) {
                    if (this.seats.includes(seatId)) {
                        this.remove(seatId);
                    } else {
                        this.add(seatId);
                    }
                },
                isSelected(seatId) {
                    return this.seats.includes(seatId);
                }
            });

            Alpine.effect(() => {
                const seats = Alpine.store('selectedSeats').seats;
                const input = document.getElementById('selected-seats-input');
                const btn = document.getElementById('book-btn');
                if (input) input.value = JSON.stringify(seats);
                if (btn) btn.disabled = seats.length === 0;
            });
        });
    </script>
    @endpush
@endsection
