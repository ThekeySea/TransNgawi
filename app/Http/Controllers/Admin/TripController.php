<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BusStatus;
use App\Enums\TripSeatStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TripUpdateRequest;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Trip;
use App\Models\TripSeat;
use App\Support\BusSeatTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TripController extends Controller
{
    public function index(): View
    {
        $query = Trip::with(['route.origin', 'route.destination', 'bus'])
            ->withCount(['fares', 'seats']);

        if ($service = request('service')) {
            $query->whereHas('route', fn ($q) => $q->where('service_category', $service));
        }

        return view('admin.trips.index', [
            'trips' => $query->orderByDesc('departs_at')
                ->orderByDesc('created_at')
                ->paginate(15),
            'activeService' => request('service'),
        ]);
    }

    public function edit(Trip $trip): View
    {
        $trip->load(['route.origin', 'route.destination', 'bus', 'fares']);

        $currentBusModel = $trip->bus->model_type;

        // Same-model buses that are IDLE, or the currently assigned bus
        $buses = Bus::where('status', BusStatus::IDLE)
            ->where('model_type', $currentBusModel)
            ->orderBy('plate_number')
            ->get();

        // Ensure current bus is in the list even if not IDLE
        if (! $buses->contains('id', $trip->bus_id)) {
            $buses->prepend($trip->bus);
        }

        $allowedClasses = BusSeatTemplate::allowedClasses($currentBusModel);

        $fareMap = $trip->fares->pluck('fare_amount', 'class_name')->toArray();

        return view('admin.trips.edit', [
            'trip' => $trip,
            'buses' => $buses,
            'allowedClasses' => $allowedClasses,
            'fareMap' => $fareMap,
            'availableAmenities' => ['WiFi', 'Toilet', 'USB', 'Selimut', 'Cemilan', 'Bantal', 'Makanan'],
        ]);
    }

    public function update(TripUpdateRequest $request, Trip $trip): RedirectResponse
    {
        $validated = $request->validated();
        $previousBusId = $trip->bus_id;

        DB::transaction(function () use ($trip, $validated, $previousBusId) {
            $trip->update([
                'bus_id' => $validated['bus_id'],
                'departs_at' => $validated['departs_at'],
                'arrives_at' => $validated['arrives_at'],
                'amenities' => $validated['amenities'] ?? null,
                'exterior_photos' => $validated['exterior_photos'] ?? null,
                'interior_photos' => $validated['interior_photos'] ?? null,
                'facility_photos' => $validated['facility_photos'] ?? null,
            ]);

            // Sync fares: delete existing, recreate
            $trip->fares()->delete();
            foreach ($validated['fares'] as $class => $amount) {
                $trip->fares()->create(['class_name' => $class, 'fare_amount' => (int) $amount]);
            }

            // If bus changed, regenerate seats and manage bus statuses
            if ($previousBusId !== (int) $validated['bus_id']) {
                $newBus = Bus::find($validated['bus_id']);
                $trip->seats()->delete();
                foreach (BusSeatTemplate::seats($newBus->model_type) as $seat) {
                    $trip->seats()->create($seat);
                }

                // New bus becomes ACTIVE
                $newBus->update(['status' => BusStatus::ACTIVE]);

                // Previous bus reverts to IDLE (unless MAINTENANCE)
                $oldBus = Bus::find($previousBusId);
                if ($oldBus && $oldBus->status !== BusStatus::MAINTENANCE) {
                    $oldBus->update(['status' => BusStatus::IDLE]);
                }
            }
        });

        return redirect()->route('admin.trips.index')->with('status', 'Trip berhasil diperbarui.');
    }

    public function destroy(Trip $trip): RedirectResponse
    {
        // Prevent deletion if any seats are SOLD
        $hasSold = $trip->seats()->where('status', TripSeatStatus::SOLD)->exists();

        if ($hasSold) {
            return redirect()->route('admin.trips.index')
                ->with('error', 'Trip tidak bisa dihapus karena sudah ada kursi terjual.');
        }

        DB::transaction(function () use ($trip) {
            $bus = $trip->bus;

            $trip->seats()->delete();
            $trip->fares()->delete();
            $trip->delete();

            // Revert bus to IDLE if no other upcoming trips exist (unless MAINTENANCE)
            if ($bus && $bus->status !== BusStatus::MAINTENANCE) {
                $hasOtherUpcomingTrips = Trip::where('bus_id', $bus->id)
                    ->where('departs_at', '>', now())
                    ->exists();

                if (! $hasOtherUpcomingTrips) {
                    $bus->update(['status' => BusStatus::IDLE]);
                }
            }
        });

        return redirect()->route('admin.trips.index')->with('status', 'Trip berhasil dihapus.');
    }
}
