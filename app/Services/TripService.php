<?php

namespace App\Services;


use App\Models\Country;
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
        User     $user,
        string   $label,
        ?Country $country,
        ?string  $location,
        ?Carbon  $initialDate,
        ?Carbon  $endDate,
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
                $initialDate,
                $endDate,
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
            shared: $shared
        );
    }

    public function update(
        Trip     $trip,
        ?string  $label = null,
        ?Country $country = null,
        ?string  $location = null,
        ?Carbon  $initialDate = null,
        ?Carbon  $endDate = null,
        ?string  $description = null,
        ?string  $image = null,
        ?float   $latitude = null,
        ?float   $longitude = null,
        ?bool    $shared = null
    ): bool
    {
        return $this->tripRepository
            ->update(
                $trip,
                $label,
                $country,
                $location,
                $initialDate,
                $endDate,
                $description,
                $image,
                $latitude,
                $longitude,
                $shared
            );
    }

    public function attachUserSharedTrip(Trip $trip, User $user): bool
    {
        try {
            $trip->userSharedTrips()->attach($user);
            $this->update($trip, shared: true);

            return true;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function detachUserSharedTrip(Trip $trip, User $user): bool
    {
        try {
            $trip->userSharedTrips()->detach($user);

            if ($trip->userSharedTrips()->get()->isEmpty()) {
                $this->update($trip, shared: false);
            }

            return true;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function attachRating(Trip $trip, User $user, int $rating = 0): bool
    {
        try {
            $trip->ratings()
                ->attach($user, ['rating' => $rating]);
            return true;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function updateRating(Trip $trip, User $user, int $rating = 0): bool
    {
        try {
            $trip->ratings()
                ->updateExistingPivot($user, ['rating' => $rating]);

            return true;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function detachRating(Trip $trip, User $user): bool
    {
        try {
            $trip->ratings()
                ->detach($user);
            return true;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
