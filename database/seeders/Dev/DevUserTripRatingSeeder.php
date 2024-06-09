<?php

namespace Database\Seeders\Dev;

use App\Models\Trip;
use Illuminate\Database\Seeder;

class DevUserTripRatingSeeder extends Seeder
{
    public function run(): void
    {
        Trip::where('shared', true)
            ->inRandomOrder()
            ->limit(10)
            ->get()
            ->each(function (Trip $trip) {
                $userIds = $trip->userSharedTrips->pluck('id')->toArray();
                $userIds[] = $trip->user_id;

                $trip->ratings()->attach(
                    collect($userIds)->random(),
                    ['rating' => rand(1, 5)]
                );
            });
    }
}
