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

    public function delete(Trip $trip): bool
    {
        $trip->userSharedTrips()->sync([]);
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

    public function updateShared(Trip $trip, bool $shared): bool
    {

        return $this->update(
            $trip,
            null, // label
            null, // country
            null, // location
            null, // date
            null, // description
            null, // image
            null, // latitude
            null, // longitude
            $shared // shared
        );
    }

    public function update(
        Trip     $trip,
        ?string  $label,
        ?Country $country,
        ?string  $location,
        ?Carbon  $date,
        ?string  $description,
        ?string  $image,
        ?float   $latitude,
        ?float   $longitude,
        ?bool    $shared
    ): bool
    {
        return $this->tripRepository
            ->update(
                $trip,
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
}
