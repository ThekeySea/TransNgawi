<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['service', 'origin', 'destination', 'date', 'passengers', 'class']);
        $trips = MockData::trips($filters);

        $availableServices = MockData::serviceTypes();
        $availableClasses = MockData::classes();

        return view('customer.search.index', [
            'trips' => $trips,
            'filters' => $filters,
            'availableServices' => $availableServices,
            'availableClasses' => $availableClasses,
        ]);
    }
}
