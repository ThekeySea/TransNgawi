<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BusModelType;
use App\Enums\BusStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BusRequest;
use App\Models\Bus;
use App\Models\Trip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BusController extends Controller
{
    public function index(): View
    {
        $buses = Bus::orderBy('plate_number')->paginate(15);

        // Eager load upcoming trips for ACTIVE buses
        foreach ($buses as $bus) {
            if ($bus->status === BusStatus::ACTIVE) {
                $bus->load(['trips' => function ($query) {
                    $query->where('departs_at', '>', now()->subDay())
                        ->orderBy('departs_at')
                        ->limit(1);
                }]);
                $bus->setRelation('upcomingTrip', $bus->trips->first());
            }
        }

        return view('admin.buses.index', [
            'buses' => $buses,
        ]);
    }

    public function create(): View
    {
        return view('admin.buses.create', ['modelTypes' => BusModelType::activeCases()]);
    }

    public function store(BusRequest $request): RedirectResponse
    {
        Bus::create($request->validated());

        return redirect()->route('admin.buses.index')->with('status', 'Bus berhasil ditambahkan.');
    }

    public function edit(Bus $bus): View
    {
        return view('admin.buses.edit', ['bus' => $bus, 'modelTypes' => BusModelType::activeCases()]);
    }

    public function update(BusRequest $request, Bus $bus): RedirectResponse
    {
        $bus->update($request->validated());

        return redirect()->route('admin.buses.index')->with('status', 'Bus berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Bus $bus): RedirectResponse
    {
        $request->validate([
            'status' => ['required', \Illuminate\Validation\Rule::enum(BusStatus::class)],
        ]);

        $newStatus = BusStatus::from($request->input('status'));

        // Prevent manual change to IDLE if bus has upcoming trips
        if ($newStatus === BusStatus::IDLE && $bus->status !== BusStatus::IDLE) {
            $hasUpcomingTrips = Trip::where('bus_id', $bus->id)
                ->where('departs_at', '>', now())
                ->exists();

            if ($hasUpcomingTrips) {
                return redirect()->route('admin.buses.index')
                    ->with('error', 'Bus tidak bisa diubah ke Tersedia (IDLE) karena masih memiliki trip yang akan datang.');
            }
        }

        $bus->update(['status' => $newStatus]);

        return redirect()->route('admin.buses.index')->with('status', 'Status bus "'.$bus->plate_number.'" diperbarui ke '.$bus->status->label().'.');
    }

    public function destroy(Bus $bus): RedirectResponse
    {
        if ($bus->trips()->exists()) {
            return redirect()->route('admin.buses.index')
                ->with('error', 'Bus tidak bisa dihapus karena masih punya trip.');
        }

        $bus->delete();

        return redirect()->route('admin.buses.index')->with('status', 'Bus berhasil dihapus.');
    }
}
