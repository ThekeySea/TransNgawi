<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class TicketController extends Controller
{
    public function show(string $code)
    {
        $booking = Booking::with(['trip.route.origin', 'trip.route.destination', 'trip.bus', 'seats'])
            ->where('code', $code)
            ->first();

        if (! $booking || $booking->status !== 'CONFIRMED') {
            abort(404);
        }

        return view('customer.tickets.show', [
            'booking' => $booking,
        ]);
    }
}
