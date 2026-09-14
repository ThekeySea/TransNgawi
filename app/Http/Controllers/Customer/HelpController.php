<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        return view('customer.help.index', [
            'topics' => MockData::helpTopics(),
        ]);
    }

    public function show(int $help)
    {
        return view('customer.help.show', [
            'session' => MockData::helpSession($help),
        ]);
    }

    public function store(Request $request)
    {
        return redirect()->route('help.show', 1);
    }
}
