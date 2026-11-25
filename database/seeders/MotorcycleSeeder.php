<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Motorcycle;
use App\Models\MotorcyclePhoto;
use Illuminate\Database\Seeder;

class MotorcycleSeeder extends Seeder
{
    public function run(): void
    {
        if (Motorcycle::query()->exists()) {
            return;
        }

        $brands = Brand::query()->pluck('id', 'slug');

        $units = [
            [
                'brand_slug' => 'yamaha',
                'model' => 'NMAX 155 Connected',
                'category' => 'matic',
                'year' => 2022,
                'color' => 'Hitam Glossy',
                'engine_cc' => 155,
                'transmission' => 'matic',
                'mileage' => 14200,
                'plate_region' => 'AB',
                'setting_condition' => 'standar',
                'modification_notes' => null,
                'engine_ever_opened' => false,
                'engine_notes' => null,
                'has_bpkb' => true,
                'has_stnk' => true,
                'has_faktur' => true,
                'tax_expired_at' => '2027-08-15',
                'warranty' => 'Garansi mesin 1 bulan',
                'description' => 'Unit tangan pertama pemakaian dalam kota Yogyakarta. Mesin halus, CVT responsif, ban depan dan belakang masih tebal.',
                'purchase_price' => 24500000,
                'purchase_date' => '2026-11-05',
                'purchase_source' => 'Perorangan (Sleman)',
                'selling_price' => 27400000,
                'is_negotiable' => true,
                'status' => 'available',
                'is_featured' => true,
                'photo' => 'images/motorcycles/photo-f44715247-960.jpg',
            ],
            [
                'brand_slug' => 'honda',
                'model' => 'Vario 160 CBS',
                'category' => 'matic',
                'year' => 2023,
                'color' => 'Putih Mutiara',
                'engine_cc' => 160,
                'transmission' => 'matic',
                'mileage' => 11850,
                'plate_region' => 'AB',
                'setting_condition' => 'standar',
                'modification_notes' => null,
                'engine_ever_opened' => false,
                'engine_notes' => null,
                'has_bpkb' => true,
                'has_stnk' => true,
                'has_faktur' => true,
                'tax_expired_at' => '2027-06-20',
                'warranty' => 'Garansi mesin 1 bulan',
                'description' => 'Kunci keyless lengkap dua remot, body mulus tanpa bekas jatuh, kelistrikan dan panel meter normal sepenuhnya.',
                'purchase_price' => 20200000,
                'purchase_date' => '2026-11-10',
                'purchase_source' => 'Perorangan (Kota Yogyakarta)',
                'selling_price' => 22800000,
                'is_negotiable' => true,
                'status' => 'available',
                'is_featured' => true,
                'photo' => 'images/motorcycles/photo-f105187321-960.jpg',
            ],
            [
                'brand_slug' => 'honda',
                'model' => 'PCX 150 ABS',
                'category' => 'matic',
                'year' => 2020,
                'color' => 'Putih Elegan',
                'engine_cc' => 150,
                'transmission' => 'matic',
                'mileage' => 23500,
                'plate_region' => 'AD',
                'setting_condition' => 'modifikasi_ringan',
                'modification_notes' => 'Tambahan windshield touring dan box belakang copot-pasang.',
                'engine_ever_opened' => false,
                'engine_notes' => null,
                'has_bpkb' => true,
                'has_stnk' => true,
                'has_faktur' => true,
                'tax_expired_at' => '2027-04-12',
                'warranty' => 'Garansi mesin 1 bulan',
                'description' => 'Cocok untuk perjalanan jauh maupun harian. Rem ABS bekerja normal, oli mesin dan oli gardan baru diganti.',
                'purchase_price' => 21000000,
                'purchase_date' => '2026-11-02',
                'purchase_source' => 'Tukar Tambah',
                'selling_price' => 23900000,
                'is_negotiable' => true,
                'status' => 'booked',
                'is_featured' => true,
                'photo' => 'images/motorcycles/photo-f130098625-500.jpg',
            ],
            [
                'brand_slug' => 'suzuki',
                'model' => 'GSX-R150 Keyless',
                'category' => 'sport',
                'year' => 2021,
                'color' => 'Oranye Hitam',
                'engine_cc' => 150,
                'transmission' => 'kopling',
                'mileage' => 16400,
                'plate_region' => 'AB',
                'setting_condition' => 'standar',
                'modification_notes' => null,
                'engine_ever_opened' => false,
                'engine_notes' => null,
                'has_bpkb' => true,
                'has_stnk' => true,
                'has_faktur' => false,
                'tax_expired_at' => '2026-09-10',
                'warranty' => 'Garansi mesin 1 bulan',
                'description' => 'Fairing utuh, mesin DOHC bertenaga dan kering tanpa rembesan oli. Pajak terakhir September 2026, bisa dibantu proses perpanjangan.',
                'purchase_price' => 16800000,
                'purchase_date' => '2026-11-12',
                'purchase_source' => 'Perorangan (Bantul)',
                'selling_price' => 19500000,
                'is_negotiable' => false,
                'status' => 'available',
                'is_featured' => true,
                'photo' => 'images/motorcycles/photo-f152528080-960.jpg',
            ],
            [
                'brand_slug' => 'kawasaki',
                'model' => 'W175 SE Cruiser',
                'category' => 'sport',
                'year' => 2022,
                'color' => 'Hitam Metalik',
                'engine_cc' => 177,
                'transmission' => 'kopling',
                'mileage' => 9800,
                'plate_region' => 'AA',
                'setting_condition' => 'modifikasi_ringan',
                'modification_notes' => 'Jok custom jahitan rapi dan sandaran penumpang belakang.',
                'engine_ever_opened' => false,
                'engine_notes' => null,
                'has_bpkb' => true,
                'has_stnk' => true,
                'has_faktur' => true,
                'tax_expired_at' => '2027-10-01',
                'warranty' => 'Garansi mesin 1 bulan',
                'description' => 'Kilometer rendah, simpanan garasi, rangka lurus, kaki-kaki empuk dan siap langsung dipakai touring.',
                'purchase_price' => 22500000,
                'purchase_date' => '2026-11-14',
                'purchase_source' => 'Perorangan (Magelang)',
                'selling_price' => 25900000,
                'is_negotiable' => true,
                'status' => 'available',
                'is_featured' => true,
                'photo' => 'images/motorcycles/photo-f193629767-960.jpg',
            ],
        ];

        foreach ($units as $unit) {
            $photoPath = $unit['photo'];
            $brandSlug = $unit['brand_slug'];
            unset($unit['photo'], $unit['brand_slug']);

            $unit['brand_id'] = $brands[$brandSlug] ?? $brands->first();

            $motorcycle = Motorcycle::query()->create($unit);

            MotorcyclePhoto::query()->create([
                'motorcycle_id' => $motorcycle->id,
                'path' => $photoPath,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }
    }
}
