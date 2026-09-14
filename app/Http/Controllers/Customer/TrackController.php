<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index()
    {
        return view('customer.track.index');
    }

    public function lookup(Request $request)
    {
        $code = $request->input('code');

        if (! $code) {
            return back()->withErrors(['code' => 'Masukkan kode booking.']);
        }

        return redirect()->route('tickets.show', $code);
    }
}
