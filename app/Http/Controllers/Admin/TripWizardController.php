<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ServiceCategory;
use App\Enums\BusStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WizardStepFourRequest;
use App\Http\Requests\Admin\WizardStepFiveRequest;
use App\Http\Requests\Admin\WizardStepOneRequest;
use App\Http\Requests\Admin\WizardStepThreeRequest;
use App\Http\Requests\Admin\WizardStepTwoRequest;
use App\Models\Bus;
use App\Models\Route;
use App\Services\TripCreationService;
use App\Support\BusSeatTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TripWizardController extends Controller
{
    private const SESSION_KEY = 'admin.trip_wizard';

    public function create(int $step): View|RedirectResponse
    {
        if ($step < 1 || $step > 5) {
            abort(404);
        }

        if ($redirect = $this->guard($step)) {
            return $redirect;
        }

        $wizard = session(self::SESSION_KEY, []);
        $data = ['step' => $step, 'wizard' => $wizard];

        if ($step === 1) {
            $data['services'] = ServiceCategory::cases();
        }

        if ($step === 2) {
            $data['routes'] = Route::forService(ServiceCategory::from($wizard['service_category']))
                ->with(['origin', 'destination'])
                ->orderBy('id')
                ->get();
        }

        if ($step === 3) {
            $data['buses'] = Bus::where('status', BusStatus::IDLE)->orderBy('plate_number')->get();
        }

        if ($step === 4) {
            $bus = Bus::findOrFail($wizard['bus_id']);
            $data['bus'] = $bus;
            $data['route'] = Route::with(['origin', 'destination'])->findOrFail($wizard['route_id']);
            $data['allowedClasses'] = BusSeatTemplate::allowedClasses($bus->model_type);
            $data['seatCount'] = count(BusSeatTemplate::seats($bus->model_type));
        }

        if ($step === 5) {
            $data['availableAmenities'] = ['WiFi', 'Toilet', 'USB', 'Selimut', 'Cemilan', 'Bantal', 'Makanan'];

            $route = Route::with(['origin', 'destination'])->findOrFail($wizard['route_id']);
            $service = ServiceCategory::from($wizard['service_category']);

            $originQuery = $route->origin->stopPoints();
            $destinationQuery = $route->destination->stopPoints();

            // For SATSET, only show important points
            if ($service === ServiceCategory::SATSET) {
                $originQuery->where('is_important_point', true);
                $destinationQuery->where('is_important_point', true);
            }

            $data['originStopPoints'] = $originQuery->orderBy('name')->get();
            $data['destinationStopPoints'] = $destinationQuery->orderBy('name')->get();
            $data['route'] = $route;
        }

        return view('admin.trips.create', $data);
    }

    public function storeStepOne(WizardStepOneRequest $request): RedirectResponse
    {
        $previous = session(self::SESSION_KEY.'.service_category');
        $service = $request->validated()['service_category'];

        session()->put(self::SESSION_KEY.'.service_category', $service);

        if ($previous !== null && $previous !== $service) {
            session()->forget([self::SESSION_KEY.'.route_id', self::SESSION_KEY.'.bus_id', self::SESSION_KEY.'.departs_at', self::SESSION_KEY.'.arrives_at', self::SESSION_KEY.'.fares']);
        }

        return redirect()->route('admin.trips.create', ['step' => 2]);
    }

    public function storeStepTwo(WizardStepTwoRequest $request): RedirectResponse
    {
        $previous = session(self::SESSION_KEY.'.route_id');
        $routeId = (int) $request->validated()['route_id'];

        session()->put(self::SESSION_KEY.'.route_id', $routeId);

        if ($previous !== null && $previous !== $routeId) {
            session()->forget([self::SESSION_KEY.'.bus_id', self::SESSION_KEY.'.departs_at', self::SESSION_KEY.'.arrives_at', self::SESSION_KEY.'.fares']);
        }

        return redirect()->route('admin.trips.create', ['step' => 3]);
    }

    public function storeStepThree(WizardStepThreeRequest $request): RedirectResponse
    {
        $previous = session(self::SESSION_KEY.'.bus_id');
        $validated = $request->validated();

        session()->put(self::SESSION_KEY.'.bus_id', (int) $validated['bus_id']);
        session()->put(self::SESSION_KEY.'.departs_at', $validated['departs_at']);
        session()->put(self::SESSION_KEY.'.arrives_at', $validated['arrives_at']);

        if ($previous !== null && $previous !== (int) $validated['bus_id']) {
            session()->forget(self::SESSION_KEY.'.fares');
        }

        return redirect()->route('admin.trips.create', ['step' => 4]);
    }

    public function storeStepFour(WizardStepFourRequest $request): RedirectResponse
    {
        session()->put(self::SESSION_KEY.'.fares', $request->validated()['fares']);

        return redirect()->route('admin.trips.create', ['step' => 5]);
    }

    public function storeStepFive(WizardStepFiveRequest $request, TripCreationService $service): RedirectResponse
    {
        $wizard = session(self::SESSION_KEY, []);
        $validated = $request->validated();

        $wizard['amenities'] = $validated['amenities'] ?? null;
        $wizard['exterior_photos'] = $validated['exterior_photos'] ?? null;
        $wizard['interior_photos'] = $validated['interior_photos'] ?? null;
        $wizard['facility_photos'] = $validated['facility_photos'] ?? null;
        $wizard['origin_stop_point_id'] = $validated['origin_stop_point_id'] ?? null;
        $wizard['destination_stop_point_id'] = $validated['destination_stop_point_id'] ?? null;
        $wizard['origin_address'] = $validated['origin_address'] ?? null;
        $wizard['destination_address'] = $validated['destination_address'] ?? null;
        $wizard['rest_stop_name'] = $validated['rest_stop_name'] ?? null;
        $wizard['rest_stop_address'] = $validated['rest_stop_address'] ?? null;
        $wizard['policy'] = $validated['policy'] ?? null;

        $service->create($wizard);

        session()->forget(self::SESSION_KEY);

        return redirect()->route('admin.trips.index')->with('status', 'Trip berhasil dibuat beserta harga dan kursi.');
    }

    /**
     * Pastikan langkah sebelumnya sudah diisi; kembalikan redirect bila belum.
     */
    private function guard(int $step): ?RedirectResponse
    {
        $wizard = session(self::SESSION_KEY, []);

        if ($step >= 2 && empty($wizard['service_category'])) {
            return redirect()->route('admin.trips.create', ['step' => 1]);
        }

        if ($step >= 3 && empty($wizard['route_id'])) {
            return redirect()->route('admin.trips.create', ['step' => 2]);
        }

        if ($step >= 4 && (empty($wizard['bus_id']) || empty($wizard['departs_at']) || empty($wizard['arrives_at']))) {
            return redirect()->route('admin.trips.create', ['step' => 3]);
        }

        if ($step >= 5 && empty($wizard['fares'])) {
            return redirect()->route('admin.trips.create', ['step' => 4]);
        }

        return null;
    }
}
