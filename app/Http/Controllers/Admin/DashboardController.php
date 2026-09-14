<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BusStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Bus;
use App\Models\BusIssue;
use App\Models\Location;
use App\Models\SupportSession;
use App\Models\Trip;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'locationCount' => Location::count(),
            'busCount' => Bus::count(),
            'idleBusCount' => Bus::where('status', BusStatus::IDLE)->count(),
            'activeBusCount' => Bus::where('status', BusStatus::ACTIVE)->count(),
            'maintenanceBusCount' => Bus::where('status', BusStatus::MAINTENANCE)->count(),
            'openIssueCount' => BusIssue::where('status', 'OPEN')->count(),
            'tripCount' => Trip::count(),
            'transactionCount' => Booking::count(),
            'pendingTransactionCount' => Booking::where('status', 'WAITING_VERIFICATION')->count(),
            'pendingHelpCount' => SupportSession::where('status', 'WAITING')->count(),
            'recentTrips' => Trip::with(['route.origin', 'route.destination', 'bus'])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),
        ]);
    }
}
