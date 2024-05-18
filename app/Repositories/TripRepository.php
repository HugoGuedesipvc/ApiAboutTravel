<?php

namespace App\Repositories;


use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Throwable;

class TripRepository
{
    public function all(): Collection
    {
        try {
            return Trip::all();
        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function find($id): ?Trip
    {
        try {
            return Trip::findOrFail($id);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function store(
        User $user,
        string $name,
        ?string $country,
        ?string $location,
        Carbon $date,
        ?string $description,
        ?string $image,
        ?float $latitude,
        ?float $longitude,
        bool $shared
    ): ?Trip
    {
        try {
            $data = [
                "user_id" => $user->id,
                "name" => $name,
                "country" => $country,
                "location" => $location,
                "date" => $date,
                "description" => $description,
                "image" => $image,
                "latitude" => $latitude,
                "longitude" => $longitude,
                "shared" => $shared,
            ];

            return Trip::create($data);

        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function update(
         Trip $trip,
         User $user,
         string $name,
         ?string $country,
         ?string $location,
         Carbon $date,
         ?string $description,
         ?string $image,
         ?float $latitude,
         ?float $longitude,
         bool $shared
    ): bool
    {
        try {
            $data = [
                "user_id" => $user->id,
                "name" => $name,
                "country" => $country,
                "location" => $location,
                "date" => $date,
                "description" => $description,
                "image" => $image,
                "latitude" => $latitude,
                "longitude" => $longitude,
                "shared" => $shared,
            ];

            return $trip->update($data);

        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function delete(Trip $trip): bool
    {
        try {
            return $trip->delete();
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
