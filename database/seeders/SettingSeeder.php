<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'store_name' => 'Andara Motor',
            'store_tagline' => 'Showroom Motor Bekas Berkualitas, Surat Lengkap & Transparan',
            'store_address' => 'Jl. Kaliurang, Sleman, Yogyakarta',
            'whatsapp_number' => '6281234567890',
            'opening_hours' => 'Senin - Sabtu, 08:30 - 17:30 WIB',
            'instagram_url' => '',
            'facebook_url' => '',
            'tiktok_url' => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}