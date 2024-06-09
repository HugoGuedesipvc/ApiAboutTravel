<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Dev\DevLocalSeeder;
use Database\Seeders\Dev\DevLocalTypeSeeder;
use Database\Seeders\Dev\DevTripSeeder;
use Database\Seeders\Dev\DevUserLocalRatingSeeder;
use Database\Seeders\Dev\DevUserSeeder;
use Database\Seeders\Dev\DevUserSharedTripSeeder;
use Database\Seeders\Dev\DevUserTripRatingSeeder;
use Database\Seeders\Template\CountriesSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected string $type;

    public function __construct()
    {
        $this->type = config('database.seeders.type');
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (in_array($this->type, ['all', 'template'])) {
            $this->template();
        }

        if (in_array($this->type, ['all', 'dev'])) {
            $this->development();
        }

        if (in_array($this->type, ['all', 'prod'])) {
            $this->prod();
        }
    }

    public function template(): void
    {
        $this->call([
            CountriesSeeder::class
        ]);
    }

    public function development(): void
    {
        $this->call([
            DevUserSeeder::class,
            DevLocalTypeSeeder::class,
            DevTripSeeder::class,
            DevLocalSeeder::class,
            DevUserSharedTripSeeder::class,
            DevUserTripRatingSeeder::class,
            DevUserLocalRatingSeeder::class
        ]);
    }

    public function prod(): void
    {
    }
}
