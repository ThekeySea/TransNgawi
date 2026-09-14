<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Location;
use App\Models\Trip;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'locationCount' => Location::count(),
            'busCount' => Bus::count(),
            'tripCount' => Trip::count(),
            'recentTrips' => Trip::with(['route.origin', 'route.destination', 'bus'])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),
        ]);
    }
}
