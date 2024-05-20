<?php

namespace Database\Seeders\Dev;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevUserSharedTripSeeder extends Seeder
{
    public function run(): void
    {
        Trip::inRandomOrder()
            ->limit(10)
            ->get()
            ->each(function (Trip $trip) {
                $user = User::inRandomOrder()->whereNot('id', $trip->user_id)->first();
                $trip->userSharedTrips()->attach($user);
            });
    }
}
