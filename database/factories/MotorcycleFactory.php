<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Motorcycle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Motorcycle>
 */
class MotorcycleFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $purchasePrice = fake()->numberBetween(8, 26) * 1_000_000;
        $sellingPrice = $purchasePrice + fake()->numberBetween(15, 35) * 100_000;

        return [
            'brand_id' => Brand::factory(),
            'model' => fake()->randomElement(['Vario 150', 'Beat Deluxe', 'NMAX 155', 'Scoopy Prestige', 'CB150R', 'Aerox 155']),
            'category' => fake()->randomElement(['matic', 'bebek', 'sport', 'trail']),
            'year' => fake()->numberBetween(2018, 2025),
            'color' => fake()->randomElement(['Hitam Doff', 'Putih Mutiara', 'Merah Marun', 'Abu-abu Metalik', 'Biru Tua']),
            'engine_cc' => fake()->randomElement([110, 125, 150, 155, 160, 250]),
            'transmission' => fake()->randomElement(['matic', 'manual', 'kopling']),
            'mileage' => fake()->numberBetween(4500, 48000),
            'plate_region' => fake()->randomElement(['AB', 'AD', 'AA', 'B', 'H']),
            'setting_condition' => 'standar',
            'modification_notes' => null,
            'engine_ever_opened' => false,
            'engine_notes' => null,
            'has_bpkb' => true,
            'has_stnk' => true,
            'has_faktur' => true,
            'tax_expired_at' => now()->addMonths(fake()->numberBetween(3, 18))->toDateString(),
            'warranty' => 'Garansi mesin 1 bulan',
            'description' => 'Unit terawat, mesin halus, servis rutin, siap pakai harian.',
            'purchase_price' => $purchasePrice,
            'purchase_date' => now()->subDays(fake()->numberBetween(5, 45))->toDateString(),
            'purchase_source' => 'Perorangan',
            'selling_price' => $sellingPrice,
            'is_negotiable' => true,
            'status' => 'available',
            'is_featured' => false,
            'views' => 0,
        ];
    }
}
