<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trip;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Show seat selection for a trip.
     */
    public function seats(Trip $trip)
    {
        $trip->load(['route.origin', 'route.destination', 'bus', 'fares', 'seats']);

        $seats = $trip->seats->map(fn ($s) => [
            'id' => $s->seat_code,
            'class' => $s->class_name,
            'status' => $s->status->value,
        ])->toArray();

        $occupied = $trip->seats
            ->whereIn('status', ['HELD', 'SOLD', 'BLOCKED'])
            ->pluck('seat_code')
            ->toArray();

        return view('customer.booking.seats', [
            'trip' => $trip,
            'seats' => $seats,
            'occupied' => $occupied,
            'busModel' => $trip->bus->model_type->value,
        ]);
    }

    /**
     * Hold selected seats and show passenger form.
     */
    public function storeSeats(Request $request, Trip $trip, BookingService $bookingService)
    {
        $validated = $request->validate([
            'seats' => 'required|array|min:1',
            'seats.*' => 'string',
        ]);

        try {
            $booking = $bookingService->holdSeats(
                $trip,
                $validated['seats'],
                [
                    'passenger_name' => '',
                    'passenger_email' => '',
                    'passenger_phone' => '',
                ]
            );

            return redirect()->route('booking.passengers', $booking);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['seats' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show passenger form.
     */
    public function passengers(Booking $booking)
    {
        $booking->load(['trip.route.origin', 'trip.route.destination', 'trip.bus', 'seats']);

        return view('customer.booking.passengers', [
            'booking' => $booking,
        ]);
    }

    /**
     * Save passenger data and show review.
     */
    public function storePassengers(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'passenger_name' => 'required|string|max:120',
            'passenger_email' => 'required|email|max:180',
            'passenger_phone' => 'required|string|max:32',
        ]);

        $booking->update($validated);

        return redirect()->route('booking.review', $booking);
    }

    /**
     * Show booking review.
     */
    public function review(Booking $booking)
    {
        $booking->load(['trip.route.origin', 'trip.route.destination', 'trip.bus', 'seats']);

        return view('customer.booking.review', [
            'booking' => $booking,
        ]);
    }

    /**
     * Show payment page.
     */
    public function payment(Booking $booking)
    {
        $booking->load(['trip.route.origin', 'trip.route.destination', 'trip.bus', 'seats']);

        return view('customer.booking.payment', [
            'booking' => $booking,
        ]);
    }

    /**
     * Mark payment as submitted (waiting verification).
     */
    public function storePayment(Request $request, Booking $booking)
    {
        $booking->update(['status' => 'WAITING_VERIFICATION']);

        return redirect()->route('booking.payment-status', $booking);
    }

    /**
     * Show payment status.
     */
    public function paymentStatus(Booking $booking)
    {
        $booking->load(['trip.route.origin', 'trip.route.destination', 'trip.bus', 'seats']);

        return view('customer.booking.payment-status', [
            'booking' => $booking,
        ]);
    }
}
