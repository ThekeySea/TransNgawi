<?php

namespace App\Services;

use App\Enums\TripSeatStatus;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Trip;
use App\Models\TripSeat;
use App\Models\TripFare;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingService
{
    /**
     * Hold seats for a booking. Uses DB transaction + pessimistic locking
     * to prevent double-booking races.
     *
     * @param  Trip  $trip
     * @param  array<int, string>  $seatCodes  e.g. ['A1', 'A2']
     * @param  array{passenger_name: string, passenger_email: string, passenger_phone: string}  $passenger
     * @return Booking
     *
     * @throws \RuntimeException
     */
    public function holdSeats(Trip $trip, array $seatCodes, array $passenger): Booking
    {
        return DB::transaction(function () use ($trip, $seatCodes, $passenger) {
            // Lock the trip seats rows for update to prevent races
            $seatModels = TripSeat::query()
                ->where('trip_id', $trip->id)
                ->whereIn('seat_code', $seatCodes)
                ->lockForUpdate()
                ->get();

            // Validate all requested seats exist
            if ($seatModels->count() !== count($seatCodes)) {
                throw new \RuntimeException('Beberapa kursi yang dipilih tidak ditemukan.');
            }

            // Validate all seats are AVAILABLE
            $unavailable = $seatModels->filter(fn (TripSeat $s) => $s->status !== TripSeatStatus::AVAILABLE);
            if ($unavailable->isNotEmpty()) {
                $codes = $unavailable->pluck('seat_code')->implode(', ');
                throw new \RuntimeException("Kursi {$codes} sudah tidak tersedia. Silakan pilih kursi lain.");
            }

            // Calculate total from trip fares
            $fareMap = TripFare::where('trip_id', $trip->id)
                ->get()
                ->keyBy('class_name');

            $subtotal = 0;
            foreach ($seatModels as $seat) {
                $fare = $fareMap->get($seat->class_name);
                if (! $fare) {
                    throw new \RuntimeException("Fare untuk kelas {$seat->class_name} tidak ditemukan.");
                }
                $subtotal += $fare->fare_amount;
            }

            // Create booking
            $holdExpiresAt = Carbon::now()->addMinutes(15);
            $booking = Booking::create([
                'code' => Booking::generateCode(),
                'user_id' => auth()->id(),
                'trip_id' => $trip->id,
                'status' => 'HELD',
                'passenger_name' => $passenger['passenger_name'],
                'passenger_email' => $passenger['passenger_email'],
                'passenger_phone' => $passenger['passenger_phone'],
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'hold_expires_at' => $holdExpiresAt,
            ]);

            // Mark seats as HELD and create booking_seats
            foreach ($seatModels as $seat) {
                $fare = $fareMap->get($seat->class_name);

                $seat->update([
                    'status' => TripSeatStatus::HELD,
                    'hold_expires_at' => $holdExpiresAt,
                    'held_by_booking_id' => $booking->id,
                ]);

                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'trip_seat_id' => $seat->id,
                    'seat_code' => $seat->seat_code,
                    'class_name' => $seat->class_name,
                    'fare_amount' => $fare->fare_amount,
                ]);
            }

            return $booking;
        });
    }

    /**
     * Release all expired HELD seats and update their bookings.
     */
    public function releaseExpiredHolds(): int
    {
        $expiredSeats = TripSeat::query()
            ->where('status', TripSeatStatus::HELD)
            ->where('hold_expires_at', '<', now())
            ->get();

        $releasedCount = 0;

        foreach ($expiredSeats as $seat) {
            DB::transaction(function () use ($seat, &$releasedCount) {
                $seat->update([
                    'status' => TripSeatStatus::AVAILABLE,
                    'hold_expires_at' => null,
                    'held_by_booking_id' => null,
                ]);

                // If the booking has no more held seats, mark it as expired
                if ($seat->held_by_booking_id) {
                    $booking = Booking::find($seat->held_by_booking_id);
                    if ($booking) {
                        $remainingHeld = TripSeat::where('held_by_booking_id', $booking->id)
                            ->where('status', TripSeatStatus::HELD)
                            ->count();

                        if ($remainingHeld === 0) {
                            $booking->update(['status' => 'EXPIRED']);
                        }
                    }
                }

                $releasedCount++;
            });
        }

        return $releasedCount;
    }

    /**
     * Confirm booking (mark seats as SOLD).
     */
    public function confirmBooking(Booking $booking): void
    {
        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => 'CONFIRMED',
                'paid_at' => now(),
            ]);

            TripSeat::where('held_by_booking_id', $booking->id)
                ->where('status', TripSeatStatus::HELD)
                ->update([
                    'status' => TripSeatStatus::SOLD,
                    'hold_expires_at' => null,
                    'held_by_booking_id' => null,
                ]);
        });
    }
}
