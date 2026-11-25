<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'owner@andaramotor.test'],
            [
                'name' => 'Pemilik Andara Motor',
                'password' => 'password123',
                'email_verified_at' => now(),
            ]
        );
    }
}
