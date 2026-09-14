<?php

namespace Tests\Feature;

use App\Models\Bus;
use App\Models\Location;
use App\Models\Route;
use App\Models\Trip;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function seedCatalog(): array
    {
        $capitalA = Location::create(['name' => 'Kota Ibukota A', 'is_capital' => true, 'is_important' => true]);
        $capitalB = Location::create(['name' => 'Kota Ibukota B', 'is_capital' => true, 'is_important' => true]);
        $townA = Location::create(['name' => 'Kota Biasa A']);
        $townB = Location::create(['name' => 'Kota Biasa B']);

        $antibu = Route::create(['origin_id' => $capitalA->id, 'destination_id' => $capitalB->id, 'service_category' => 'antibu']);
        $biasane = Route::create(['origin_id' => $townA->id, 'destination_id' => $townB->id, 'service_category' => 'biasane']);

        $smallBus = Bus::create(['plate_number' => 'ADM-40', 'model_type' => 'BIASANE', 'status' => 'IDLE']);
        $bigBus = Bus::create(['plate_number' => 'ADM-30', 'model_type' => 'ANTIBU_SATSET', 'status' => 'IDLE']);

        return compact('capitalA', 'capitalB', 'townA', 'townB', 'antibu', 'biasane', 'smallBus', 'bigBus');
    }

    public function test_guest_is_redirected_from_admin(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_non_admin_gets_forbidden_on_admin(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->get('/admin')->assertForbidden();
        $this->actingAs($user)->get('/admin/locations')->assertForbidden();
    }

    public function test_admin_sees_dashboard(): void
    {
        $this->actingAs($this->admin())->get('/admin')->assertOk();
    }

    public function test_admin_manages_locations(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/locations', ['name' => 'Kota Baru'])
            ->assertRedirect(route('admin.locations.index'));
        $this->assertDatabaseHas('locations', ['name' => 'Kota Baru', 'is_capital' => false]);

        $this->actingAs($admin)->post('/admin/locations', ['name' => ''])
            ->assertSessionHasErrors('name');

        $location = Location::where('name', 'Kota Baru')->first();
        $this->actingAs($admin)->put("/admin/locations/{$location->id}", [
            'name' => 'Kota Baru', 'is_capital' => '1',
        ])->assertRedirect(route('admin.locations.index'));
        $this->assertTrue($location->fresh()->is_capital);
    }

    public function test_location_in_use_cannot_be_deleted(): void
    {
        ['townA' => $town] = $this->seedCatalog();

        $this->actingAs($this->admin())->delete("/admin/locations/{$town->id}")
            ->assertRedirect(route('admin.locations.index'));

        $this->assertDatabaseHas('locations', ['id' => $town->id]);
    }

    public function test_admin_manages_buses_and_rejects_bad_model(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/buses', [
            'plate_number' => 'ADM-001', 'model_type' => 'PESAWAT', 'status' => 'IDLE',
        ])->assertSessionHasErrors('model_type');

        $this->actingAs($admin)->post('/admin/buses', [
            'plate_number' => 'ADM-001', 'model_type' => 'BIASANE', 'status' => 'IDLE',
        ])->assertRedirect(route('admin.buses.index'));
        $this->assertDatabaseHas('buses', ['plate_number' => 'ADM-001']);
    }

    public function test_wizard_happy_path_creates_trip_with_template_seats(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane'])
            ->assertRedirect(route('admin.trips.create', ['step' => 2]));

        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id])
            ->assertRedirect(route('admin.trips.create', ['step' => 3]));

        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ])->assertRedirect(route('admin.trips.create', ['step' => 4]));

        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ])->assertRedirect(route('admin.trips.create', ['step' => 5]));

        $this->actingAs($admin)->post('/admin/trips/create/step-5', [])
            ->assertRedirect(route('admin.trips.index'));

        $trip = Trip::first();
        $this->assertNotNull($trip);
        $this->assertCount(2, $trip->fares);
        $this->assertCount(40, $trip->seats);
        $this->assertEquals(0, $trip->seats()->where('class_name', 'SukianPro')->count());
    }

    public function test_wizard_antibu_rejects_non_capital_route(): void
    {
        ['biasane' => $plainRoute] = $this->seedCatalog();

        $response = $this->actingAs($this->admin())->post('/admin/trips/create/step-1', ['service_category' => 'antibu']);
        $response->assertRedirect(route('admin.trips.create', ['step' => 2]));

        // Paksa rute non-ibu-kota walau dropdown menyembunyikannya: backend harus menolak.
        $this->actingAs($this->admin())->post('/admin/trips/create/step-2', ['route_id' => $plainRoute->id])
            ->assertSessionHasErrors('route_id');

        $this->assertCount(0, Trip::all());
    }

    public function test_wizard_satset_rejects_non_important_route(): void
    {
        $plain = Location::create(['name' => 'Kota Polos A']);
        $plainB = Location::create(['name' => 'Kota Polos B']);
        $route = Route::create(['origin_id' => $plain->id, 'destination_id' => $plainB->id, 'service_category' => 'satset']);

        $this->actingAs($this->admin())->post('/admin/trips/create/step-1', ['service_category' => 'satset'])
            ->assertRedirect(route('admin.trips.create', ['step' => 2]));

        $this->actingAs($this->admin())->post('/admin/trips/create/step-2', ['route_id' => $route->id])
            ->assertSessionHasErrors('route_id');

        $this->assertCount(0, Trip::all());
    }

    public function test_wizard_rejects_sukianpro_fare_on_biasane_bus(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);

        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000, 'SukianPro' => 420000],
        ])->assertSessionHasErrors('fares');

        $this->assertCount(0, Trip::all());
    }

    public function test_wizard_antibu_satset_bus_sells_all_three_classes(): void
    {
        ['antibu' => $route, 'bigBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'antibu']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000, 'SukianPro' => 420000],
        ])->assertRedirect(route('admin.trips.create', ['step' => 5]));

        $this->actingAs($admin)->post('/admin/trips/create/step-5', [])
            ->assertRedirect(route('admin.trips.index'));

        $trip = Trip::first();
        $this->assertCount(3, $trip->fares);
        $this->assertCount(30, $trip->seats);
        $this->assertEquals(9, $trip->seats()->where('class_name', 'SukianPro')->count());
    }

    public function test_wizard_steps_cannot_be_skipped(): void
    {
        $this->actingAs($this->admin())->get('/admin/trips/create/3')
            ->assertRedirect(route('admin.trips.create', ['step' => 1]));

        $this->actingAs($this->admin())->get('/admin/trips/create/6')->assertNotFound();
    }

    public function test_all_admin_pages_render(): void
    {
        ['antibu' => $route, 'bigBus' => $bus] = $this->seedCatalog();
        $location = Location::first();
        $admin = $this->admin();

        $this->actingAs($admin)->get('/admin/locations')->assertOk()->assertSee('Lokasi');
        $this->actingAs($admin)->get('/admin/locations/create')->assertOk()->assertSee('Ibu kota');
        $this->actingAs($admin)->get("/admin/locations/{$location->id}/edit")->assertOk()->assertSee('Ubah Lokasi');
        $this->actingAs($admin)->get('/admin/buses')->assertOk()->assertSee('Model');
        $this->actingAs($admin)->get('/admin/buses/create')->assertOk()->assertSee('Template Kursi');
        $this->actingAs($admin)->get("/admin/buses/{$bus->id}/edit")->assertOk()->assertSee('Ubah Bus');
        $this->actingAs($admin)->get('/admin/trips')->assertOk()->assertSee('Buat Trip');

        $this->actingAs($admin)->get('/admin/trips/create/1')->assertOk()->assertSee('Pilih layanan');
        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'antibu']);
        $this->actingAs($admin)->get('/admin/trips/create/2')->assertOk()->assertSee('Pilih rute');
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->get('/admin/trips/create/3')->assertOk()->assertSee('Pilih bus');
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->get('/admin/trips/create/4')->assertOk()->assertSee('Harga per kelas');
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000, 'SukianPro' => 420000],
        ]);
        $this->actingAs($admin)->get('/admin/trips/create/5')->assertOk()->assertSee('Detail Trip');

        $this->actingAs($admin)->get('/admin/analisa')->assertOk()->assertSee('Analisa');
        $this->actingAs($admin)->get('/admin/analisa?period=30days')->assertOk()->assertSee('30 Hari');
    }

    public function test_validation_errors_rerender_forms(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => '']);
        $response->assertSessionHasErrors('service_category');
        $this->actingAs($admin)->get('/admin/trips/create/1')->assertOk()->assertSee('Pilih layanan');
    }

    public function test_maintenance_bus_cannot_be_assigned_to_trip(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $bus->update(['status' => \App\Enums\BusStatus::MAINTENANCE]);

        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);

        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ])->assertSessionHasErrors('bus_id');

        $this->assertCount(0, Trip::all());
    }

    public function test_active_bus_cannot_be_assigned_to_trip(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $bus->update(['status' => \App\Enums\BusStatus::ACTIVE]);

        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);

        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ])->assertSessionHasErrors('bus_id');

        $this->assertCount(0, Trip::all());
    }

    public function test_idle_bus_can_be_assigned_to_trip(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $bus->update(['status' => \App\Enums\BusStatus::IDLE]);

        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);

        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ])->assertRedirect(route('admin.trips.create', ['step' => 4]));
    }

    public function test_wizard_step_three_only_shows_idle_buses(): void
    {
        ['biasane' => $route, 'smallBus' => $idleBus] = $this->seedCatalog();
        $admin = $this->admin();

        $maintenanceBus = Bus::create(['plate_number' => 'MNT-01', 'model_type' => 'BIASANE', 'status' => 'MAINTENANCE']);

        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);

        $response = $this->actingAs($admin)->get('/admin/trips/create/3');
        $response->assertOk();
        $response->assertSee($idleBus->plate_number);
        $response->assertDontSee($maintenanceBus->plate_number);
    }

    public function test_bus_status_update(): void
    {
        ['smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $this->actingAs($admin)->patch("/admin/buses/{$bus->id}/status", ['status' => 'MAINTENANCE'])
            ->assertRedirect(route('admin.buses.index'));

        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'status' => 'MAINTENANCE']);

        $this->actingAs($admin)->patch("/admin/buses/{$bus->id}/status", ['status' => 'IDLE'])
            ->assertRedirect(route('admin.buses.index'));

        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'status' => 'IDLE']);
    }

    public function test_bus_issue_creation(): void
    {
        ['smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $this->actingAs($admin)->post("/admin/buses/{$bus->id}/issues", [
            'category' => 'Mesin',
            'description' => 'Mesin berbunyi tidak normal',
            'severity' => 'HIGH',
        ])->assertRedirect(route('admin.buses.issues.index', $bus));

        $this->assertDatabaseHas('bus_issues', [
            'bus_id' => $bus->id,
            'category' => 'Mesin',
            'severity' => 'HIGH',
            'status' => 'OPEN',
        ]);
    }

    public function test_bus_issues_index_renders(): void
    {
        ['smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $this->actingAs($admin)->get("/admin/buses/{$bus->id}/issues")->assertOk()->assertSee('Masalah Bus');
    }

    // ── Route CRUD Tests ──────────────────────────────────────────────

    public function test_admin_manages_routes(): void
    {
        $admin = $this->admin();
        ['capitalA' => $capitalA, 'capitalB' => $capitalB, 'townA' => $townA, 'townB' => $townB] = $this->seedCatalog();

        $this->actingAs($admin)->get('/admin/routes')->assertOk()->assertSee('Rute');
        $this->actingAs($admin)->get('/admin/routes/create')->assertOk()->assertSee('Tambah Rute');

        // Use unique locations to avoid UNIQUE conflict
        $c = Location::create(['name' => 'Kota C']);
        $d = Location::create(['name' => 'Kota D']);
        $this->actingAs($admin)->post('/admin/routes', [
            'origin_id' => $c->id,
            'destination_id' => $d->id,
            'service_category' => 'biasane',
        ])->assertRedirect(route('admin.routes.index'));

        $this->assertDatabaseHas('routes', [
            'origin_id' => $c->id,
            'destination_id' => $d->id,
            'service_category' => 'biasane',
        ]);
    }

    public function test_route_rejects_same_origin_and_destination(): void
    {
        $admin = $this->admin();
        ['capitalA' => $capitalA] = $this->seedCatalog();

        $this->actingAs($admin)->post('/admin/routes', [
            'origin_id' => $capitalA->id,
            'destination_id' => $capitalA->id,
            'service_category' => 'antibu',
        ])->assertSessionHasErrors('destination_id');
    }

    public function test_route_validates_antibu_requires_capitals(): void
    {
        $admin = $this->admin();
        ['townA' => $townA, 'townB' => $townB] = $this->seedCatalog();

        $this->actingAs($admin)->post('/admin/routes', [
            'origin_id' => $townA->id,
            'destination_id' => $townB->id,
            'service_category' => 'antibu',
        ])->assertSessionHasErrors('origin_id');
    }

    public function test_route_validates_satset_requires_important(): void
    {
        $admin = $this->admin();
        ['townA' => $townA, 'townB' => $townB] = $this->seedCatalog();

        $this->actingAs($admin)->post('/admin/routes', [
            'origin_id' => $townA->id,
            'destination_id' => $townB->id,
            'service_category' => 'satset',
        ])->assertSessionHasErrors('origin_id');
    }

    public function test_admin_edits_route(): void
    {
        $admin = $this->admin();
        ['antibu' => $route, 'capitalA' => $capitalA, 'capitalB' => $capitalB] = $this->seedCatalog();

        $this->actingAs($admin)->get("/admin/routes/{$route->id}/edit")->assertOk()->assertSee('Ubah Rute');

        $this->actingAs($admin)->put("/admin/routes/{$route->id}", [
            'origin_id' => $capitalB->id,
            'destination_id' => $capitalA->id,
            'service_category' => 'antibu',
        ])->assertRedirect(route('admin.routes.index'));

        $this->assertDatabaseHas('routes', [
            'id' => $route->id,
            'origin_id' => $capitalB->id,
            'destination_id' => $capitalA->id,
        ]);
    }

    public function test_route_with_trips_cannot_be_deleted(): void
    {
        $admin = $this->admin();
        $this->seedCatalog();

        // Create a trip through the wizard on the biasane route
        $biasaneRoute = Route::where('service_category', 'biasane')->first();
        $bus = Bus::where('plate_number', 'ADM-40')->first();

        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $biasaneRoute->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        // Now try to delete the route that has a trip
        $this->actingAs($admin)->delete("/admin/routes/{$biasaneRoute->id}")
            ->assertRedirect(route('admin.routes.index'));

        $this->assertDatabaseHas('routes', ['id' => $biasaneRoute->id]);
    }

    public function test_route_without_trips_can_be_deleted(): void
    {
        $admin = $this->admin();
        ['capitalA' => $capitalA, 'capitalB' => $capitalB] = $this->seedCatalog();

        // Create a separate route with no trips
        $route = Route::create(['origin_id' => $capitalA->id, 'destination_id' => $capitalB->id, 'service_category' => 'biasane']);

        $this->actingAs($admin)->delete("/admin/routes/{$route->id}")
            ->assertRedirect(route('admin.routes.index'));

        $this->assertDatabaseMissing('routes', ['id' => $route->id]);
    }

    public function test_route_filter_by_service(): void
    {
        $admin = $this->admin();
        $this->seedCatalog();

        $this->actingAs($admin)->get('/admin/routes?service=antibu')
            ->assertOk()
            ->assertSee('ANTIBU');

        $this->actingAs($admin)->get('/admin/routes?service=biasane')
            ->assertOk()
            ->assertSee('BIASANE');
    }

    // ── Trip Edit/Delete Tests ────────────────────────────────────────

    public function test_admin_edits_trip_schedule_and_fares(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        // Create a trip first
        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        $trip = Trip::first();
        $this->assertNotNull($trip);

        // Edit the trip
        $this->actingAs($admin)->get("/admin/trips/{$trip->id}/edit")->assertOk()->assertSee('Ubah Trip');

        $this->actingAs($admin)->put("/admin/trips/{$trip->id}", [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(5)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(6)->format('Y-m-d H:i'),
            'fares' => ['Sukian' => 200000, 'SukianPlus' => 300000],
        ])->assertRedirect(route('admin.trips.index'));

        $trip->refresh();
        $this->assertEquals(200000, $trip->fares->where('class_name', 'Sukian')->first()->fare_amount);
        $this->assertEquals(300000, $trip->fares->where('class_name', 'SukianPlus')->first()->fare_amount);
    }

    public function test_trip_with_sold_seats_cannot_be_deleted(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        // Create a trip
        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        $trip = Trip::first();

        // Mark a seat as SOLD
        $trip->seats()->first()->update(['status' => \App\Enums\TripSeatStatus::SOLD]);

        $this->actingAs($admin)->delete("/admin/trips/{$trip->id}")
            ->assertRedirect(route('admin.trips.index'));

        $this->assertDatabaseHas('trips', ['id' => $trip->id]);
    }

    public function test_trip_without_bookings_can_be_deleted(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        // Create a trip
        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        $trip = Trip::first();
        $tripId = $trip->id;

        $this->actingAs($admin)->delete("/admin/trips/{$trip->id}")
            ->assertRedirect(route('admin.trips.index'));

        $this->assertDatabaseMissing('trips', ['id' => $tripId]);
        $this->assertDatabaseMissing('trip_seats', ['trip_id' => $tripId]);
        $this->assertDatabaseMissing('trip_fares', ['trip_id' => $tripId]);
    }

    public function test_trip_filter_by_service(): void
    {
        $admin = $this->admin();
        $this->seedCatalog();

        // Create a biasane trip
        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => Route::where('service_category', 'biasane')->first()->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => Bus::where('plate_number', 'ADM-40')->first()->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        $this->actingAs($admin)->get('/admin/trips?service=biasane')
            ->assertOk()
            ->assertSee('BIASANE');

        $this->actingAs($admin)->get('/admin/trips?service=antibu')
            ->assertOk()
            ->assertDontSee('ADM-40');
    }

    // ── Bus Status Lifecycle Tests ──────────────────────────────────────

    public function test_trip_creation_sets_bus_to_active(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $this->assertEquals('IDLE', $bus->fresh()->status->value);

        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'status' => 'ACTIVE']);
    }

    public function test_trip_deletion_reverts_bus_to_idle(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        // Create trip → bus becomes ACTIVE
        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'status' => 'ACTIVE']);

        $trip = Trip::first();
        $this->actingAs($admin)->delete("/admin/trips/{$trip->id}");

        // No other upcoming trips → bus reverts to IDLE
        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'status' => 'IDLE']);
    }

    public function test_trip_deletion_keeps_bus_active_if_other_upcoming_trips(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        // Create first trip → bus becomes ACTIVE
        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'status' => 'ACTIVE']);

        // Create second trip directly (bypass wizard bus status check)
        $secondTrip = Trip::create([
            'route_id' => $route->id,
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(5),
            'arrives_at' => now()->addDays(6),
        ]);

        $this->assertCount(2, Trip::all());

        // Delete first trip — bus still has second trip
        $firstTrip = Trip::orderBy('departs_at')->first();
        $this->actingAs($admin)->delete("/admin/trips/{$firstTrip->id}");

        // Bus stays ACTIVE because second trip still upcoming
        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'status' => 'ACTIVE']);
    }

    public function test_trip_deletion_preserves_maintenance_status(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        // Manually set bus to MAINTENANCE (skip ACTIVE step)
        $bus->update(['status' => \App\Enums\BusStatus::MAINTENANCE]);

        // Create trip via wizard (bypasses IDLE check on controller level for test)
        // Use the TripCreationService directly since wizard rejects non-IDLE buses
        $service = app(\App\Services\TripCreationService::class);
        $bus->update(['status' => \App\Enums\BusStatus::IDLE]); // Temporarily set IDLE to pass service validation
        $trip = $service->create([
            'service_category' => 'biasane',
            'route_id' => $route->id,
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);

        // Manually set bus to MAINTENANCE after trip creation
        $bus->update(['status' => \App\Enums\BusStatus::MAINTENANCE]);

        $this->actingAs($admin)->delete("/admin/trips/{$trip->id}");

        // Bus stays MAINTENANCE — delete should not override maintenance status
        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'status' => 'MAINTENANCE']);
    }

    public function test_trip_update_changes_bus_status_on_reassignment(): void
    {
        ['biasane' => $route, 'smallBus' => $smallBus] = $this->seedCatalog();
        $admin = $this->admin();

        // Create a second bus of same model (BIASANE)
        $secondBus = Bus::create(['plate_number' => 'ADM-40B', 'model_type' => 'BIASANE', 'status' => 'IDLE']);

        // Create trip with first bus → becomes ACTIVE
        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $smallBus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        $this->assertDatabaseHas('buses', ['id' => $smallBus->id, 'status' => 'ACTIVE']);

        // Update trip: change bus to secondBus
        $trip = Trip::first();
        $this->actingAs($admin)->put("/admin/trips/{$trip->id}", [
            'bus_id' => $secondBus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ])->assertRedirect(route('admin.trips.index'));

        // Old bus reverts to IDLE (no other upcoming trips)
        $this->assertDatabaseHas('buses', ['id' => $smallBus->id, 'status' => 'IDLE']);
        // New bus becomes ACTIVE
        $this->assertDatabaseHas('buses', ['id' => $secondBus->id, 'status' => 'ACTIVE']);
    }

    public function test_manual_status_change_to_idle_rejected_when_bus_has_upcoming_trips(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        // Create trip → bus becomes ACTIVE
        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'status' => 'ACTIVE']);

        // Try to manually change to IDLE — should be rejected
        $this->actingAs($admin)->patch("/admin/buses/{$bus->id}/status", ['status' => 'IDLE'])
            ->assertRedirect(route('admin.buses.index'))
            ->assertSessionHas('error');

        // Bus stays ACTIVE
        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'status' => 'ACTIVE']);
    }

    public function test_manual_status_change_to_maintenance_allowed_for_active_bus(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        // Create trip → bus becomes ACTIVE
        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        // Change to MAINTENANCE — should be allowed
        $this->actingAs($admin)->patch("/admin/buses/{$bus->id}/status", ['status' => 'MAINTENANCE'])
            ->assertRedirect(route('admin.buses.index'));

        $this->assertDatabaseHas('buses', ['id' => $bus->id, 'status' => 'MAINTENANCE']);
    }

    // ── Invoice Tests ───────────────────────────────────────────────────

    public function test_trip_code_is_auto_generated_on_creation(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        $trip = Trip::first();
        $this->assertNotEmpty($trip->trip_code);
        $this->assertMatchesRegularExpression('/^TRIP-\d{8}-[A-F0-9]{4}$/', $trip->trip_code);
    }

    public function test_trip_code_is_immutable(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($admin)->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($admin)->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($admin)->post('/admin/trips/create/step-5', []);

        $trip = Trip::first();
        $originalCode = $trip->trip_code;

        // Try to update trip_code
        $trip->update(['trip_code' => 'HACKED-CODE']);
        $trip->refresh();

        $this->assertEquals($originalCode, $trip->trip_code);
    }

    public function test_invoice_view_requires_confirmed_booking(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();

        // Create trip and booking (non-confirmed)
        $this->actingAs($this->admin())->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-5', []);

        $trip = Trip::first();
        $bookingService = app(BookingService::class);
        $booking = $bookingService->holdSeats($trip, ['C1'], [
            'passenger_name' => 'Test User',
            'passenger_email' => 'test@example.com',
            'passenger_phone' => '081234567890',
        ]);

        // Non-confirmed booking should 404
        $this->get(route('invoice.view', $booking->code))->assertNotFound();
    }

    public function test_invoice_view_renders_for_confirmed_booking(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();

        // Create trip
        $this->actingAs($this->admin())->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-5', []);

        $trip = Trip::first();
        $bookingService = app(BookingService::class);
        $booking = $bookingService->holdSeats($trip, ['C1'], [
            'passenger_name' => 'Test User',
            'passenger_email' => 'test@example.com',
            'passenger_phone' => '081234567890',
        ]);
        $bookingService->confirmBooking($booking);

        // Invoice view should render with all required fields
        $response = $this->get(route('invoice.view', $booking->code));
        $response->assertOk();
        $response->assertSee('INVOICE');
        $response->assertSee($booking->code);
        $response->assertSee($trip->trip_code);
        $response->assertSee($trip->bus->plate_number);
        $response->assertSee('Kode Transaksi');
        $response->assertSee('Kode Perjalanan');
        $response->assertSee('Plat Nomor Bus');
        $response->assertSee('LUNAS');
        $response->assertSee('Detail Harga');
        $response->assertSee('C1');
        $response->assertSee('Rp');
    }

    public function test_invoice_pdf_download(): void
    {
        ['biasane' => $route, 'smallBus' => $bus] = $this->seedCatalog();

        // Create trip
        $this->actingAs($this->admin())->post('/admin/trips/create/step-1', ['service_category' => 'biasane']);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-2', ['route_id' => $route->id]);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-3', [
            'bus_id' => $bus->id,
            'departs_at' => now()->addDays(2)->format('Y-m-d H:i'),
            'arrives_at' => now()->addDays(3)->format('Y-m-d H:i'),
        ]);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-4', [
            'fares' => ['Sukian' => 195000, 'SukianPlus' => 285000],
        ]);
        $this->actingAs($this->admin())->post('/admin/trips/create/step-5', []);

        $trip = Trip::first();
        $bookingService = app(BookingService::class);
        $booking = $bookingService->holdSeats($trip, ['C1'], [
            'passenger_name' => 'Test User',
            'passenger_email' => 'test@example.com',
            'passenger_phone' => '081234567890',
        ]);
        $bookingService->confirmBooking($booking);

        // PDF download should return PDF content
        $response = $this->get(route('invoice.download', $booking->code));
        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }
}
