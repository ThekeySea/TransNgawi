<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        return view('admin.locations.index', [
            'locations' => Location::withCount('stopPoints')->orderBy('name')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.locations.create');
    }

    public function store(LocationRequest $request): RedirectResponse
    {
        $location = Location::create($request->validated() + ['is_capital' => false, 'is_important' => false]);

        $this->syncStopPoints($location, $request->input('stop_points', []));

        return redirect()->route('admin.locations.index')->with('status', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Location $location): View
    {
        $location->load('stopPoints');

        return view('admin.locations.edit', compact('location'));
    }

    public function update(LocationRequest $request, Location $location): RedirectResponse
    {
        $location->update($request->validated() + ['is_capital' => false, 'is_important' => false]);

        $this->syncStopPoints($location, $request->input('stop_points', []));

        return redirect()->route('admin.locations.index')->with('status', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        if ($location->originatingRoutes()->exists() || $location->destinationRoutes()->exists()) {
            return redirect()->route('admin.locations.index')
                ->with('error', 'Lokasi tidak bisa dihapus karena masih dipakai rute.');
        }

        $location->delete();

        return redirect()->route('admin.locations.index')->with('status', 'Lokasi berhasil dihapus.');
    }

    /**
     * Sync stop points for a location: create new, update existing, delete removed.
     */
    private function syncStopPoints(Location $location, array $stopPoints): void
    {
        $submittedIds = collect($stopPoints)
            ->filter(fn (array $point) => ! empty($point['id']))
            ->pluck('id')
            ->toArray();

        // Delete stop points not in the submitted list
        $location->stopPoints()
            ->whereNotIn('id', $submittedIds)
            ->delete();

        foreach ($stopPoints as $point) {
            if (empty($point['name'])) {
                continue;
            }

            $isImportantPoint = ! empty($point['is_important_point']) && $point['is_important_point'] !== '0';

            // Only allow is_important_point if location is_important
            if ($isImportantPoint && ! $location->is_important) {
                $isImportantPoint = false;
            }

            if (! empty($point['id'])) {
                // Update existing
                $location->stopPoints()->where('id', $point['id'])->update([
                    'name' => $point['name'],
                    'address' => $point['address'] ?? null,
                    'is_important_point' => $isImportantPoint,
                ]);
            } else {
                // Create new
                $location->stopPoints()->create([
                    'name' => $point['name'],
                    'address' => $point['address'] ?? null,
                    'is_important_point' => $isImportantPoint,
                ]);
            }
        }
    }
}
