<?php

namespace App\Services;

use App\Enums\BusStatus;
use App\Enums\ServiceCategory;
use App\Models\Bus;
use App\Models\Route;
use App\Models\StopPoint;
use App\Models\Trip;
use App\Support\BusSeatTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Orkestrasi pembuatan trip admin: penegakan aturan lokasi, kecocokan
 * kelas-template, dan pembuatan Trip + TripFare + TripSeat transaksional.
 * Satu-satunya sumber kebenaran aturan ini di backend.
 */
class TripCreationService
{
    /**
     * Periksa apakah rute boleh dipakai untuk layanan tertentu.
     * Mengembalikan pesan error (Indonesia) atau null bila boleh.
     */
    public function routeErrorForService(Route $route, ServiceCategory $service): ?string
    {
        if ($route->service_category !== $service) {
            return 'Rute yang dipilih tidak termasuk layanan '.$service->name.'.';
        }

        $route->loadMissing(['origin', 'destination']);

        if ($service === ServiceCategory::ANTIBU
            && (! $route->origin->is_capital || ! $route->destination->is_capital)) {
            return 'ANTIBU hanya boleh memakai rute antar ibu kota (kedua kota harus ibu kota).';
        }

        if ($service === ServiceCategory::SATSET
            && (! $route->origin->is_important || ! $route->destination->is_important)) {
            return 'SATSET hanya boleh memakai rute antar tempat penting (kedua titik harus penting).';
        }

        return null;
    }

    /**
     * Periksa apakah daftar kelas pada harga sesuai template model bus.
     * Mengembalikan pesan error (Indonesia) atau null bila sesuai.
     *
     * @param array<int, string> $classes
     */
    public function fareClassesError(Bus $bus, array $classes): ?string
    {
        $allowed = BusSeatTemplate::allowedClasses($bus->model_type);
        $given = array_values(array_unique($classes));
        sort($given);
        $expected = $allowed;
        sort($expected);

        if ($given !== $expected) {
            return 'Model bus '.$bus->model_type->value.' wajib memakai kelas: '.implode(', ', $allowed).'.';
        }

        return null;
    }

    /**
     * Validasi stop points: harus ada, milik lokasi yang benar, dan untuk SATSET harus important.
     */
    private function validateStopPoints(Route $route, ServiceCategory $service, ?int $originStopPointId, ?int $destStopPointId): void
    {
        if ($originStopPointId) {
            $originSp = StopPoint::find($originStopPointId);
            if (! $originSp) {
                throw ValidationException::withMessages(['origin_stop_point_id' => 'Titik berangkat tidak ditemukan.']);
            }
            if ($originSp->location_id !== $route->origin_id) {
                throw ValidationException::withMessages(['origin_stop_point_id' => 'Titik berangkat harus berada di kota asal yang dipilih.']);
            }
            if ($service === ServiceCategory::SATSET && ! $originSp->is_important_point) {
                throw ValidationException::withMessages(['origin_stop_point_id' => 'SATSET hanya boleh menggunakan titik berangkat yang merupakan tempat penting.']);
            }
        }

        if ($destStopPointId) {
            $destSp = StopPoint::find($destStopPointId);
            if (! $destSp) {
                throw ValidationException::withMessages(['destination_stop_point_id' => 'Titik destinasi tidak ditemukan.']);
            }
            if ($destSp->location_id !== $route->destination_id) {
                throw ValidationException::withMessages(['destination_stop_point_id' => 'Titik destinasi harus berada di kota tujuan yang dipilih.']);
            }
            if ($service === ServiceCategory::SATSET && ! $destSp->is_important_point) {
                throw ValidationException::withMessages(['destination_stop_point_id' => 'SATSET hanya boleh menggunakan titik destinasi yang merupakan tempat penting.']);
            }
        }
    }

    /**
     * Buat trip + harga + inventaris kursi secara transaksional.
     * Memvalidasi ulang semua aturan dari data wizard (jangan percaya sesi/input).
     *
     * @param array{service_category: string, route_id: int, bus_id: int, departs_at: string, arrives_at: string, fares: array<string, int>} $data
     */
    public function create(array $data): Trip
    {
        $service = ServiceCategory::tryFrom($data['service_category'])
            ?? throw ValidationException::withMessages(['service_category' => 'Layanan tidak valid.']);

        $route = Route::with(['origin', 'destination'])->find($data['route_id'])
            ?? throw ValidationException::withMessages(['route_id' => 'Rute tidak ditemukan.']);

        if ($error = $this->routeErrorForService($route, $service)) {
            throw ValidationException::withMessages(['route_id' => $error]);
        }

        $bus = Bus::find($data['bus_id'])
            ?? throw ValidationException::withMessages(['bus_id' => 'Bus tidak ditemukan.']);

        if (! $bus->status->canBeAssigned()) {
            throw ValidationException::withMessages(['bus_id' => 'Bus "'.$bus->plate_number.'" berstatus '.$bus->status->label().' dan tidak bisa ditugaskan ke trip baru.']);
        }

        if ($error = $this->fareClassesError($bus, array_keys($data['fares'] ?? []))) {
            throw ValidationException::withMessages(['fares' => $error]);
        }

        foreach ($data['fares'] as $amount) {
            if (! is_numeric($amount) || (int) $amount < 1000) {
                throw ValidationException::withMessages(['fares' => 'Harga tiap kelas minimal Rp1.000.']);
            }
        }

        $this->validateStopPoints(
            $route,
            $service,
            $data['origin_stop_point_id'] ?? null,
            $data['destination_stop_point_id'] ?? null
        );

        return DB::transaction(function () use ($data, $bus) {
            $trip = Trip::create([
                'route_id' => $data['route_id'],
                'bus_id' => $data['bus_id'],
                'departs_at' => $data['departs_at'],
                'arrives_at' => $data['arrives_at'],
                'amenities' => $data['amenities'] ?? null,
                'exterior_photos' => $data['exterior_photos'] ?? null,
                'interior_photos' => $data['interior_photos'] ?? null,
                'facility_photos' => $data['facility_photos'] ?? null,
                'origin_stop_point_id' => $data['origin_stop_point_id'] ?? null,
                'destination_stop_point_id' => $data['destination_stop_point_id'] ?? null,
                'origin_address' => $data['origin_address'] ?? null,
                'destination_address' => $data['destination_address'] ?? null,
                'rest_stop_name' => $data['rest_stop_name'] ?? null,
                'rest_stop_address' => $data['rest_stop_address'] ?? null,
                'policy' => $data['policy'] ?? null,
            ]);

            foreach ($data['fares'] as $class => $amount) {
                $trip->fares()->create(['class_name' => $class, 'fare_amount' => (int) $amount]);
            }

            foreach (BusSeatTemplate::seats($bus->model_type) as $seat) {
                $trip->seats()->create($seat);
            }

            // Automatically set bus to ACTIVE when trip is assigned
            $bus->update(['status' => BusStatus::ACTIVE]);

            return $trip;
        });
    }
}
