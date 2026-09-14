<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\Http\Request;

class MyTripsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'upcoming');
        $trips = collect(MockData::myTrips())->where('type', $tab === 'past' ? 'past' : ($tab === 'cancelled' ? 'cancelled' : 'upcoming'));

        if ($tab === 'all') {
            $trips = collect(MockData::myTrips());
        }

        return view('customer.account.my-trips', [
            'trips' => $trips->values(),
            'tab' => $tab,
        ]);
    }
}
