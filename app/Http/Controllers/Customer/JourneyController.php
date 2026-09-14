<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Support\MockData;

class JourneyController extends Controller
{
    public function show(int $journey)
    {
        return view('customer.journeys.show', [
            'journey' => MockData::journey($journey),
        ]);
    }

    public function track(int $journey)
    {
        return view('customer.journeys.track', [
            'journey' => MockData::journey($journey),
        ]);
    }
}
