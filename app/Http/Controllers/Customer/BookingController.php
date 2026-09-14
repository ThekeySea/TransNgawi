<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function seats(int $booking)
    {
        $layout = MockData::seatLayout();

        return view('customer.booking.seats', [
            'booking' => MockData::booking($booking),
            'seats' => $layout['seats'],
            'occupied' => $layout['occupied'],
        ]);
    }

    public function passengers(int $booking)
    {
        return view('customer.booking.passengers', [
            'booking' => MockData::booking($booking),
        ]);
    }

    public function review(int $booking)
    {
        return view('customer.booking.review', [
            'booking' => MockData::booking($booking),
        ]);
    }

    public function payment(int $booking)
    {
        return view('customer.booking.payment', [
            'booking' => MockData::booking($booking),
        ]);
    }

    public function paymentStatus(int $booking)
    {
        return view('customer.booking.payment-status', [
            'booking' => array_merge(MockData::booking($booking), [
                'payment_status' => 'waiting_verification',
            ]),
        ]);
    }

    public function storeSeats(Request $request, int $booking)
    {
        return redirect()->route('booking.passengers', $booking);
    }

    public function storePassengers(Request $request, int $booking)
    {
        return redirect()->route('booking.review', $booking);
    }

    public function storePayment(Request $request, int $booking)
    {
        return redirect()->route('booking.payment-status', $booking);
    }
}
