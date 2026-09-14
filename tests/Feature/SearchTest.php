<?php

namespace Tests\Feature;

use App\Models\Bus;
use App\Models\Location;
use App\Models\Route;
use App\Models\StopPoint;
use App\Models\Trip;
use App\Models\TripFare;
use App\Models\TripSeat;
use App\Support\BusSeatTemplate;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    private function createTripWithDetails(array $overrides = []): Trip
    {
        $origin = Location::firstOrCreate(['name' => 'Surabaya'], ['is_capital' => true]);
        $destination = Location::firstOrCreate(['name' => 'Jakarta'], ['is_capital' => true]);

        $route = Route::firstOrCreate([
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'service_category' => 'antibu',
        ]);

        $bus = Bus::create([
            'plate_number' => 'S'.rand(1000, 9999).'U',
            'model_type' => 'ANTIBU_SATSET',
            'status' => 'ACTIVE',
        ]);

        $trip = Trip::create(array_merge([
            'route_id' => $route->id,
            'bus_id' => $bus->id,
            'departs_at' => Carbon::now()->addDays(3)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(21, 30),
        ], $overrides));

        TripFare::create(['trip_id' => $trip->id, 'class_name' => 'Sukian', 'fare_amount' => 195000]);
        TripFare::create(['trip_id' => $trip->id, 'class_name' => 'SukianPlus', 'fare_amount' => 285000]);
        TripFare::create(['trip_id' => $trip->id, 'class_name' => 'SukianPro', 'fare_amount' => 420000]);

        foreach (BusSeatTemplate::seats($bus->model_type) as $seat) {
            TripSeat::create(array_merge($seat, ['trip_id' => $trip->id]));
        }

        return $trip;
    }

    public function test_search_page_renders_with_real_trips(): void
    {
        $trip = $this->createTripWithDetails();

        $response = $this->get(route('perjalanan.index'));

        $response->assertOk();
        $response->assertSee('Cari Perjalanan');
        $response->assertSee($trip->route->origin->name);
        $response->assertSee($trip->route->destination->name);
    }

    public function test_search_filters_by_origin(): void
    {
        $this->createTripWithDetails();

        $otherOrigin = Location::firstOrCreate(['name' => 'Yogyakarta'], ['is_capital' => true]);
        $otherDest = Location::firstOrCreate(['name' => 'Bandung'], ['is_capital' => true]);
        $otherRoute = Route::create([
            'origin_id' => $otherOrigin->id,
            'destination_id' => $otherDest->id,
            'service_category' => 'antibu',
        ]);
        $otherBus = Bus::create(['plate_number' => 'Y'.rand(1000, 9999).'B', 'model_type' => 'ANTIBU_SATSET', 'status' => 'ACTIVE']);
        Trip::create([
            'route_id' => $otherRoute->id,
            'bus_id' => $otherBus->id,
            'departs_at' => Carbon::now()->addDays(3)->setTime(9, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(20, 0),
        ]);

        $response = $this->get(route('perjalanan.index', ['origin' => 'Surabaya']));
        $response->assertOk();
        $response->assertSee('Surabaya');
        $response->assertDontSee('Yogyakarta');
    }

    public function test_search_filters_by_destination(): void
    {
        $this->createTripWithDetails();

        $otherOrigin = Location::firstOrCreate(['name' => 'Yogyakarta'], ['is_capital' => true]);
        $otherDest = Location::firstOrCreate(['name' => 'Bandung'], ['is_capital' => true]);
        $otherRoute = Route::create([
            'origin_id' => $otherOrigin->id,
            'destination_id' => $otherDest->id,
            'service_category' => 'antibu',
        ]);
        $otherBus = Bus::create(['plate_number' => 'Y'.rand(1000, 9999).'B', 'model_type' => 'ANTIBU_SATSET', 'status' => 'ACTIVE']);
        Trip::create([
            'route_id' => $otherRoute->id,
            'bus_id' => $otherBus->id,
            'departs_at' => Carbon::now()->addDays(3)->setTime(9, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(20, 0),
        ]);

        $response = $this->get(route('perjalanan.index', ['destination' => 'Jakarta']));
        $response->assertOk();
        $response->assertSee('Jakarta');
        $response->assertDontSee('Bandung');
    }

    public function test_search_filters_by_service(): void
    {
        $this->createTripWithDetails();

        $biasaneOrigin = Location::firstOrCreate(['name' => 'Semarang'], ['is_capital' => true]);
        $biasaneDest = Location::firstOrCreate(['name' => 'Solo'], ['is_capital' => true]);
        $biasaneRoute = Route::create([
            'origin_id' => $biasaneOrigin->id,
            'destination_id' => $biasaneDest->id,
            'service_category' => 'biasane',
        ]);
        $biasaneBus = Bus::create(['plate_number' => 'B'.rand(1000, 9999).'S', 'model_type' => 'BIASANE', 'status' => 'ACTIVE']);
        Trip::create([
            'route_id' => $biasaneRoute->id,
            'bus_id' => $biasaneBus->id,
            'departs_at' => Carbon::now()->addDays(3)->setTime(7, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(12, 0),
        ]);

        $response = $this->get(route('perjalanan.index', ['service' => 'antibu']));
        $response->assertOk();
        $response->assertSee('Surabaya');
        $response->assertDontSee('Semarang');
    }

    public function test_search_filters_by_date_preset_7_days(): void
    {
        $tripSoon = $this->createTripWithDetails([
            'departs_at' => Carbon::now()->addDays(3)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(21, 30),
        ]);

        $origin2 = Location::firstOrCreate(['name' => 'Malang'], ['is_capital' => false]);
        $dest2 = Location::firstOrCreate(['name' => 'Denpasar'], ['is_capital' => true]);
        $route2 = Route::create(['origin_id' => $origin2->id, 'destination_id' => $dest2->id, 'service_category' => 'antibu']);
        $bus2 = Bus::create(['plate_number' => 'D'.rand(1000, 9999).'X', 'model_type' => 'ANTIBU_SATSET', 'status' => 'ACTIVE']);
        $tripLater = Trip::create([
            'route_id' => $route2->id,
            'bus_id' => $bus2->id,
            'departs_at' => Carbon::now()->addDays(10)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(10)->setTime(21, 30),
        ]);

        $response = $this->get(route('perjalanan.index', ['date_preset' => '7_days']));
        $response->assertOk();
        $response->assertSee($tripSoon->route->origin->name);
        $response->assertDontSee($tripLater->route->origin->name);
    }

    public function test_search_filters_by_date_preset_14_days(): void
    {
        $tripSoon = $this->createTripWithDetails([
            'departs_at' => Carbon::now()->addDays(3)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(21, 30),
        ]);

        $origin2 = Location::firstOrCreate(['name' => 'Malang'], ['is_capital' => false]);
        $dest2 = Location::firstOrCreate(['name' => 'Denpasar'], ['is_capital' => true]);
        $route2 = Route::create(['origin_id' => $origin2->id, 'destination_id' => $dest2->id, 'service_category' => 'antibu']);
        $bus2 = Bus::create(['plate_number' => 'D'.rand(1000, 9999).'X', 'model_type' => 'ANTIBU_SATSET', 'status' => 'ACTIVE']);
        $tripLater = Trip::create([
            'route_id' => $route2->id,
            'bus_id' => $bus2->id,
            'departs_at' => Carbon::now()->addDays(20)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(20)->setTime(21, 30),
        ]);

        $response = $this->get(route('perjalanan.index', ['date_preset' => '14_days']));
        $response->assertOk();
        $response->assertSee($tripSoon->route->origin->name);
        $response->assertDontSee($tripLater->route->origin->name);
    }

    public function test_search_filters_by_date_preset_30_days(): void
    {
        $tripSoon = $this->createTripWithDetails([
            'departs_at' => Carbon::now()->addDays(3)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(21, 30),
        ]);

        $origin2 = Location::firstOrCreate(['name' => 'Malang'], ['is_capital' => false]);
        $dest2 = Location::firstOrCreate(['name' => 'Denpasar'], ['is_capital' => true]);
        $route2 = Route::create(['origin_id' => $origin2->id, 'destination_id' => $dest2->id, 'service_category' => 'antibu']);
        $bus2 = Bus::create(['plate_number' => 'D'.rand(1000, 9999).'X', 'model_type' => 'ANTIBU_SATSET', 'status' => 'ACTIVE']);
        $tripLater = Trip::create([
            'route_id' => $route2->id,
            'bus_id' => $bus2->id,
            'departs_at' => Carbon::now()->addDays(35)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(35)->setTime(21, 30),
        ]);

        $response = $this->get(route('perjalanan.index', ['date_preset' => '30_days']));
        $response->assertOk();
        $response->assertSee($tripSoon->route->origin->name);
        $response->assertDontSee($tripLater->route->origin->name);
    }

    public function test_search_filters_by_specific_date(): void
    {
        $targetDate = Carbon::now()->addDays(5)->toDateString();

        $tripOnDate = $this->createTripWithDetails([
            'departs_at' => Carbon::parse($targetDate)->setTime(8, 0),
            'arrives_at' => Carbon::parse($targetDate)->setTime(21, 30),
        ]);

        $origin2 = Location::firstOrCreate(['name' => 'Malang'], ['is_capital' => false]);
        $dest2 = Location::firstOrCreate(['name' => 'Denpasar'], ['is_capital' => true]);
        $route2 = Route::create(['origin_id' => $origin2->id, 'destination_id' => $dest2->id, 'service_category' => 'antibu']);
        $bus2 = Bus::create(['plate_number' => 'D'.rand(1000, 9999).'X', 'model_type' => 'ANTIBU_SATSET', 'status' => 'ACTIVE']);
        $tripOtherDate = Trip::create([
            'route_id' => $route2->id,
            'bus_id' => $bus2->id,
            'departs_at' => Carbon::now()->addDays(7)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(7)->setTime(21, 30),
        ]);

        $response = $this->get(route('perjalanan.index', ['date' => $targetDate]));
        $response->assertOk();
        $response->assertSee($tripOnDate->route->origin->name);
        $response->assertDontSee($tripOtherDate->route->origin->name);
    }

    public function test_search_sorts_by_departure_earliest(): void
    {
        $earlyTrip = $this->createTripWithDetails([
            'departs_at' => Carbon::now()->addDays(3)->setTime(6, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(19, 30),
        ]);

        $lateTrip = $this->createTripWithDetails([
            'departs_at' => Carbon::now()->addDays(3)->setTime(14, 0),
            'arrives_at' => Carbon::now()->addDays(4)->setTime(3, 30),
        ]);

        $response = $this->get(route('perjalanan.index', ['sort' => 'departure_earliest']));
        $response->assertOk();

        $trips = $this->extractTripsFromResponse($response);
        $this->assertCount(2, $trips);
        $this->assertEquals('06:00', $trips[0]['departure']);
        $this->assertEquals('14:00', $trips[1]['departure']);
    }

    public function test_search_sorts_by_departure_latest(): void
    {
        $earlyTrip = $this->createTripWithDetails([
            'departs_at' => Carbon::now()->addDays(3)->setTime(6, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(19, 30),
        ]);

        $lateTrip = $this->createTripWithDetails([
            'departs_at' => Carbon::now()->addDays(3)->setTime(14, 0),
            'arrives_at' => Carbon::now()->addDays(4)->setTime(3, 30),
        ]);

        $response = $this->get(route('perjalanan.index', ['sort' => 'departure_latest']));
        $response->assertOk();

        $trips = $this->extractTripsFromResponse($response);
        $this->assertCount(2, $trips);
        $this->assertEquals('14:00', $trips[0]['departure']);
        $this->assertEquals('06:00', $trips[1]['departure']);
    }

    public function test_search_sorts_by_price_lowest(): void
    {
        $cheapTrip = $this->createTripWithDetails([
            'departs_at' => Carbon::now()->addDays(3)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(21, 30),
        ]);
        $cheapTrip->fares()->where('class_name', 'Sukian')->update(['fare_amount' => 100000]);
        $cheapTrip->fares()->where('class_name', 'SukianPlus')->update(['fare_amount' => 150000]);
        $cheapTrip->fares()->where('class_name', 'SukianPro')->update(['fare_amount' => 200000]);

        $expensiveTrip = $this->createTripWithDetails([
            'departs_at' => Carbon::now()->addDays(4)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(4)->setTime(21, 30),
        ]);
        $expensiveTrip->fares()->where('class_name', 'Sukian')->update(['fare_amount' => 300000]);
        $expensiveTrip->fares()->where('class_name', 'SukianPlus')->update(['fare_amount' => 400000]);
        $expensiveTrip->fares()->where('class_name', 'SukianPro')->update(['fare_amount' => 500000]);

        $response = $this->get(route('perjalanan.index', ['sort' => 'price_lowest']));
        $response->assertOk();

        $trips = $this->extractTripsFromResponse($response);
        $this->assertCount(2, $trips);
        $this->assertEquals(100000, $trips[0]['price']);
        $this->assertEquals(300000, $trips[1]['price']);
    }

    public function test_search_sorts_by_price_highest(): void
    {
        $cheapTrip = $this->createTripWithDetails([
            'departs_at' => Carbon::now()->addDays(3)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(21, 30),
        ]);
        $cheapTrip->fares()->where('class_name', 'Sukian')->update(['fare_amount' => 100000]);
        $cheapTrip->fares()->where('class_name', 'SukianPlus')->update(['fare_amount' => 150000]);
        $cheapTrip->fares()->where('class_name', 'SukianPro')->update(['fare_amount' => 200000]);

        $expensiveTrip = $this->createTripWithDetails([
            'departs_at' => Carbon::now()->addDays(4)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(4)->setTime(21, 30),
        ]);
        $expensiveTrip->fares()->where('class_name', 'Sukian')->update(['fare_amount' => 300000]);
        $expensiveTrip->fares()->where('class_name', 'SukianPlus')->update(['fare_amount' => 400000]);
        $expensiveTrip->fares()->where('class_name', 'SukianPro')->update(['fare_amount' => 500000]);

        $response = $this->get(route('perjalanan.index', ['sort' => 'price_highest']));
        $response->assertOk();

        $trips = $this->extractTripsFromResponse($response);
        $this->assertCount(2, $trips);
        $this->assertEquals(300000, $trips[0]['price']);
        $this->assertEquals(100000, $trips[1]['price']);
    }

    private function extractTripsFromResponse($response): array
    {
        $content = $response->content();
        preg_match('/allTrips:\s*JSON\.parse\(\'(.+?)\'\)/', $content, $matches);
        $this->assertNotEmpty($matches, 'Could not find allTrips JSON in response');
        $json = str_replace('\u0022', '"', $matches[1]);
        return json_decode($json, true);
    }

    public function test_search_empty_state_when_no_results(): void
    {
        $response = $this->get(route('perjalanan.index', [
            'origin' => 'Kota Tidak Ada',
            'destination' => 'Kota Lain',
        ]));
        $response->assertOk();
        $response->assertSee('Tidak ada perjalanan ditemukan');
    }

    public function test_search_shows_stop_point_names_in_route(): void
    {
        $origin = Location::firstOrCreate(['name' => 'Surabaya'], ['is_capital' => true, 'is_important' => true]);
        $destination = Location::firstOrCreate(['name' => 'Jakarta'], ['is_capital' => true, 'is_important' => true]);
        $route = Route::create(['origin_id' => $origin->id, 'destination_id' => $destination->id, 'service_category' => 'antibu']);
        $bus = Bus::create(['plate_number' => 'S'.rand(1000, 9999).'U', 'model_type' => 'ANTIBU_SATSET', 'status' => 'ACTIVE']);

        $originSp = StopPoint::create(['location_id' => $origin->id, 'name' => 'Terminal Purabaya']);
        $destSp = StopPoint::create(['location_id' => $destination->id, 'name' => 'Terminal Bus Pulo Gadung']);

        $trip = Trip::create([
            'route_id' => $route->id,
            'bus_id' => $bus->id,
            'departs_at' => Carbon::now()->addDays(3)->setTime(8, 0),
            'arrives_at' => Carbon::now()->addDays(3)->setTime(21, 30),
            'origin_stop_point_id' => $originSp->id,
            'destination_stop_point_id' => $destSp->id,
        ]);

        TripFare::create(['trip_id' => $trip->id, 'class_name' => 'Sukian', 'fare_amount' => 195000]);

        $response = $this->get(route('perjalanan.index'));
        $response->assertOk();
        $response->assertSee('Terminal Purabaya');
        $response->assertSee('Terminal Bus Pulo Gadung');
    }

    public function test_search_shows_bus_model_in_json_data(): void
    {
        $trip = $this->createTripWithDetails();

        $response = $this->get(route('perjalanan.index'));
        $response->assertOk();

        // Bus model is rendered client-side via Alpine.js, check it in the JSON data
        $content = $response->content();
        $this->assertStringContainsString('ANTIBU', $content);
        $this->assertStringContainsString('bus_model', $content);
    }
}
