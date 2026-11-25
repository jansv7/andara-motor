<?php

use App\Models\Brand;
use App\Models\Motorcycle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('guest can access home and catalog without login', function (): void {
    $brand = Brand::factory()->create(['name' => 'Honda', 'slug' => 'honda']);
    $motorcycle = Motorcycle::factory()->create([
        'brand_id' => $brand->id,
        'model' => 'Vario 160',
        'status' => 'available',
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Andara Motor')
        ->assertSee('Honda Vario 160');

    $this->get(route('catalog.index'))
        ->assertOk()
        ->assertSee('Honda Vario 160')
        ->assertSee($motorcycle->code);
});

test('register route does not exist and guest cannot access owner panel', function (): void {
    $this->get('/register')->assertNotFound();
    $this->get(route('owner.dashboard'))->assertRedirect(route('login'));
    $this->get(route('owner.brands.index'))->assertRedirect(route('login'));
    $this->get(route('owner.motorcycles.index'))->assertRedirect(route('login'));
});

test('owner can login with valid credentials and fails with wrong password', function (): void {
    $owner = User::factory()->create([
        'email' => 'owner@andaramotor.test',
        'password' => 'secret123',
    ]);

    $this->post(route('login.store'), [
        'email' => 'owner@andaramotor.test',
        'password' => 'wrong-password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();

    $this->post(route('login.store'), [
        'email' => 'owner@andaramotor.test',
        'password' => 'secret123',
    ])->assertRedirect(route('owner.dashboard'));

    $this->assertAuthenticatedAs($owner);
});

test('owner can create brand and cannot delete brand that still has motorcycles', function (): void {
    $owner = User::factory()->create();

    $this->actingAs($owner)
        ->post(route('owner.brands.store'), ['name' => 'Vespa'])
        ->assertRedirect(route('owner.brands.index'))
        ->assertSessionHas('success');

    $brand = Brand::query()->where('slug', 'vespa')->firstOrFail();

    Motorcycle::factory()->create(['brand_id' => $brand->id]);

    $this->actingAs($owner)
        ->delete(route('owner.brands.destroy', $brand))
        ->assertRedirect(route('owner.brands.index'))
        ->assertSessionHas('error');

    expect(Brand::query()->whereKey($brand->id)->exists())->toBeTrue();
});

test('owner can create motorcycle with auto code and photo then it appears publicly without purchase price', function (): void {
    Storage::fake('public');

    $owner = User::factory()->create();
    $brand = Brand::factory()->create(['name' => 'Yamaha', 'slug' => 'yamaha']);

    $response = $this->actingAs($owner)->post(route('owner.motorcycles.store'), [
        'brand_id' => $brand->id,
        'model' => 'NMAX Turbo',
        'category' => 'matic',
        'year' => 2024,
        'color' => 'Hitam',
        'engine_cc' => 155,
        'transmission' => 'matic',
        'mileage' => 8400,
        'plate_region' => 'ab',
        'setting_condition' => 'standar',
        'has_bpkb' => '1',
        'has_stnk' => '1',
        'has_faktur' => '1',
        'tax_expired_at' => now()->addYear()->toDateString(),
        'warranty' => 'Garansi mesin 1 bulan',
        'purchase_price' => 25123456,
        'purchase_date' => now()->subDays(3)->toDateString(),
        'selling_price' => 28900000,
        'is_negotiable' => '1',
        'photo' => UploadedFile::fake()->image('nmax.jpg', 800, 600),
    ]);

    $response->assertRedirect(route('owner.motorcycles.index'))
        ->assertSessionHas('success');

    $motorcycle = Motorcycle::query()->where('model', 'NMAX Turbo')->firstOrFail();

    expect($motorcycle->code)->toStartWith('MTR-')
        ->and($motorcycle->plate_region)->toBe('AB')
        ->and($motorcycle->photos()->count())->toBe(1);

    Storage::disk('public')->assertExists($motorcycle->photos()->first()->path);

    $catalogResponse = $this->get(route('catalog.index'));
    $catalogResponse->assertOk()
        ->assertSee('Yamaha NMAX Turbo')
        ->assertSee('Rp 28.900.000')
        ->assertDontSee('25.123.456')
        ->assertDontSee('25123456');

    $detailResponse = $this->get(route('catalog.show', $motorcycle->slug));
    $detailResponse->assertOk()
        ->assertSee('Yamaha NMAX Turbo')
        ->assertSee('wa.me/')
        ->assertSee(rawurlencode($motorcycle->code))
        ->assertDontSee('25.123.456')
        ->assertDontSee('25123456');
});

test('sold unit is hidden from catalog and shows sold notice on direct detail link', function (): void {
    $brand = Brand::factory()->create(['name' => 'Suzuki', 'slug' => 'suzuki']);
    $soldUnit = Motorcycle::factory()->create([
        'brand_id' => $brand->id,
        'model' => 'GSX-R150 Terjual',
        'status' => 'sold',
        'tax_expired_at' => now()->subMonth()->toDateString(),
    ]);

    $this->get(route('catalog.index'))
        ->assertOk()
        ->assertDontSee('GSX-R150 Terjual');

    $this->get(route('catalog.show', $soldUnit->slug))
        ->assertOk()
        ->assertSee('UNIT INI SUDAH TERJUAL')
        ->assertSee('Pajak Mati');
});

test('owner cannot delete sold motorcycle or set status sold manually', function (): void {
    $owner = User::factory()->create();
    $brand = Brand::factory()->create();
    $available = Motorcycle::factory()->create([
        'brand_id' => $brand->id,
        'status' => 'available',
    ]);
    $sold = Motorcycle::factory()->create([
        'brand_id' => $brand->id,
        'status' => 'sold',
    ]);

    $this->actingAs($owner)
        ->patch(route('owner.motorcycles.status', $available), ['status' => 'sold'])
        ->assertSessionHasErrors('status');

    $this->actingAs($owner)
        ->delete(route('owner.motorcycles.destroy', $sold))
        ->assertRedirect(route('owner.motorcycles.index'))
        ->assertSessionHas('error');

    expect($sold->fresh()->trashed())->toBeFalse();
});
