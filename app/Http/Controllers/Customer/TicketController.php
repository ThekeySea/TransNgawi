<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Support\MockData;

class TicketController extends Controller
{
    public function show(string $code)
    {
        $ticket = MockData::ticket($code);

        if (! $ticket) {
            abort(404);
        }

        return view('customer.tickets.show', [
            'ticket' => $ticket,
        ]);
    }
}
