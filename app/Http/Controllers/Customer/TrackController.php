<?php

namespace App\Http\Controllers\Customer;

use App\Enums\TripSeatStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Refund;
use App\Models\TripSeat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TrackController extends Controller
{
    public function index()
    {
        return view('customer.track.index');
    }

    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:16',
        ]);

        $booking = Booking::with(['trip.route.origin', 'trip.route.destination', 'trip.bus', 'seats'])
            ->where('code', $validated['code'])
            ->first();

        if (! $booking) {
            return back()->withErrors(['code' => 'Kode booking tidak ditemukan.'])->withInput();
        }

        return redirect()->route('track.show', $booking->code);
    }

    public function show(string $code)
    {
        $booking = Booking::with(['trip.route.origin', 'trip.route.destination', 'trip.bus', 'seats'])
            ->where('code', $code)
            ->firstOrFail();

        return view('customer.track.show', [
            'booking' => $booking,
        ]);
    }

    public function updatePayment(Request $request, string $code)
    {
        $booking = Booking::where('code', $code)->firstOrFail();

        $validated = $request->validate([
            'payment_note' => 'nullable|string|max:255',
        ]);

        $booking->update([
            'status' => 'WAITING_VERIFICATION',
            'payment_note' => $validated['payment_note'] ?? null,
        ]);

        return redirect()->route('track.show', $booking->code)
            ->with('status', 'Pembayaran Anda sedang menunggu verifikasi.');
    }

    /**
     * Allow user to cancel their own booking (100% refund).
     * Only allowed for CONFIRMED, WAITING_VERIFICATION, or HELD bookings.
     */
    public function cancelBooking(Request $request, string $code)
    {
        $booking = Booking::with(['trip.route', 'seats'])
            ->where('code', $code)
            ->firstOrFail();

        // Only the booking owner can cancel
        $user = $request->user();
        if ($user && $booking->user_id !== $user->id) {
            abort(403);
        }

        // Can only cancel CONFIRMED, WAITING_VERIFICATION, or HELD bookings
        if (! in_array($booking->status, ['CONFIRMED', 'WAITING_VERIFICATION', 'HELD'])) {
            return back()->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        // Cannot cancel if trip is already completed or cancelled
        if (in_array($booking->trip->status?->value, ['COMPLETED', 'CANCELLED'])) {
            return back()->with('error', 'Perjalanan sudah selesai atau dibatalkan.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'CANCELLED']);

            // Create 100% refund record
            Refund::create([
                'booking_id' => $booking->id,
                'trip_id' => $booking->trip_id,
                'refund_amount' => $booking->total,
                'refund_percentage' => 100,
                'reason' => 'Pembatalan mandiri oleh penumpang: ' . $booking->passenger_name,
                'type' => 'PASSENGER_CANCELLATION',
            ]);

            // Release seats via BookingSeat relation (works for both held and sold)
            $tripSeatIds = BookingSeat::where('booking_id', $booking->id)
                ->pluck('trip_seat_id');

            TripSeat::whereIn('id', $tripSeatIds)
                ->whereIn('status', [TripSeatStatus::HELD, TripSeatStatus::SOLD])
                ->update([
                    'status' => TripSeatStatus::AVAILABLE,
                    'hold_expires_at' => null,
                    'held_by_booking_id' => null,
                ]);
        });

        Log::info('Booking cancelled by passenger', [
            'booking_id' => $booking->id,
            'booking_code' => $booking->code,
            'user_id' => $booking->user_id,
            'refund_amount' => $booking->total,
        ]);

        return redirect()->route('track.show', $booking->code)
            ->with('status', 'Tiket berhasil dibatalkan. Pengembalian dana 100% akan diproses dalam 1-3 hari kerja.');
    }
}
