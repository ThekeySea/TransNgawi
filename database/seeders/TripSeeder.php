<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Route;
use App\Models\Bus;
use App\Models\Trip;
use App\Models\TripFare;
use App\Models\TripSeat;
use App\Enums\BusModelType;
use App\Support\BusSeatTemplate;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        // Locations
        $sby = Location::firstOrCreate(['name' => 'Surabaya'], ['is_capital' => true, 'is_important' => true]);
        $jkt = Location::firstOrCreate(['name' => 'Jakarta'], ['is_capital' => true, 'is_important' => true]);
        $yog = Location::firstOrCreate(['name' => 'Yogyakarta'], ['is_capital' => false, 'is_important' => true]);
        $srg = Location::firstOrCreate(['name' => 'Semarang'], ['is_capital' => false, 'is_important' => true]);
        $bdo = Location::firstOrCreate(['name' => 'Bandung'], ['is_capital' => false, 'is_important' => false]);

        // Routes
        $antibu = Route::firstOrCreate(
            ['origin_id' => $sby->id, 'destination_id' => $jkt->id, 'service_category' => 'antibu']
        );
        $biasane = Route::firstOrCreate(
            ['origin_id' => $sby->id, 'destination_id' => $yog->id, 'service_category' => 'biasane']
        );

        // Buses
        $busBig = Bus::firstOrCreate(['plate_number' => 'TN-001'], ['model_type' => 'KSATRIA', 'status' => 'IDLE']);
        $busSmall = Bus::firstOrCreate(['plate_number' => 'TN-002'], ['model_type' => 'PLETON', 'status' => 'IDLE']);

        // Trips with seats + fares
        $this->createTrip($antibu, $busBig, Carbon::now()->addDays(2)->setTime(8, 0), Carbon::now()->addDays(2)->setTime(21, 30));
        $this->createTrip($antibu, $busBig, Carbon::now()->addDays(2)->setTime(14, 0), Carbon::now()->addDays(3)->setTime(3, 30));
        $this->createTrip($biasane, $busSmall, Carbon::now()->addDays(3)->setTime(7, 0), Carbon::now()->addDays(3)->setTime(13, 0));
    }

    private function createTrip(Route $route, Bus $bus, Carbon $departs, Carbon $arrives): void
    {
        $trip = Trip::create([
            'trip_code'  => 'TRP-' . strtoupper(Str::random(6)),
            'route_id'   => $route->id,
            'bus_id'     => $bus->id,
            'departs_at' => $departs,
            'arrives_at' => $arrives,
            'status'     => 'SCHEDULED',
        ]);

        $templateSeats = BusSeatTemplate::seats($bus->model_type);
        $allowedClasses = BusSeatTemplate::allowedClasses($bus->model_type);

        // Fares per class
        $fareMap = match ($bus->model_type->resolve()) {
            BusModelType::KSATRIA => ['Sukian' => 195000, 'SukianPlus' => 285000, 'SukianPro' => 420000],
            default => ['Sukian' => 150000, 'SukianPlus' => 220000],
        };

        foreach ($allowedClasses as $class) {
            TripFare::create([
                'trip_id' => $trip->id,
                'class_name' => $class,
                'fare_amount' => $fareMap[$class],
            ]);
        }

        // Seats
        foreach ($templateSeats as $seat) {
            TripSeat::create([
                'trip_id' => $trip->id,
                'seat_code' => $seat['seat_code'],
                'class_name' => $seat['class_name'],
                'status' => 'AVAILABLE',
            ]);
        }
    }
}