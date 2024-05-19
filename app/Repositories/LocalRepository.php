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
        string $label,
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
                "label" => $label,
                "latitude" => $latitude,
                "longitude" => $longitude,
                "description" => $description,
                "date" => $date->format('Y-m-d')
            ];

            return Local::create($data);

        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function update(
        Local $local,
        LocalType $localType,
        String $label,
        ?String $latitude,
        ?String $longitude,
        ?String $description,
        Carbon $date
    ): bool
    {
        try {
            $data = [
                "local_type_id" => $localType->id,
                "label" => $label,
                "latitude" => $latitude ?? $local->latitude,
                "longitude" => $longitude ?? $local->longitude,
                "description" => $description ?? $local->description,
                "date" => optional($date)->format('Y-m-d') ?? $local->date
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
