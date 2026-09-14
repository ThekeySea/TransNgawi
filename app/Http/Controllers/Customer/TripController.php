<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Support\MockData;

class TripController extends Controller
{
    public function show(int $trip)
    {
        $tripData = MockData::trip($trip);

        if (! $tripData) {
            abort(404);
        }

        return view('customer.trips.show', [
            'trip' => $tripData,
            'classes' => MockData::classes(),
        ]);
    }
}
