<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\View\View;

class TripController extends Controller
{
    public function index(): View
    {
        return view('admin.trips.index', [
            'trips' => Trip::with(['route.origin', 'route.destination', 'bus'])
                ->withCount(['fares', 'seats'])
                ->orderByDesc('departs_at')
                ->orderByDesc('created_at')
                ->paginate(15),
        ]);
    }
}
