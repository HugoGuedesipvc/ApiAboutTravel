<?php

namespace Database\Seeders\Dev;

use App\Models\Local;
use Illuminate\Database\Seeder;

class DevUserLocalRatingSeeder extends Seeder
{
    public function run(): void
    {
        Local::inRandomOrder()
            ->limit(10)
            ->get()
            ->each(function (Local $local) {
                $userIds = $local->trip->userSharedTrips->pluck('id')->toArray();
                $userIds[] = $local->trip->user_id;

                $local->ratings()->attach(
                    collect($userIds)->random(),
                    ['rating' => rand(1, 5)]
                );
            });
    }
}
