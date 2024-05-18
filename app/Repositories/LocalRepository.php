<?php

namespace App\Repositories;


use App\Models\Local;
use App\Models\LocalType;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Throwable;

class LocalRepository
{
    public function all(): Collection
    {
        try {
            return Local::all();
        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function find($id): ?Local
    {
        try {
            return Local::findOrFail($id);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function store(
        Trip $trip,
        LocalType $localType,
        string $name,
        ?float $latitude,
        ?float $longitude,
        string $description,
        Carbon $date
    ): ?Local
    {
        try {
            $data = [
                "trip_id" => $trip->id,
                "local_type_id" => $localType->id,
                "name" => $name,
                "latitude" => $latitude,
                "longitude" => $longitude,
                "description" => $description,
                "date" => $date
            ];

            return Local::create($data);

        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function update(
        Local $local,
        Trip $trip,
        LocalType $localType,
        String $name,
        ?String $latitude,
        ?String $longitude,
        ?String $description,
        Carbon $date
    ): bool
    {
        try {
            $data = [
                "trip_id" => $trip->id,
                "local_type_id" => $localType->id,
                "name" => $name,
                "latitude" => $latitude,
                "longitude" => $longitude,
                "description" => $description,
                "date" => $date
            ];

            return $local->update($data);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function delete(Local $local): bool
    {
        try {
            return $local->delete();
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
