<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Support\MockData;
use Illuminate\Http\JsonResponse;

class TripController extends Controller
{
    public function show(string $trip)
    {
        $tripModel = Trip::with(['route.origin', 'route.destination', 'bus', 'fares', 'seats'])
            ->findOrFail($trip);

        $classes = MockData::classes();

        $availability = $tripModel->seats
            ->where('status', 'AVAILABLE')
            ->groupBy('class_name')
            ->map(fn ($seats) => $seats->count());

        $fares = $tripModel->fares->map(function ($fare) use ($availability) {
            return [
                'class' => $fare->class_name,
                'price' => $fare->fare_amount,
                'available' => $availability->get($fare->class_name, 0),
            ];
        });

        $seats = $tripModel->seats->map(fn ($seat) => [
            'id' => $seat->seat_code,
            'class' => $seat->class_name,
            'status' => $seat->status->value,
        ])->toArray();

        $seatStatuses = $tripModel->seats->pluck('status', 'seat_code')
            ->map(fn ($s) => is_string($s) ? $s : $s->value)
            ->toArray();

        $occupied = $tripModel->seats
            ->whereIn('status', [\App\Enums\TripSeatStatus::SOLD, \App\Enums\TripSeatStatus::HELD])
            ->pluck('seat_code')
            ->toArray();

        $busModel = $tripModel->bus->model_type->value;

        // Unique fare prices for filter chips
        $farePrices = $fares->pluck('price')->unique()->sort()->values()->all();

        // Duration calculation
        $durationMinutes = $tripModel->departs_at->diffInMinutes($tripModel->arrives_at);
        $durationHours = floor($durationMinutes / 60);
        $durationRemainder = $durationMinutes % 60;
        $duration = $durationHours > 0
            ? $durationHours . 'j ' . $durationRemainder . 'm'
            : $durationRemainder . 'm';

        return view('customer.trips.show', [
            'trip' => $tripModel,
            'classes' => $classes,
            'fares' => $fares,
            'availability' => $availability,
            'seats' => $seats,
            'occupied' => $occupied,
            'seatStatuses' => $seatStatuses,
            'busModel' => $busModel,
            'farePrices' => $farePrices,
            'duration' => $duration,
        ]);
    }

    public function seatStatuses(Trip $trip): JsonResponse
    {
        $statuses = $trip->seats->pluck('status', 'seat_code')
            ->map(fn ($s) => is_string($s) ? $s : $s->value)
            ->toArray();

        return response()->json(['statuses' => $statuses]);
    }
}
