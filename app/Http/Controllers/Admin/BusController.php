<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BusModelType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BusRequest;
use App\Models\Bus;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BusController extends Controller
{
    public function index(): View
    {
        return view('admin.buses.index', [
            'buses' => Bus::orderBy('plate_number')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.buses.create', ['modelTypes' => BusModelType::cases()]);
    }

    public function store(BusRequest $request): RedirectResponse
    {
        Bus::create($request->validated());

        return redirect()->route('admin.buses.index')->with('status', 'Bus berhasil ditambahkan.');
    }

    public function edit(Bus $bus): View
    {
        return view('admin.buses.edit', ['bus' => $bus, 'modelTypes' => BusModelType::cases()]);
    }

    public function update(BusRequest $request, Bus $bus): RedirectResponse
    {
        $bus->update($request->validated());

        return redirect()->route('admin.buses.index')->with('status', 'Bus berhasil diperbarui.');
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
