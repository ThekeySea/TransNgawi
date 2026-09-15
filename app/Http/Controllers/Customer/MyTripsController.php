<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class MyTripsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return view('customer.account.my-trips', [
                'bookings' => collect(),
                'tab' => 'all',
                'guest' => true,
                'searchResult' => null,
            ]);
        }

        $tab = $request->get('tab', 'upcoming');

        $query = Booking::with(['trip.route.origin', 'trip.route.destination', 'trip.bus', 'seats'])
            ->where('bookings.user_id', $user->id)
            ->join('trips', 'bookings.trip_id', '=', 'trips.id')
            ->select('bookings.*');

        if ($tab === 'cancelled') {
            $query->where('bookings.status', 'CANCELLED_BY_ADMIN');
        } else {
            $query->whereIn('bookings.status', ['CONFIRMED', 'WAITING_VERIFICATION']);

            if ($tab === 'upcoming') {
                $query->where('trips.departs_at', '>=', now())
                    ->where('trips.status', '!=', 'COMPLETED');
            } elseif ($tab === 'past') {
                $query->where(function ($q) {
                    $q->where('trips.departs_at', '<', now())
                        ->orWhere('trips.status', 'COMPLETED');
                });
            }
        }

        $bookings = $query->orderByDesc('trips.departs_at')->get();

        return view('customer.account.my-trips', [
            'bookings' => $bookings,
            'tab' => $tab,
            'guest' => false,
            'searchResult' => null,
        ]);
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'booking_code' => 'required|string|max:16',
            'identifier' => 'required|string|max:255',
        ]);

        $booking = Booking::with(['trip.route.origin', 'trip.route.destination', 'trip.bus', 'seats'])
            ->where('code', $validated['booking_code'])
            ->first();

        if (! $booking) {
            return back()->withErrors([
                'booking_code' => 'Kode booking tidak ditemukan.',
            ])->withInput();
        }

        if ($booking->passenger_phone !== $validated['identifier'] && $booking->passenger_email !== $validated['identifier']) {
            return back()->withErrors([
                'identifier' => 'Nomor telepon atau email tidak cocok dengan booking ini.',
            ])->withInput();
        }

        if ($request->user()) {
            return view('customer.account.my-trips', [
                'bookings' => collect(),
                'tab' => 'all',
                'guest' => false,
                'searchResult' => $booking,
            ]);
        }

        return view('customer.account.my-trips', [
            'bookings' => collect(),
            'tab' => 'all',
            'guest' => true,
            'searchResult' => $booking,
        ]);
    }
}
