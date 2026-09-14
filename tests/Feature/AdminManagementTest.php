<?php

namespace Tests\Feature;

use App\Models\Bus;
use App\Models\Location;
use App\Models\Route;
use App\Models\Trip;
use App\Models\User;
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
        ])->assertRedirect(route('admin.trips.index'));

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
        ])->assertRedirect(route('admin.trips.index'));

        $trip = Trip::first();
        $this->assertCount(3, $trip->fares);
        $this->assertCount(30, $trip->seats);
        $this->assertEquals(9, $trip->seats()->where('class_name', 'SukianPro')->count());
    }

    public function test_wizard_steps_cannot_be_skipped(): void
    {
        $this->actingAs($this->admin())->get('/admin/trips/create/3')
            ->assertRedirect(route('admin.trips.create', ['step' => 1]));

        $this->actingAs($this->admin())->get('/admin/trips/create/9')->assertNotFound();
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
    }

    public function test_validation_errors_rerender_forms(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post('/admin/trips/create/step-1', ['service_category' => '']);
        $response->assertSessionHasErrors('service_category');
        $this->actingAs($admin)->get('/admin/trips/create/1')->assertOk()->assertSee('Pilih layanan');
    }
}
