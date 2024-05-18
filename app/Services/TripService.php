<?php

namespace App\Services;


use App\Models\Trip;
use App\Models\User;
use App\Repositories\TripRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Throwable;

class TripService
{
    public function __construct(
        protected TripRepository $tripRepository
    )
    {
    }

    public function all(): Collection
    {
        return $this->tripRepository
            ->all();
    }

    public function find($id): ?Trip
    {
        return $this->tripRepository
            ->find($id);
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
        return $this->tripRepository
            ->store(
                $user,
                $name,
                $country,
                $location,
                $date,
                $description,
                $image,
                $latitude,
                $longitude,
                $shared
            );
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
        return $this->tripRepository
            ->update(
                $trip,
                $user,
                $name,
                $country,
                $location,
                $date,
                $description,
                $image,
                $latitude,
                $longitude,
                $shared
            );
    }

    public function delete(Trip $trip): bool
    {
        return $this->tripRepository
            ->delete(
                $trip
            );
    }
}
