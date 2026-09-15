<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BusStatus;
use App\Enums\TripSeatStatus;
use App\Enums\TripStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TripUpdateRequest;
use App\Models\Bus;
use App\Models\Refund;
use App\Models\Route;
use App\Models\Trip;
use App\Models\TripSeat;
use App\Support\BusSeatTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TripController extends Controller
{
    public function index(): View
    {
        $activeStatus = request('status', 'active');

        $query = Trip::with(['route.origin', 'route.destination', 'bus'])
            ->withCount(['fares', 'seats']);

        // Status filtering
        $query->when($activeStatus !== 'all', function ($q) use ($activeStatus) {
            $statuses = match ($activeStatus) {
                'active' => [TripStatus::SCHEDULED, TripStatus::IN_PROGRESS],
                'completed' => [TripStatus::COMPLETED],
                'cancelled' => [TripStatus::CANCELLED],
                default => [],
            };
            if (! empty($statuses)) {
                $q->whereIn('status', $statuses);
            }
        });

        if ($service = request('service')) {
            $query->whereHas('route', fn ($q) => $q->where('service_category', $service));
        }

        return view('admin.trips.index', [
            'trips' => $query->orderByDesc('departs_at')
                ->orderByDesc('created_at')
                ->paginate(15),
            'activeService' => request('service'),
            'activeStatus' => $activeStatus,
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

    public function seats(Trip $trip): View
    {
        $trip->load(['route.origin', 'route.destination', 'bus', 'fares', 'seats']);

        $seats = $trip->seats->map(fn ($s) => [
            'id' => $s->seat_code,
            'class' => $s->class_name,
            'status' => $s->status->value,
            'is_damaged' => $s->is_damaged,
        ])->toArray();

        $seatStatuses = $trip->seats->pluck('status', 'seat_code')
            ->map(fn ($s) => is_string($s) ? $s : $s->value)
            ->toArray();

        $stats = [
            'total' => $trip->seats->count(),
            'available' => $trip->seats->where('status', TripSeatStatus::AVAILABLE)->count(),
            'held' => $trip->seats->where('status', TripSeatStatus::HELD)->count(),
            'sold' => $trip->seats->where('status', TripSeatStatus::SOLD)->count(),
            'blocked' => $trip->seats->where('status', TripSeatStatus::BLOCKED)->count(),
        ];

        return view('admin.trips.seats', [
            'trip' => $trip,
            'seats' => $seats,
            'seatStatuses' => $seatStatuses,
            'stats' => $stats,
            'busModel' => $trip->bus->model_type->value,
        ]);
    }

    public function toggleMaintenance(Request $request, Trip $trip, string $seatCode): JsonResponse
    {
        $seat = TripSeat::where('trip_id', $trip->id)->where('seat_code', $seatCode)->firstOrFail();

        // Protection: SOLD or HELD seats cannot be toggled
        if (in_array($seat->status, [TripSeatStatus::SOLD, TripSeatStatus::HELD])) {
            return response()->json([
                'success' => false,
                'message' => 'Kursi sedang ditahan atau sudah dibeli penumpang, tidak dapat ditandai rusak.',
            ], 422);
        }

        $newStatus = $seat->status === TripSeatStatus::BLOCKED
            ? TripSeatStatus::AVAILABLE
            : TripSeatStatus::BLOCKED;

        $newIsDamaged = $newStatus === TripSeatStatus::BLOCKED;

        DB::transaction(function () use ($seat, $newStatus, $newIsDamaged) {
            $seat->update([
                'status' => $newStatus,
                'is_damaged' => $newIsDamaged,
            ]);
        });

        $seat->refresh();

        Log::info('Seat toggled', [
            'seat_id' => $seat->id,
            'seat_code' => $seat->seat_code,
            'trip_id' => $seat->trip_id,
            'new_status' => $seat->status->value,
            'is_damaged' => $seat->is_damaged,
        ]);

        $label = $newStatus === TripSeatStatus::BLOCKED ? 'ditandai rusak' : 'diperbaiki dan siap digunakan kembali';

        return response()->json([
            'success' => true,
            'seat_code' => $seat->seat_code,
            'new_status' => $seat->status->value,
            'is_damaged' => $seat->is_damaged,
            'message' => "Kursi {$seat->seat_code} berhasil {$label}.",
        ]);
    }

    /**
     * Mark trip as completed and revert bus to IDLE.
     */
    public function complete(Trip $trip): RedirectResponse
    {
        if ($trip->status === TripStatus::COMPLETED) {
            return redirect()->route('admin.trips.index', ['status' => 'completed'])
                ->with('error', 'Trip sudah dalam status selesai.');
        }

        if ($trip->status === TripStatus::CANCELLED) {
            return redirect()->route('admin.trips.index', ['status' => 'cancelled'])
                ->with('error', 'Trip yang dibatalkan tidak dapat diselesaikan.');
        }

        DB::transaction(function () use ($trip) {
            $trip->update(['status' => TripStatus::COMPLETED]);

            $bus = $trip->bus;
            if ($bus && $bus->status !== BusStatus::MAINTENANCE) {
                $hasOtherActiveTrips = Trip::where('bus_id', $bus->id)
                    ->where('id', '!=', $trip->id)
                    ->whereIn('status', [TripStatus::SCHEDULED, TripStatus::IN_PROGRESS])
                    ->exists();

                if (! $hasOtherActiveTrips) {
                    $bus->update(['status' => BusStatus::IDLE]);
                }
            }
        });

        Log::info('Trip completed', [
            'trip_id' => $trip->id,
            'trip_code' => $trip->trip_code,
            'bus_id' => $trip->bus_id,
        ]);

        return redirect()->route('admin.trips.index', ['status' => 'completed'])
            ->with('status', "Trip {$trip->trip_code} berhasil diselesaikan.");
    }

    /**
     * Cancel trip, refund all paid bookings 100%, and revert bus to IDLE.
     */
    public function cancel(Trip $trip): RedirectResponse
    {
        if ($trip->status === TripStatus::CANCELLED) {
            return redirect()->route('admin.trips.index', ['status' => 'cancelled'])
                ->with('error', 'Trip sudah dalam status dibatalkan.');
        }

        if ($trip->status === TripStatus::COMPLETED) {
            return redirect()->route('admin.trips.index', ['status' => 'completed'])
                ->with('error', 'Trip yang sudah selesai tidak dapat dibatalkan.');
        }

        DB::transaction(function () use ($trip) {
            $trip->update(['status' => TripStatus::CANCELLED]);

            // Find all paid/confirmed bookings for this trip
            $paidBookings = $trip->bookings()
                ->whereIn('status', ['CONFIRMED', 'WAITING_VERIFICATION'])
                ->get();

            foreach ($paidBookings as $booking) {
                // Update booking status
                $booking->update(['status' => 'CANCELLED_BY_ADMIN']);

                // Create 100% refund record
                Refund::create([
                    'booking_id' => $booking->id,
                    'trip_id' => $trip->id,
                    'refund_amount' => $booking->total,
                    'refund_percentage' => 100,
                    'reason' => 'Pembatalan perjalanan oleh admin: ' . $trip->trip_code,
                    'type' => 'TRIP_CANCELLATION',
                ]);

                // Release held seats
                TripSeat::where('held_by_booking_id', $booking->id)
                    ->whereIn('status', [TripSeatStatus::HELD, TripSeatStatus::SOLD])
                    ->update([
                        'status' => TripSeatStatus::AVAILABLE,
                        'hold_expires_at' => null,
                        'held_by_booking_id' => null,
                    ]);
            }

            // Revert bus to IDLE (unless MAINTENANCE)
            $bus = $trip->bus;
            if ($bus && $bus->status !== BusStatus::MAINTENANCE) {
                $hasOtherActiveTrips = Trip::where('bus_id', $bus->id)
                    ->where('id', '!=', $trip->id)
                    ->whereIn('status', [TripStatus::SCHEDULED, TripStatus::IN_PROGRESS])
                    ->exists();

                if (! $hasOtherActiveTrips) {
                    $bus->update(['status' => BusStatus::IDLE]);
                }
            }
        });

        $refundCount = Refund::where('trip_id', $trip->id)
            ->where('type', 'TRIP_CANCELLATION')
            ->count();

        Log::info('Trip cancelled with 100% refund', [
            'trip_id' => $trip->id,
            'trip_code' => $trip->trip_code,
            'bus_id' => $trip->bus_id,
            'refunds_created' => $refundCount,
        ]);

        return redirect()->route('admin.trips.index', ['status' => 'cancelled'])
            ->with('status', "Trip {$trip->trip_code} dibatalkan. {$refundCount} refund 100% berhasil dibuat.");
    }
}
