<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
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

        return redirect()->route('admin.transactions.show', $booking)
            ->with('status', "Pembayaran {$booking->code} telah ditolak.");
    }
}
