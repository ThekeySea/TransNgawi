<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Support\MockData;

class InfoController extends Controller
{
    public function classes()
    {
        return view('customer.info.classes', [
            'classes' => MockData::classes(),
            'serviceTypes' => MockData::serviceTypes(),
            'routes' => MockData::routes(),
        ]);
    }

    public function routes()
    {
        return view('customer.info.routes', [
            'routes' => MockData::routes(),
            'serviceTypes' => MockData::serviceTypes(),
        ]);
    }

    public function about()
    {
        return view('customer.info.about');
    }
}
