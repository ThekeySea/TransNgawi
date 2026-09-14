<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

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
}
