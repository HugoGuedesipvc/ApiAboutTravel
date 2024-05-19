<?php

namespace App\Services;


use App\Models\LocalType;
use App\Repositories\LocalTypeRepository;
use Illuminate\Support\Collection;
use Throwable;

class LocalTypeService
{
    public function __construct(
        protected LocalTypeRepository $localTypeRepository
    )
    {
    }

    public function all(): Collection
    {
        return $this->localTypeRepository
            ->all();
    }

    public function find($id): ?LocalType
    {
        return $this->localTypeRepository
            ->find($id);
    }

    public function store(
        string $label,
        ?string $description,
    ): ?LocalType
    {
        return $this->localTypeRepository
            ->store(
                $label,
                $description
            );
    }

    public function update(
        LocalType $localType,
        string $label,
        string $description
    ): bool
    {
        return $this->localTypeRepository
            ->update(
                $localType,
                $label,
                $description
            );
    }

    public function delete(LocalType $localType): bool
    {
        return $this->localTypeRepository
            ->delete(
                $localType
            );
    }
}
