<?php

namespace Database\Seeders\Dev;

use App\Models\LocalType;
use Illuminate\Database\Seeder;

class DevLocalTypeSeeder extends Seeder
{
    public function run(): void
    {
        LocalType::factory()
            ->count(10)
            ->create();
    }
}
