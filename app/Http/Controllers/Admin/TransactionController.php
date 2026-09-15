<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TripSeatStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Refund;
use App\Models\TripSeat;
use App\Services\BookingService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['trip.route.origin', 'trip.route.destination', 'trip.bus', 'seats']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('passenger_name', 'like', "%{$search}%")
                    ->orWhere('passenger_email', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.transactions.index', [
            'bookings' => $bookings,
        ]);
    }

    public function show(Booking $booking)
    {
        $booking->load(['trip.route.origin', 'trip.route.destination', 'trip.bus', 'seats']);

        return view('admin.transactions.show', [
            'booking' => $booking,
        ]);
    }

    public function approve(Booking $booking, BookingService $bookingService)
    {
        $bookingService->confirmBooking($booking);

        return redirect()->route('admin.transactions.show', $booking)
            ->with('status', "Pembayaran {$booking->code} telah disetujui.");
    }

    public function reject(Request $request, Booking $booking)
    {
        $booking->update([
            'status' => 'REJECTED',
        ]);

        TripSeat::where('held_by_booking_id', $booking->id)
            ->where('status', TripSeatStatus::HELD)
            ->update([
                'status' => TripSeatStatus::AVAILABLE,
                'hold_expires_at' => null,
                'held_by_booking_id' => null,
            ]);

        return redirect()->route('admin.transactions.show', $booking)
            ->with('status', "Pembayaran {$booking->code} telah ditolak.");
    }

    /**
     * Display all refunds (especially trip cancellation refunds).
     */
    public function refunds(Request $request)
    {
        $query = Refund::with(['booking.trip.route.origin', 'booking.trip.route.destination', 'trip']);

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        $refunds = $query->latest()->paginate(15)->withQueryString();

        return view('admin.refunds.index', [
            'refunds' => $refunds,
            'activeType' => $type,
        ]);
    }
}
