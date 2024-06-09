<?php

namespace Database\Seeders\Dev;

use App\Models\Trip;
use Illuminate\Database\Seeder;

class DevTripSeeder extends Seeder
{
    public function run(): void
    {
        Trip::factory()
            ->count(12)
            ->create();
    }
}
