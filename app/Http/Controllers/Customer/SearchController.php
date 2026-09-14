<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Support\MockData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['service', 'origin', 'destination', 'date', 'passengers', 'class', 'date_preset', 'sort']);

        $query = Trip::query()
            ->with([
                'route.origin',
                'route.destination',
                'bus',
                'fares',
                'seats',
                'originStopPoint',
                'destinationStopPoint',
            ])
            ->whereHas('route', fn ($q) => $q->with('origin', 'destination'));

        // Filter by origin city
        if (! empty($filters['origin'])) {
            $query->whereHas('route.origin', fn ($q) => $q->where('name', $filters['origin']));
        }

        // Filter by destination city
        if (! empty($filters['destination'])) {
            $query->whereHas('route.destination', fn ($q) => $q->where('name', $filters['destination']));
        }

        // Filter by service category
        if (! empty($filters['service'])) {
            $query->whereHas('route', fn ($q) => $q->where('service_category', $filters['service']));
        }

        // Date filtering
        $datePreset = $filters['date_preset'] ?? null;
        $date = $filters['date'] ?? null;

        if ($datePreset && in_array($datePreset, ['7_days', '14_days', '30_days'])) {
            $days = (int) str_replace('_days', '', $datePreset);
            $query->where('departs_at', '>=', Carbon::now()->startOfDay())
                ->where('departs_at', '<=', Carbon::now()->addDays($days)->endOfDay());
        } elseif ($date) {
            $query->whereDate('departs_at', $date);
        } else {
            // Default: show future trips only
            $query->where('departs_at', '>=', Carbon::now());
        }

        // Get trips with computed lowest fare for sorting
        $query->withAggregate('fares as lowest_fare', 'fare_amount', 'min');

        // Sorting
        $sort = $filters['sort'] ?? 'departure_earliest';
        match ($sort) {
            'departure_latest' => $query->orderBy('departs_at', 'desc'),
            'price_lowest' => $query->orderBy('lowest_fare', 'asc'),
            'price_highest' => $query->orderBy('lowest_fare', 'desc'),
            default => $query->orderBy('departs_at', 'asc'),
        };

        $trips = $query->get()->map(fn (Trip $trip) => $this->formatTrip($trip))->toArray();

        $availableServices = MockData::serviceTypes();
        $availableClasses = MockData::classes();

        return view('customer.search.index', [
            'trips' => $trips,
            'filters' => $filters,
            'availableServices' => $availableServices,
            'availableClasses' => $availableClasses,
        ]);
    }

    private function formatTrip(Trip $trip): array
    {
        $originCity = $trip->route->origin->name;
        $destCity = $trip->route->destination->name;

        $originDisplay = $trip->originStopPoint
            ? $originCity . ' (' . $trip->originStopPoint->name . ')'
            : $originCity;

        $destDisplay = $trip->destinationStopPoint
            ? $destCity . ' (' . $trip->destinationStopPoint->name . ')'
            : $destCity;

        $availableSeats = $trip->seats->where('status', 'AVAILABLE')->count();

        $lowestFare = $trip->fares->min('fare_amount') ?? 0;

        $durationMinutes = $trip->departs_at->diffInMinutes($trip->arrives_at);
        $hours = (int) floor($durationMinutes / 60);
        $minutes = $durationMinutes % 60;
        $duration = $hours > 0 ? $hours . 'j ' . $minutes . 'm' : $minutes . 'm';

        $amenities = $trip->amenities ?? [];

        return [
            'id' => $trip->id,
            'origin' => $originDisplay,
            'destination' => $destDisplay,
            'service' => $trip->route->service_category->label(),
            'service_lower' => $trip->route->service_category->value,
            'departure' => $trip->departs_at->format('H:i'),
            'departure_date' => $trip->departs_at->format('d M Y'),
            'departure_full' => $trip->departs_at->format('d M Y, H:i'),
            'arrival' => $trip->arrives_at->format('H:i'),
            'arrival_date' => $trip->arrives_at->format('d M Y'),
            'arrival_full' => $trip->arrives_at->format('d M Y, H:i'),
            'duration' => $duration,
            'class' => $trip->fares->first()->class_name ?? '-',
            'class_lower' => strtolower($trip->fares->first()->class_name ?? ''),
            'price' => $lowestFare,
            'seats_available' => $availableSeats,
            'facilities' => $amenities,
            'bus_model' => $trip->bus->model_type->label(),
        ];
    }
}
