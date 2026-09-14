<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportMessage;
use App\Models\SupportSession;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportSession::with(['user', 'booking']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $sessions = $query->latest()->paginate(15)->withQueryString();

        return view('admin.help.index', [
            'sessions' => $sessions,
        ]);
    }

    public function show(SupportSession $session)
    {
        $session->load(['user', 'booking.trip.route.origin', 'booking.trip.route.destination', 'messages']);

        return view('admin.help.show', [
            'session' => $session,
        ]);
    }

    public function accept(SupportSession $session)
    {
        $session->update(['status' => 'ACTIVE']);

        return redirect()->route('admin.help.show', $session)
            ->with('status', 'Sesi bantuan telah diterima.');
    }

    public function reply(Request $request, SupportSession $session)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        SupportMessage::create([
            'support_session_id' => $session->id,
            'sender_id' => auth()->id(),
            'sender_type' => 'admin',
            'message' => $validated['message'],
        ]);

        if ($session->status === 'WAITING') {
            $session->update(['status' => 'ACTIVE']);
        }

        return redirect()->route('admin.help.show', $session);
    }

    public function close(SupportSession $session)
    {
        $session->update(['status' => 'CLOSED']);

        return redirect()->route('admin.help.show', $session)
            ->with('status', 'Sesi bantuan telah ditutup.');
    }
}
