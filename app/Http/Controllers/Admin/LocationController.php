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
            'locations' => Location::orderBy('name')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.locations.create');
    }

    public function store(LocationRequest $request): RedirectResponse
    {
        Location::create($request->validated() + ['is_capital' => false, 'is_important' => false]);

        return redirect()->route('admin.locations.index')->with('status', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Location $location): View
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(LocationRequest $request, Location $location): RedirectResponse
    {
        $location->update($request->validated() + ['is_capital' => false, 'is_important' => false]);

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
}
