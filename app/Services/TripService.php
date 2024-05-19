<?php

namespace App\Services;


use App\Models\Country;
use App\Models\Trip;
use App\Models\User;
use App\Repositories\TripRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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
        User     $user,
        string   $label,
        ?Country $country,
        ?string  $location,
        Carbon   $date,
        ?string  $description,
        ?string  $image,
        ?float   $latitude,
        ?float   $longitude,
        bool     $shared = false
    ): ?Trip
    {
        return $this->tripRepository
            ->store(
                $user,
                $label,
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
        Trip     $trip,
        string   $name,
        ?Country $country,
        ?string  $location,
        Carbon   $date,
        ?string  $description,
        ?string  $image,
        ?float   $latitude,
        ?float   $longitude,
        ?bool    $shared = null
    ): bool
    {
        return $this->tripRepository
            ->update(
                $trip,
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

    public function getTripShared(): Collection
    {
        return $this->tripRepository
            ->getTripShared();
    }
}
