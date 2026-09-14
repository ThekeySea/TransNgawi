<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return view('customer.account.profile');
    }
}
