<?php

namespace Database\Seeders\Dev;

use App\Models\Local;
use Illuminate\Database\Seeder;

class DevLocalSeeder extends Seeder
{
    public function run(): void
    {
        Local::factory()
            ->count(30)
            ->create();
    }
}
