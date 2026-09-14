<?php

namespace Tests\Feature;

use App\Enums\BusModelType;
use App\Enums\ServiceCategory;
use App\Enums\TripSeatStatus;
use App\Models\Bus;
use App\Models\Location;
use App\Models\Route;
use App\Models\Trip;
use App\Models\TripFare;
use App\Models\TripSeat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoreDomainRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_location_flags_default_to_false(): void
    {
        $location = Location::create(['name' => 'Prototype City A']);
        $location->refresh();

        $this->assertFalse($location->is_capital);
        $this->assertFalse($location->is_important);
    }

    public function test_route_links_origin_destination_and_trips(): void
    {
        $origin = Location::create(['name' => 'Prototype City A', 'is_capital' => true]);
        $destination = Location::create(['name' => 'Prototype City B', 'is_capital' => true]);

        $route = Route::create([
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'service_category' => ServiceCategory::ANTIBU,
        ]);

        $this->assertSame(ServiceCategory::ANTIBU, $route->service_category);
        $this->assertTrue($route->origin->is($origin));
        $this->assertTrue($route->destination->is($destination));
        $this->assertTrue($origin->originatingRoutes->contains($route));
        $this->assertTrue($destination->destinationRoutes->contains($route));
    }

    public function test_duplicate_route_category_is_rejected(): void
    {
        $origin = Location::create(['name' => 'Prototype City A']);
        $destination = Location::create(['name' => 'Prototype City B']);

        Route::create([
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'service_category' => ServiceCategory::BIASANE,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Route::create([
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'service_category' => ServiceCategory::BIASANE,
        ]);
    }

    public function test_trip_links_route_bus_fares_and_seats(): void
    {
        $route = Route::create([
            'origin_id' => Location::create(['name' => 'Prototype City A'])->id,
            'destination_id' => Location::create(['name' => 'Prototype City B'])->id,
            'service_category' => ServiceCategory::SATSET,
        ]);
        $bus = Bus::create([
            'plate_number' => 'PROTO-001',
            'model_type' => BusModelType::ANTIBU_SATSET,
            'status' => 'IDLE',
        ]);

        $trip = Trip::create(['route_id' => $route->id, 'bus_id' => $bus->id]);
        $fare = TripFare::create(['trip_id' => $trip->id, 'class_name' => 'Sukian', 'fare_amount' => 100000]);
        $seat = TripSeat::create(['trip_id' => $trip->id, 'seat_code' => 'A1', 'class_name' => 'Sukian']);
        $seat->refresh();

        $this->assertSame(BusModelType::ANTIBU_SATSET, $bus->model_type);
        $this->assertSame(TripSeatStatus::AVAILABLE, $seat->status);
        $this->assertTrue($trip->route->is($route));
        $this->assertTrue($trip->bus->is($bus));
        $this->assertTrue($trip->fares->contains($fare));
        $this->assertTrue($trip->seats->contains($seat));
        $this->assertTrue($fare->trip->is($trip));
        $this->assertTrue($seat->trip->is($trip));
        $this->assertTrue($bus->trips->contains($trip));
        $this->assertTrue($route->trips->contains($trip));
    }

    public function test_duplicate_seat_code_per_trip_is_rejected(): void
    {
        $trip = Trip::create([
            'route_id' => Route::create([
                'origin_id' => Location::create(['name' => 'Prototype City A'])->id,
                'destination_id' => Location::create(['name' => 'Prototype City B'])->id,
                'service_category' => ServiceCategory::BIASANE,
            ])->id,
            'bus_id' => Bus::create([
                'plate_number' => 'PROTO-002',
                'model_type' => BusModelType::BIASANE,
                'status' => 'IDLE',
            ])->id,
        ]);

        TripSeat::create(['trip_id' => $trip->id, 'seat_code' => 'A1', 'class_name' => 'Sukian']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        TripSeat::create(['trip_id' => $trip->id, 'seat_code' => 'A1', 'class_name' => 'Sukian']);
    }
}
