<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ServiceCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RouteRequest;
use App\Models\Location;
use App\Models\Route;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminRouteController extends Controller
{
    public function index(): View
    {
        $query = Route::with(['origin', 'destination']);

        if ($service = request('service')) {
            $category = ServiceCategory::tryFrom($service);
            if ($category) {
                $query->where('service_category', $category);
            }
        }

        return view('admin.routes.index', [
            'routes' => $query->orderBy('service_category')->orderBy('id')->paginate(15),
            'services' => ServiceCategory::cases(),
            'activeService' => request('service'),
        ]);
    }

    public function create(): View
    {
        return view('admin.routes.create', [
            'locations' => Location::orderBy('name')->get(),
            'services' => ServiceCategory::cases(),
        ]);
    }

    public function store(RouteRequest $request): RedirectResponse
    {
        Route::create($request->validated());

        return redirect()->route('admin.routes.index')->with('status', 'Rute berhasil ditambahkan.');
    }

    public function edit(Route $route): View
    {
        return view('admin.routes.edit', [
            'route' => $route,
            'locations' => Location::orderBy('name')->get(),
            'services' => ServiceCategory::cases(),
        ]);
    }

    public function update(RouteRequest $request, Route $route): RedirectResponse
    {
        $route->update($request->validated());

        return redirect()->route('admin.routes.index')->with('status', 'Rute berhasil diperbarui.');
    }

    public function destroy(Route $route): RedirectResponse
    {
        if ($route->trips()->exists()) {
            return redirect()->route('admin.routes.index')
                ->with('error', 'Rute tidak bisa dihapus karena masih dipakai trip.');
        }

        $route->delete();

        return redirect()->route('admin.routes.index')->with('status', 'Rute berhasil dihapus.');
    }

    /**
     * AJAX: get routes filtered by service category for dynamic wizard filtering.
     */
    public function filterByService(): \Illuminate\Http\JsonResponse
    {
        $service = request('service');
        $category = ServiceCategory::tryFrom($service);

        if (! $category) {
            return response()->json(['routes' => []]);
        }

        $routes = Route::forService($category)
            ->with(['origin', 'destination'])
            ->orderBy('id')
            ->get()
            ->map(fn (Route $r) => [
                'id' => $r->id,
                'label' => $r->origin->name . ' → ' . $r->destination->name,
            ]);

        return response()->json(['routes' => $routes]);
    }
}
