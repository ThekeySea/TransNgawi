<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\SupportMessage;
use App\Models\SupportSession;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        $sessions = SupportSession::where('user_id', auth()->id())
            ->with('booking')
            ->latest()
            ->get();

        return view('customer.help.index', [
            'topics' => ['Booking', 'Payment', 'Ticket', 'Jadwal', 'Boarding', 'Kursi', 'Rute', 'Status Perjalanan', 'Refund/Pembatalan', 'Lainnya'],
            'sessions' => $sessions,
            'bookings' => Booking::where('user_id', auth()->id())
                ->whereIn('status', ['HELD', 'WAITING_VERIFICATION', 'CONFIRMED'])
                ->with('trip')
                ->latest()
                ->get(),
        ]);
    }

    public function show(SupportSession $session)
    {
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        $session->load(['booking.trip.route.origin', 'booking.trip.route.destination', 'messages']);

        return view('customer.help.show', [
            'session' => $session,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:64',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'booking_id' => 'nullable|exists:bookings,id',
        ]);

        $session = SupportSession::create([
            'user_id' => auth()->id(),
            'booking_id' => $validated['booking_id'] ?? null,
            'topic' => $validated['topic'],
            'subject' => $validated['subject'],
            'status' => 'WAITING',
        ]);

        SupportMessage::create([
            'support_session_id' => $session->id,
            'sender_id' => auth()->id(),
            'sender_type' => 'customer',
            'message' => $validated['message'],
        ]);

        return redirect()->route('help.show', $session)
            ->with('status', 'Pesan Anda telah dikirim. Menunggu balasan dari admin.');
    }

    public function reply(Request $request, SupportSession $session)
    {
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        SupportMessage::create([
            'support_session_id' => $session->id,
            'sender_id' => auth()->id(),
            'sender_type' => 'customer',
            'message' => $validated['message'],
        ]);

        return redirect()->route('help.show', $session);
    }
}
