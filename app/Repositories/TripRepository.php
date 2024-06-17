<?php

namespace App\Repositories;


use App\Models\Country;
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

    public function getTripAmount($number): Collection
    {
        try {
            return Trip::paginate($number);
        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function paginate($page, $amount = 20): Collection
    {
        try {
            return Trip::paginate();
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
        User     $user,
        string   $label,
        ?Country $country,
        ?string  $location,
        Carbon   $intialDate,
        Carbon   $endDate,
        ?string  $description,
        ?string  $image,
        ?float   $latitude,
        ?float   $longitude,
        bool     $shared = false
    ): ?Trip
    {
        try {
            $data = [
                "user_id" => $user->id,
                "label" => $label,
                "country_id" => optional($country)->id,
                "location" => $location,
                "initialDate" => $intialDate->format('Y-m-d'),
                "endDate" => $endDate->format('Y-m-d'),
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
        try {
            $data = [
                "label" => $label ?? $trip->label,
                "country_id" => optional($country)->id ?? $trip->country_id,
                "location" => $location ?? $trip->location,
                "initialDate" => optional($initialDate)->format('Y-m-d') ?? $trip->date,
                "endDate" => optional($endDate)->format('Y-m-d') ?? $trip->date,
                "description" => $description ?? $trip->description,
                "image" => $image ?? $trip->image,
                "latitude" => $latitude ?? $trip->latitude,
                "longitude" => $longitude ?? $trip->longitude,
                "shared" => $shared ?? $trip->shared,
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

    public function getTripShared(): Collection
    {
        try {
            return Trip::isShared()->get();
        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }
}
