<?php

namespace App\Services;


use App\Models\Local;
use App\Models\LocalType;
use App\Models\Trip;
use App\Repositories\LocalRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Throwable;

class LocalService
{
    public function __construct(
        protected LocalRepository $localRepository
    )
    {
    }

    public function all(): Collection
    {
        return $this->localRepository
            ->all();
    }

    public function find($id): ?Local
    {
        return $this->localRepository
            ->find($id);
    }

    public function store(
        Trip $trip,
        LocalType $localType,
        string $label,
        ?float $latitude,
        ?float $longitude,
        ?string $description,
        Carbon $date
    ): ?Local
    {
        return $this->localRepository
            ->store(
                 $trip,
                 $localType,
                 $label,
                 $latitude,
                 $longitude,
                 $description,
                 $date
            );
    }

    public function update(
        Local $local,
        LocalType $localType,
        string $label,
        ?float $latitude,
        ?float $longitude,
        ?string $description,
        Carbon $date
    ): bool
    {
        return $this->localRepository
            ->update(
                $local,
                $localType,
                $label,
                $latitude,
                $longitude,
                $description,
                $date
            );
    }

    public function delete(Local $local): bool
    {
        return $this->localRepository
            ->delete(
                $local
            );
    }
}
